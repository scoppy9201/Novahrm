import '../../../../Core/src/resources/js/nova-ui.js';

const chartDefaults = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { enabled: false } },
    animation: { duration: 800, easing: 'easeInOutQuart' },
};

// Chart 1 — Tổng nhân viên: Bar chart theo tháng
new Chart(document.getElementById('chart1'), {
    type: 'bar',
    data: {
        labels: ['T1','T2','T3','T4','T5','T6','T7'],
        datasets: [{
            data: [1180, 1205, 1220, 1240, 1255, 1270, 1284],
            backgroundColor: 'rgba(34,197,94,0.15)',
            borderColor: '#22c55e',
            borderWidth: 1.5,
            borderRadius: 4,
        }]
    },
    options: {
        ...chartDefaults,
        scales: {
            x: { display: false },
            y: { display: false, min: 1100 }
        }
    }
});

// Chart 2 — Đang hoạt động: Line chart
new Chart(document.getElementById('chart2'), {
    type: 'line',
    data: {
        labels: ['T1','T2','T3','T4','T5','T6','T7'],
        datasets: [{
            data: [1150, 1180, 1195, 1210, 1225, 1238, 1247],
            borderColor: '#3b82f6',
            borderWidth: 2,
            pointRadius: 0,
            tension: 0.4,
            fill: true,
            backgroundColor: 'rgba(59,130,246,0.08)',
        }]
    },
    options: {
        ...chartDefaults,
        scales: {
            x: { display: false },
            y: { display: false, min: 1100 }
        }
    }
});

// Chart 3 — Chấm công: Doughnut
new Chart(document.getElementById('chart3'), {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [96.4, 3.6],
            backgroundColor: ['#22c55e', '#f1f5f9'],
            borderWidth: 0,
            hoverOffset: 0,
        }]
    },
    options: {
        ...chartDefaults,
        cutout: '72%',
    }
});

// Chart 4 — Lương: Bar chart theo tháng
new Chart(document.getElementById('chart4'), {
    type: 'bar',
    data: {
        labels: ['T1','T2','T3','T4','T5','T6','T7'],
        datasets: [{
            data: [1.9, 2.0, 2.1, 2.2, 2.25, 2.35, 2.4],
            backgroundColor: 'rgba(124,58,237,0.15)',
            borderColor: '#7c3aed',
            borderWidth: 1.5,
            borderRadius: 4,
        }]
    },
    options: {
        ...chartDefaults,
        scales: {
            x: { display: false },
            y: { display: false, min: 1.5 }
        }
    }
});

// Sidebar toggle
const sidebar = document.getElementById('sidebar');
document.getElementById('sidebar-toggle').addEventListener('click', () => {
    sidebar.classList.toggle('expanded');
});

const avatarBtn = document.getElementById('sidebar-avatar-btn');
const userMenu  = document.getElementById('user-menu');

avatarBtn.addEventListener('click', (e) => {
    e.stopPropagation();

    const isOpen = userMenu.classList.contains('open');

    if (isOpen) {
        userMenu.classList.remove('open');
        return;
    }

    const rect = avatarBtn.getBoundingClientRect();
    const isExpanded = document.getElementById('sidebar').classList.contains('expanded');

    userMenu.style.visibility = 'hidden';
    userMenu.style.display = 'block';

    const menuH = userMenu.offsetHeight;  
    userMenu.style.left = (isExpanded ? 250 : 82) + 'px';
    userMenu.style.top  = (rect.top - menuH - 8) + 'px';

    userMenu.style.visibility = '';
    userMenu.style.display = '';
    userMenu.classList.add('open');
});

document.addEventListener('click', () => {
    userMenu.classList.remove('open');
});

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
