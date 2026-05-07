import '../../../../Core/src/resources/js/nova-ui.js';

document.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash?.replace('#', '');
    if (hash) {
        const matchTab = document.querySelector(`.profile-tab[data-tab="${hash}"]`);
        if (matchTab) matchTab.click();
    }

    if (window.__profileSuccess) {
        novaToast(window.__profileSuccess, 'success');
    }

    if (Array.isArray(window.__profileErrors)) {
        window.__profileErrors.forEach((message, index) => {
            if (!message) return;
            setTimeout(() => novaToast(message, 'error', 4200), index * 180);
        });
    }

    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const avatarBtn = document.getElementById('sidebar-avatar-btn');
    const userMenu = document.getElementById('user-menu');

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

    const tabs = document.querySelectorAll('.profile-tab');
    const panels = document.querySelectorAll('.profile-tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');

            panels.forEach(panel => {
                panel.classList.toggle('active', panel.id === 'panel-' + target);
            });

            const saveBtn = document.querySelector('.btn-profile-save[form="profile-form"]');
            if (saveBtn) {
                saveBtn.style.display = target === 'ho-so' ? '' : 'none';
            }
        });
    });

    const avatarInput = document.getElementById('avatar-input');
    const avPreview = document.getElementById('av-preview');

    if (avatarInput && avPreview) {
        avatarInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                novaToast('Vui lòng chọn file ảnh hợp lệ.', 'error');
                avatarInput.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                novaToast('Ảnh không được vượt quá 2MB.', 'warning');
                avatarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                avPreview.innerHTML = `<img src="${ev.target.result}" alt="avatar"/>`;
            };
            reader.readAsDataURL(file);
        });
    }

    const btnDelete = document.getElementById('btn-delete-account');
    if (btnDelete) {
        btnDelete.addEventListener('click', async () => {
            const confirmed = await novaConfirm({
                title: 'Xoá tài khoản?',
                message: 'Hành động này không thể hoàn tác. Toàn bộ dữ liệu của tài khoản sẽ bị xoá vĩnh viễn.',
                confirmText: 'Xoá ngay',
                cancelText: 'Huỷ',
                type: 'danger',
            });

            if (!confirmed) return;

            novaToast('Đang xử lý yêu cầu xoá tài khoản...', 'warning', 1200);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/profile';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';

            form.appendChild(csrf);
            form.appendChild(method);
            document.body.appendChild(form);

            setTimeout(() => form.submit(), 400);
        });
    }

    document.querySelectorAll('[data-logout]').forEach(link => {
        link.addEventListener('click', async (e) => {
            e.preventDefault();

            const confirmed = await novaConfirm({
                title: 'Đăng xuất',
                message: 'Bạn có chắc chắn muốn đăng xuất khỏi hệ thống không?',
                confirmText: 'Đăng xuất',
                cancelText: 'Huỷ',
                type: 'warning',
            });

            if (!confirmed) return;

            novaToast('Đang đăng xuất...', 'info', 1200);

            const formId = link.dataset.logoutForm;
            const form = formId ? document.getElementById(formId) : null;
            setTimeout(() => form?.submit(), 500);
        });
    });

    const btnSuspend = document.getElementById('btn-suspend-account');
    if (btnSuspend) {
        btnSuspend.addEventListener('click', async () => {
            const confirmed = await novaConfirm({
                title: 'Đình chỉ tài khoản?',
                message: 'Tài khoản sẽ bị tạm khoá. Bạn sẽ bị đăng xuất ngay lập tức.',
                confirmText: 'Đình chỉ',
                cancelText: 'Huỷ',
                type: 'warning',
            });

            if (!confirmed) return;

            novaToast('Đang xử lý...', 'warning', 1200);

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/profile/suspend';

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

            form.appendChild(csrf);
            document.body.appendChild(form);

            setTimeout(() => form.submit(), 400);
        });
    }
});
