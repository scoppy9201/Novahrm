document.addEventListener('DOMContentLoaded', () => {
    initFlashAlerts();
    initDeleteConfirm();
    initColorPicker();
    initFilterForm();
});

/* Flash alerts tự động đóng sau 4s */
function initFlashAlerts() {
    document.querySelectorAll('.dept-alert[data-auto-close]').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity 0.4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    });
}

/* Confirm trước khi xóa */
function initDeleteConfirm() {
    document.querySelectorAll('[data-delete-form]').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            const name   = btn.dataset.name ?? 'mục này';
            const formId = btn.dataset.deleteForm;
            const form   = document.getElementById(formId);

            if (!form) return;

            if (confirm(`Bạn có chắc muốn xóa "${name}" không?\nHành động này không thể hoàn tác.`)) {
                form.submit();
            }
        });
    });
}

/* Color picker preview */
function initColorPicker() {
    const input   = document.getElementById('color-input');
    const preview = document.getElementById('color-preview');

    if (!input || !preview) return;

    const update = () => { preview.style.background = input.value; };
    input.addEventListener('input', update);
    update();
}

/* Auto-submit filter form khi thay đổi select */
function initFilterForm() {
    document.querySelectorAll('[data-filter-form]').forEach(select => {
        select.addEventListener('change', () => {
            select.closest('form')?.submit();
        });
    });
}

/* Tabs (dùng cho trang show có nhiều tab) */
function initTabs(tabSelector, panelSelector) {
    const tabs   = document.querySelectorAll(tabSelector);
    const panels = document.querySelectorAll(panelSelector);

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            const target = document.getElementById(tab.dataset.tab);
            if (target) target.classList.add('active');
        });
    });
}

/* Export để dùng inline nếu cần */
window.NovaHRM = window.NovaHRM ?? {};
window.NovaHRM.initTabs = initTabs;

// ── Manager autocomplete ──
const searchInput  = document.getElementById('manager_search');
const hiddenInput  = document.getElementById('manager_id');
const dropdown     = document.getElementById('manager_dropdown');
const preview      = document.getElementById('manager_preview');
const clearBtn     = document.getElementById('manager_clear');

if (searchInput) {
    let timer;

    searchInput.addEventListener('input', () => {
        clearTimeout(timer);
        const q = searchInput.value.trim();

        if (q.length < 1) {
            dropdown.classList.add('hidden');
            return;
        }

        timer = setTimeout(async () => {
            const url = searchInput.dataset.url + '?q=' + encodeURIComponent(q);
            const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();

            dropdown.innerHTML = '';

            if (!data.length) {
                dropdown.innerHTML = '<div class="dept-manager-empty">Không tìm thấy</div>';
            } else {
                data.forEach(emp => {
                    const item = document.createElement('div');
                    item.className = 'dept-manager-option';
                    item.innerHTML = `
                        <div class="dept-avatar" style="width:28px;height:28px;font-size:10px;flex-shrink:0">
                            <img src="${emp.avatar}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                        </div>
                        <div>
                            <div class="dept-manager-option-name">${emp.name}</div>
                            <div class="dept-manager-option-pos">${emp.position}</div>
                        </div>`;

                    item.addEventListener('click', () => selectManager(emp));
                    dropdown.appendChild(item);
                });
            }

            dropdown.classList.remove('hidden');
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.closest('.dept-form-group').contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    clearBtn?.addEventListener('click', () => {
        hiddenInput.value  = '';
        searchInput.value  = '';
        preview.classList.add('hidden');
        clearBtn.classList.add('hidden');
        dropdown.classList.add('hidden');
    });

    function selectManager(emp) {
        hiddenInput.value = emp.id;
        searchInput.value = emp.name;
        dropdown.classList.add('hidden');
        clearBtn.classList.remove('hidden');

        preview.innerHTML = `
            <div class="dept-avatar" style="width:28px;height:28px;font-size:10px">
                <img src="${emp.avatar}" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
            </div>
            <div>
                <div style="font-size:12px;font-weight:700;color:#0f172a">${emp.name}</div>
                <div style="font-size:11px;color:#94a3b8">${emp.position}</div>
            </div>`;
        preview.classList.remove('hidden');
    }
}