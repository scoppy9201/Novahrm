import '../../../../Core/src/resources/js/nova-ui.js';
import '../css/app.css';
import './nova-id';

const pwToggle = document.getElementById('pwToggle');
const pwInput = document.getElementById('password');
const eyeIcon = document.getElementById('eyeIcon');

pwToggle?.addEventListener('click', () => {
    const isText = pwInput.type === 'text';
    pwInput.type = isText ? 'password' : 'text';
    eyeIcon.innerHTML = isText
        ? '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
        : '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
});

document.getElementById('loginForm')?.addEventListener('submit', () => {
    const btn = document.getElementById('loginBtn');
    btn.classList.add('loading');
    btn.disabled = true;
});

if (window.__loginSuccess) {
    novaToast('Đăng nhập thành công! Chào mừng trở lại.', 'success');
}

if (window.__logoutSuccess) {
    novaToast('Đăng xuất thành công. Hẹn gặp lại!', 'success');
}

if (window.__loginError) {
    novaToast(window.__loginError, 'error', 4500);
}

document.querySelectorAll('[data-logout]').forEach(btn => {
    btn.addEventListener('click', async (e) => {
        e.preventDefault();

        const confirmed = await novaConfirm({
            title: 'Đăng xuất',
            message: 'Bạn có chắc chắn muốn đăng xuất không?',
            confirmText: 'Đăng xuất',
            cancelText: 'Huỷ',
            type: 'warning',
        });

        if (!confirmed) return;

        novaToast('Đang đăng xuất...', 'info', 1500);
        setTimeout(() => document.getElementById('logoutForm')?.submit(), 1000);
    });
});

(function () {
    const canvas = document.getElementById('connectorCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const cardIds = ['fc1', 'fc2', 'fc3', 'fc4', 'fc5', 'fc6', 'fc7'];
    const colors = ['#60A5FA', '#22c55e', '#A78BFA', '#FBBF24', '#F87171', '#34D399', '#60A5FA'];

    const dots = cardIds.map((id, i) => ({
        id,
        color: colors[i],
        progress: Math.random(),
        speed: 0.003 + Math.random() * 0.002,
    }));

    function getCenter(el, container) {
        const er = el.getBoundingClientRect();
        const cr = container.getBoundingClientRect();
        return { x: er.left - cr.left + er.width / 2, y: er.top - cr.top + er.height / 2 };
    }

    function resize() {
        const parent = canvas.parentElement;
        canvas.width = parent.offsetWidth;
        canvas.height = parent.offsetHeight;
    }

    function draw() {
        resize();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        const container = canvas.parentElement;
        const logoEl = document.getElementById('centerLogo');
        if (!logoEl) return requestAnimationFrame(draw);
        const center = getCenter(logoEl, container);

        dots.forEach(dot => {
            const cardEl = document.getElementById(dot.id);
            if (!cardEl) return;

            const cardCenter = getCenter(cardEl, container);
            const hex = dot.color.replace('#', '');
            const r = parseInt(hex.substring(0, 2), 16);
            const g = parseInt(hex.substring(2, 4), 16);
            const b = parseInt(hex.substring(4, 6), 16);

            ctx.beginPath();
            ctx.moveTo(cardCenter.x, cardCenter.y);
            ctx.lineTo(center.x, center.y);
            ctx.strokeStyle = `rgba(${r},${g},${b},0.15)`;
            ctx.lineWidth = 1;
            ctx.setLineDash([4, 6]);
            ctx.stroke();
            ctx.setLineDash([]);

            dot.progress += dot.speed;
            if (dot.progress > 1) dot.progress = 0;

            const px = cardCenter.x + (center.x - cardCenter.x) * dot.progress;
            const py = cardCenter.y + (center.y - cardCenter.y) * dot.progress;

            const gradient = ctx.createRadialGradient(px, py, 0, px, py, 6);
            gradient.addColorStop(0, `rgba(${r},${g},${b},0.9)`);
            gradient.addColorStop(1, `rgba(${r},${g},${b},0)`);

            ctx.beginPath();
            ctx.arc(px, py, 4, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();

            ctx.beginPath();
            ctx.arc(px, py, 2.5, 0, Math.PI * 2);
            ctx.fillStyle = dot.color;
            ctx.fill();
        });

        requestAnimationFrame(draw);
    }

    setTimeout(draw, 300);
    window.addEventListener('resize', resize);
})();
