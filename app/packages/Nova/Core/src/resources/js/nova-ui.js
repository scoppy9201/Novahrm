// nova-ui.js - Global UI helpers

// TOAST NOTIFICATION 
window.novaToast = function(msg, type = 'success', duration = 3500) {
    const icons = {
        success: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>`,
        error:   `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>`,
        warning: `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
        info:    `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
    };
    const colors = {
        success: { bg: 'rgba(34,197,94,0.12)',  border: 'rgba(34,197,94,0.35)',  text: '#22c55e' },
        error:   { bg: 'rgba(239,68,68,0.12)',  border: 'rgba(239,68,68,0.35)',  text: '#ef4444' },
        warning: { bg: 'rgba(251,146,60,0.12)', border: 'rgba(251,146,60,0.35)', text: '#fb923c' },
        info:    { bg: 'rgba(96,165,250,0.12)', border: 'rgba(96,165,250,0.35)', text: '#60A5FA' },
    };

    // Tạo container nếu chưa có
    let container = document.getElementById('nova-toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'nova-toast-container';
        container.style.cssText = `
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        `;
        document.body.appendChild(container);
    }

    const c = colors[type] || colors.info;
    const toast = document.createElement('div');
    toast.style.cssText = `
        display: flex;
        align-items: center;
        gap: 10px;
        background: ${c.bg};
        border: 1px solid ${c.border};
        color: ${c.text};
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 600;
        font-family: 'Be Vietnam Pro', sans-serif;
        backdrop-filter: blur(16px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.35);
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
        max-width: 360px;
        cursor: pointer;
    `;
    toast.innerHTML = `${icons[type] || icons.info}<span>${msg}</span>`;
    container.appendChild(toast);

    // Animate in
    requestAnimationFrame(() => requestAnimationFrame(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(0)';
    }));

    // Auto remove
    const remove = () => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(20px)';
        setTimeout(() => toast.remove(), 350);
    };
    const timer = setTimeout(remove, duration);
    toast.addEventListener('click', () => { clearTimeout(timer); remove(); });
};

function processNovaToastNodes(root = document) {
    root.querySelectorAll('[data-nova-toast-message]:not([data-nova-toast-bound])').forEach((node) => {
        node.dataset.novaToastBound = '1';

        const message = node.dataset.novaToastMessage || node.textContent?.trim();
        if (!message) {
            return;
        }

        const type = node.dataset.novaToastType || 'info';
        const duration = Number(node.dataset.novaToastDuration || 3500);
        window.novaToast(message, type, Number.isFinite(duration) ? duration : 3500);
        node.remove();
    });
}

function getNovaConfirmConfig(form) {
    return {
        title: form.dataset.novaConfirmTitle || 'XÃ¡c nháº­n',
        message: form.dataset.novaConfirmMessage || 'Báº¡n cÃ³ cháº¯c cháº¯n khÃ´ng?',
        confirmText: form.dataset.novaConfirmText || 'XÃ¡c nháº­n',
        cancelText: form.dataset.novaConfirmCancel || 'Huá»·',
        type: form.dataset.novaConfirmType || 'warning',
    };
}

function bindNovaConfirmForms() {
    if (document.__novaConfirmFormsBound) {
        return;
    }

    document.__novaConfirmFormsBound = true;

    document.addEventListener('submit', async (event) => {
        const form = event.target;

        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        if (!form.dataset.novaConfirmMessage) {
            return;
        }

        if (form.dataset.novaConfirmApproved === '1') {
            delete form.dataset.novaConfirmApproved;
            return;
        }

        event.preventDefault();

        const confirmed = await window.novaConfirm(getNovaConfirmConfig(form));
        if (!confirmed) {
            return;
        }

        form.dataset.novaConfirmApproved = '1';

        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit(event.submitter || undefined);
            return;
        }

        HTMLFormElement.prototype.submit.call(form);
    }, true);
}

function initNovaUi() {
    bindNovaConfirmForms();

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => processNovaToastNodes(), { once: true });
        return;
    }

    processNovaToastNodes();
}

window.novaProcessToastNodes = processNovaToastNodes;
window.novaBindConfirmForms = bindNovaConfirmForms;

// CONFIRM DIALOG 
window.novaConfirm = function({ 
    title = 'Xác nhận', 
    message = 'Bạn có chắc chắn không?',
    confirmText = 'Xác nhận',
    cancelText = 'Huỷ',
    type = 'warning' // warning | danger | info
} = {}) {
    return new Promise((resolve) => {
        const colors = {
            warning: { icon: '#fb923c', btn: 'linear-gradient(135deg,#d97706,#fb923c)' },
            danger:  { icon: '#ef4444', btn: 'linear-gradient(135deg,#dc2626,#ef4444)' },
            info:    { icon: '#60A5FA', btn: 'linear-gradient(135deg,#1565C0,#2196F3)' },
        };
        const icons = {
            warning: `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
            danger:  `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
            info:    `<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        };

        const c = colors[type] || colors.warning;

        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(6px);
            z-index: 999999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            opacity: 0;
            transition: opacity 0.25s ease;
        `;

        overlay.innerHTML = `
            <div style="
                background: #0d1729;
                border: 1px solid rgba(255,255,255,0.1);
                border-radius: 20px;
                padding: 2rem;
                max-width: 400px;
                width: 100%;
                box-shadow: 0 30px 80px rgba(0,0,0,0.5);
                transform: translateY(20px) scale(0.97);
                transition: transform 0.35s cubic-bezier(0.16,1,0.3,1);
                text-align: center;
            ">
                <div style="
                    width: 56px; height: 56px;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.06);
                    border: 1px solid rgba(255,255,255,0.1);
                    display: flex; align-items: center; justify-content: center;
                    margin: 0 auto 1.2rem;
                    color: ${c.icon};
                ">${icons[type] || icons.warning}</div>

                <div style="font-size:17px; font-weight:800; color:#fff; margin-bottom:8px; font-family:'Be Vietnam Pro',sans-serif;">
                    ${title}
                </div>
                <div style="font-size:13.5px; color:#8da4be; line-height:1.7; margin-bottom:1.8rem; font-family:'Be Vietnam Pro',sans-serif;">
                    ${message}
                </div>

                <div style="display:flex; gap:10px; justify-content:center;">
                    <button id="nova-confirm-cancel" style="
                        padding: 10px 24px;
                        background: rgba(255,255,255,0.05);
                        border: 1px solid rgba(255,255,255,0.1);
                        border-radius: 100px;
                        color: #8da4be;
                        font-size: 13.5px; font-weight: 600;
                        cursor: pointer;
                        font-family: 'Be Vietnam Pro', sans-serif;
                        transition: all 0.2s;
                    ">${cancelText}</button>

                    <button id="nova-confirm-ok" style="
                        padding: 10px 24px;
                        background: ${c.btn};
                        border: none;
                        border-radius: 100px;
                        color: #fff;
                        font-size: 13.5px; font-weight: 700;
                        cursor: pointer;
                        font-family: 'Be Vietnam Pro', sans-serif;
                        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
                        transition: all 0.2s;
                    ">${confirmText}</button>
                </div>
            </div>
        `;

        document.body.appendChild(overlay);

        // Animate in
        requestAnimationFrame(() => requestAnimationFrame(() => {
            overlay.style.opacity = '1';
            overlay.querySelector('div').style.transform = 'translateY(0) scale(1)';
        }));

        const close = (result) => {
            overlay.style.opacity = '0';
            setTimeout(() => { overlay.remove(); resolve(result); }, 250);
        };

        overlay.querySelector('#nova-confirm-ok').addEventListener('click', () => close(true));
        overlay.querySelector('#nova-confirm-cancel').addEventListener('click', () => close(false));
        overlay.addEventListener('click', (e) => { if (e.target === overlay) close(false); });
        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') { close(false); document.removeEventListener('keydown', handler); }
            if (e.key === 'Enter')  { close(true);  document.removeEventListener('keydown', handler); }
        });
    });
};

initNovaUi();
