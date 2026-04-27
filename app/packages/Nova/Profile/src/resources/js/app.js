document.addEventListener('DOMContentLoaded', () => {

    /* 1. Sidebar toggle (dùng chung) */
    const sidebar       = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const avatarBtn     = document.getElementById('sidebar-avatar-btn');
    const userMenu      = document.getElementById('user-menu');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('expanded');
        });
    }

    if (avatarBtn && userMenu) {
        avatarBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('open');

            if (userMenu.classList.contains('open') && sidebar) {
                const rect = avatarBtn.getBoundingClientRect();
                userMenu.style.top = rect.top + 'px';
            }
        });

        document.addEventListener('click', () => {
            userMenu.classList.remove('open');
        });

        userMenu.addEventListener('click', (e) => e.stopPropagation());
    }

    /* 2. SPA Tab switching */
    const tabs   = document.querySelectorAll('.profile-tab');
    const panels = document.querySelectorAll('.profile-tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            panels.forEach(p => {
                if (p.id === 'panel-' + target) {
                    p.classList.add('active');
                } else {
                    p.classList.remove('active');
                }
            });

            /* Đổi action button: tab bảo mật không cần nút Lưu thay đổi ở topbar */
            const saveBtn = document.querySelector('.btn-profile-save[form="profile-form"]');
            if (saveBtn) {
                saveBtn.style.display = target === 'ho-so' ? '' : 'none';
            }
        });
    });

    /* 3. Avatar preview trước khi upload */
    const avatarInput = document.getElementById('avatar-input');
    const avPreview   = document.getElementById('av-preview');

    if (avatarInput && avPreview) {
        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            /* Validate: chỉ nhận ảnh, tối đa 2MB */
            if (!file.type.startsWith('image/')) {
                alert('Vui lòng chọn file ảnh hợp lệ.');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Ảnh không được vượt quá 2MB.');
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                avPreview.innerHTML = `<img src="${ev.target.result}" alt="avatar"/>`;
            };
            reader.readAsDataURL(file);
        });
    }

    /* 4. Auto-dismiss flash alert */
    const alerts = document.querySelectorAll('.profile-alert-success, .profile-alert-error');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.4s ease';
            setTimeout(() => alert.remove(), 400);
        }, 4000);
    });

    /* 5. Confirm xoá tài khoản */
    const btnDelete = document.getElementById('btn-delete-account');
    if (btnDelete) {
        btnDelete.addEventListener('click', () => {
            const confirmed = confirm(
                'Bạn có chắc chắn muốn xoá tài khoản?\nHành động này KHÔNG THỂ hoàn tác.'
            );
            if (confirmed) {
                /* Gửi request DELETE — tạo form động */
                const form   = document.createElement('form');
                form.method  = 'POST';
                form.action  = '/profile/delete';

                const csrf   = document.createElement('input');
                csrf.type    = 'hidden';
                csrf.name    = '_token';
                csrf.value   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

                const method = document.createElement('input');
                method.type  = 'hidden';
                method.name  = '_method';
                method.value = 'DELETE';

                form.appendChild(csrf);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
});