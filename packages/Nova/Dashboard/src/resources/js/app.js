import '../../../../Core/src/resources/js/nova-ui.js';

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { enabled: false } },
    animation: { duration: 800, easing: 'easeInOutQuart' },
};

const initChart = (id, config) => {
    const element = document.getElementById(id);

    if (!element || typeof Chart === 'undefined') {
        return;
    }

    new Chart(element, config);
};

initChart('chart1', {
    type: 'bar',
    data: {
        labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        datasets: [{
            data: [1180, 1205, 1220, 1240, 1255, 1270, 1284],
            backgroundColor: 'rgba(34,197,94,0.15)',
            borderColor: '#22c55e',
            borderWidth: 1.5,
            borderRadius: 4,
        }],
    },
    options: {
        ...chartDefaults,
        scales: {
            x: { display: false },
            y: { display: false, min: 1100 },
        },
    },
});

initChart('chart2', {
    type: 'line',
    data: {
        labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        datasets: [{
            data: [1150, 1180, 1195, 1210, 1225, 1238, 1247],
            borderColor: '#3b82f6',
            borderWidth: 2,
            pointRadius: 0,
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(59,130,246,0.08)',
        }],
    },
    options: {
        ...chartDefaults,
        scales: {
            x: { display: false },
            y: { display: false, min: 1100 },
        },
    },
});

initChart('chart3', {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [96.4, 3.6],
            backgroundColor: ['#22c55e', '#f1f5f9'],
            borderWidth: 0,
            hoverOffset: 0,
        }],
    },
    options: {
        ...chartDefaults,
        cutout: '72%',
    },
});

initChart('chart4', {
    type: 'bar',
    data: {
        labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
        datasets: [{
            data: [1.9, 2.0, 2.1, 2.2, 2.25, 2.35, 2.4],
            backgroundColor: 'rgba(124,58,237,0.15)',
            borderColor: '#7c3aed',
            borderWidth: 1.5,
            borderRadius: 4,
        }],
    },
    options: {
        ...chartDefaults,
        scales: {
            x: { display: false },
            y: { display: false, min: 1.5 },
        },
    },
});

const sidebar = document.getElementById('sidebar');
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebarSearchInput = document.getElementById('sidebar-search-input');
const sidebarGroups = Array.from(document.querySelectorAll('[data-sidebar-group]'));
const avatarBtn = document.getElementById('sidebar-avatar-btn');
const userMenu = document.getElementById('user-menu');

const normalizeSearchText = (value) => (
    (value || '')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[\u0111\u0110]/g, 'd')
        .replace(/[^a-z0-9\s+&-]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim()
);

const syncActiveSidebarGroup = () => {
    sidebarGroups.forEach((group) => {
        const hasActiveItem = group.querySelector('.sidebar-submenu-item.active');
        group.classList.toggle('is-active', Boolean(hasActiveItem));
    });
};

const filterSidebar = () => {
    if (!sidebarSearchInput) {
        return;
    }

    const keyword = normalizeSearchText(sidebarSearchInput.value);

    sidebarGroups.forEach((group) => {
        const groupSearchText = normalizeSearchText([
            group.dataset.groupName || '',
            group.querySelector('.sidebar-group-title')?.textContent || '',
            group.querySelector('.sidebar-group-subtitle')?.textContent || '',
            group.querySelector('.sidebar-group-trigger')?.getAttribute('title') || '',
        ].join(' '));
        const items = Array.from(group.querySelectorAll('[data-sidebar-search-item]'));
        const matchGroup = keyword.length > 0 && groupSearchText.includes(keyword);

        let visibleItems = 0;

        items.forEach((item) => {
            const itemSearchText = normalizeSearchText([
                item.dataset.searchLabel || '',
                item.textContent || '',
                group.dataset.groupName || '',
            ].join(' '));
            const showItem = !keyword || matchGroup || itemSearchText.includes(keyword);

            item.classList.toggle('is-hidden', !showItem);

            if (showItem) {
                visibleItems += 1;
            }
        });

        const showGroup = !keyword || matchGroup || visibleItems > 0;
        group.classList.toggle('is-hidden', !showGroup);
    });
};

const closeUserMenu = () => {
    userMenu?.classList.remove('open');
};

syncActiveSidebarGroup();
filterSidebar();

sidebarToggle?.addEventListener('click', () => {
    sidebar?.classList.toggle('expanded');

    if (sidebar?.classList.contains('expanded')) {
        sidebarSearchInput?.focus();
    } else {
        closeUserMenu();
    }
});

sidebarSearchInput?.addEventListener('input', filterSidebar);
sidebarSearchInput?.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        sidebarSearchInput.value = '';
        filterSidebar();
        return;
    }

    if (event.key === 'Enter') {
        const firstVisibleItem = document.querySelector('.sidebar-submenu-item:not(.is-hidden)');

        if (firstVisibleItem instanceof HTMLAnchorElement) {
            firstVisibleItem.click();
        }
    }
});

avatarBtn?.addEventListener('click', (event) => {
    event.stopPropagation();

    if (!userMenu || !sidebar) {
        return;
    }

    const isOpen = userMenu.classList.contains('open');

    if (isOpen) {
        closeUserMenu();
        return;
    }

    const sidebarRect = sidebar.getBoundingClientRect();
    const avatarRect = avatarBtn.getBoundingClientRect();

    userMenu.style.visibility = 'hidden';
    userMenu.style.display = 'block';

    const menuHeight = userMenu.offsetHeight;
    const top = Math.max(12, avatarRect.top - menuHeight - 10);
    const left = sidebarRect.right + 12;

    userMenu.style.top = `${top}px`;
    userMenu.style.left = `${left}px`;
    userMenu.style.visibility = '';
    userMenu.style.display = '';
    userMenu.classList.add('open');
});

document.addEventListener('click', (event) => {
    if (!userMenu || !avatarBtn) {
        return;
    }

    if (userMenu.contains(event.target)) {
        return;
    }

    if (!avatarBtn.contains(event.target)) {
        closeUserMenu();
    }
});

document.querySelectorAll('[data-logout]').forEach((link) => {
    link.addEventListener('click', async (event) => {
        event.preventDefault();

        const confirmed = await novaConfirm({
            title: 'Đăng xuất',
            message: 'Bạn có chắc chắn muốn đăng xuất khỏi hệ thống không?',
            confirmText: 'Đăng xuất',
            cancelText: 'Huỷ',
            type: 'warning',
        });

        if (!confirmed) {
            return;
        }

        novaToast('Đang đăng xuất...', 'info', 1200);

        const formId = link.dataset.logoutForm;
        const form = formId ? document.getElementById(formId) : null;
        setTimeout(() => form?.submit(), 500);
    });
});

// Tooltip cho sidebar khi thu gọn
(function() {
    const tooltip = document.getElementById('sidebar-tooltip');
    if (!tooltip) return;

    document.querySelectorAll('.sidebar-group-trigger').forEach(function(trigger) {
        trigger.addEventListener('mouseenter', function() {
            if (sidebar.classList.contains('expanded')) return;

            const label = this.getAttribute('title');
            if (!label) return;

            const rect = this.getBoundingClientRect();
            tooltip.textContent = label;
            tooltip.style.top = (rect.top + rect.height / 2) + 'px';
            tooltip.style.left = (rect.right + 12) + 'px';
            tooltip.style.transform = 'translateY(-50%)';
            tooltip.classList.add('visible');
        });

        trigger.addEventListener('mouseleave', function() {
            tooltip.classList.remove('visible');
        });
    });
})();
