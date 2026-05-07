const NID = (() => {
    // State 
    const state = {
        email:       '',
        mlTimer:     null,
        otpTimer:    null,
    };

    // DOM refs (lazy, chỉ query 1 lần) 
    let _form, _overlay, _emailInput, _emailBtn, _emailError, _emailErrIcon,
        _mlEmail, _mlResend, _mlCountdown,
        _otpInputs, _otpBtn, _otpError, _otpResend, _otpCountdown;

    function dom() {
        if (_form) return;
        _form          = document.getElementById('nid-form');
        _overlay       = document.getElementById('novaIdOverlay');
        _emailInput    = document.getElementById('nid-email-input');
        _emailBtn      = document.getElementById('nid-email-btn');
        _emailError    = document.getElementById('nid-email-error');
        _emailErrIcon  = document.getElementById('nid-email-err-icon');
        _mlEmail       = document.getElementById('nid-ml-email');
        _mlResend      = document.getElementById('nid-ml-resend');
        _mlCountdown   = document.getElementById('nid-ml-countdown');
        _otpInputs     = [...document.querySelectorAll('.nid-otp-input')];
        _otpBtn        = document.getElementById('nid-otp-btn');
        _otpError      = document.getElementById('nid-otp-error');
        _otpResend     = document.getElementById('nid-otp-resend');
        _otpCountdown  = document.getElementById('nid-otp-countdown');
    }

    // elpers
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const csrfToken  = () => document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const r          = () => window.__routes || {};

    function goStep(n) {
        dom();
        _form.dataset.step = String(n);
    }

    function setEmailBtn(enabled) {
        _emailBtn.disabled        = !enabled;
        _emailBtn.style.background = enabled ? '#1565C0' : '#cbd5e1';
        _emailBtn.style.cursor     = enabled ? 'pointer'  : 'not-allowed';
    }

    function startCountdown(countdownEl, resendEl, seconds, onDone) {
        let s = seconds;
        countdownEl.textContent = s;

        // Disable resend button / span
        if (resendEl.tagName === 'BUTTON') {
            resendEl.disabled = true;
            resendEl.style.opacity = '.5';
        } else {
            resendEl.className = 'nid-resend-disabled';
            resendEl.style.pointerEvents = 'none';
        }

        const timer = setInterval(() => {
            s--;
            countdownEl.textContent = s;
            if (s <= 0) {
                clearInterval(timer);
                if (resendEl.tagName === 'BUTTON') {
                    resendEl.disabled = false;
                    resendEl.style.opacity = '1';
                    resendEl.querySelector('span')?.replaceChildren
                        ? (resendEl.querySelector('#nid-ml-resend-text').textContent = 'Gửi lại liên kết')
                        : null;
                } else {
                    resendEl.className = 'nid-resend-active';
                    resendEl.style.pointerEvents = 'auto';
                    resendEl.innerHTML = 'Gửi lại OTP';
                }
                onDone?.();
            }
        }, 1000);

        return timer;
    }

    async function post(url, body) {
        const res = await fetch(url, {
            method:  'POST',
            headers: {
                'Content-Type':  'application/json',
                'Accept':        'application/json',
                'X-CSRF-TOKEN':  csrfToken(),
            },
            body: JSON.stringify(body),
        });
        const json = await res.json();
        return { ok: res.ok, status: res.status, data: json };
    }

    // Public API 
    function open() {
        dom();
        _overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
        _reset();
        setTimeout(() => _emailInput.focus(), 100);
    }

    function close() {
        dom();
        _overlay.style.display = 'none';
        document.body.style.overflow = '';
        clearInterval(state.mlTimer);
        clearInterval(state.otpTimer);
    }

    function _reset() {
        goStep(1);
        state.email = '';
        _emailInput.value = '';
        _emailInput.style.borderColor = '#e2e8f0';
        _emailInput.style.boxShadow   = 'none';
        _emailError.style.display     = 'none';
        _emailErrIcon.style.display   = 'none';
        setEmailBtn(false);
        _otpInputs.forEach(i => {
            i.value = '';
            i.className = 'nid-otp-input';
        });
        _otpError.style.display = 'none';
        _otpBtn.disabled = true;
    }

    // Step 1: Email input live validate 
    function onEmailInput(input) {
        dom();
        setEmailBtn(emailRegex.test(input.value.trim()));
        _emailError.style.display   = 'none';
        _emailErrIcon.style.display = 'none';
        input.style.borderColor     = '#e2e8f0';
    }

    // Step 1: Submit email → gửi Magic Link 
    async function submitEmail() {
        dom();
        const email = _emailInput.value.trim();
        if (!emailRegex.test(email)) {
            _emailError.style.display   = 'block';
            _emailErrIcon.style.display = 'block';
            _emailInput.style.borderColor = '#ef4444';
            _emailInput.focus();
            return;
        }

        setEmailBtn(false);
        _emailBtn.textContent = 'Đang gửi...';

        const { ok, data } = await post(window.__routes.novaIdSend, {
            email, type: 'magic_link',
        });

        setEmailBtn(true);
        _emailBtn.textContent = 'Tiếp theo';

        if (!ok) {
            _emailError.textContent   = data.message ?? 'Có lỗi xảy ra.';
            _emailError.style.display = 'block';
            return;
        }

        state.email      = email;
        _mlEmail.textContent = email;
        goStep(2);

        // Countdown resend magic link
        clearInterval(state.mlTimer);
        _mlCountdown.textContent = '60';
        state.mlTimer = startCountdown(_mlCountdown, _mlResend, 60);
    }

    // Step 2: Resend Magic Link 
    async function resendMagicLink() {
        dom();
        _mlResend.disabled = true;

        await post(window.__routes.novaIdSend, {
            email: state.email, type: 'magic_link',
        });

        clearInterval(state.mlTimer);
        state.mlTimer = startCountdown(_mlCountdown, _mlResend, 60);
    }

    // Step 2 → Step 3: Thử cách khác (OTP) 
    async function switchToOtp() {
        dom();
        clearInterval(state.mlTimer);

        const { ok, data } = await post(window.__routes.novaIdSend, {
            email: state.email, type: 'otp',
        });

        if (!ok) {
            novaToast?.(data.message ?? 'Có lỗi xảy ra.', 'error');
            return;
        }

        goStep(3);
        _otpInputs[0].focus();

        // Countdown resend OTP
        clearInterval(state.otpTimer);
        _otpCountdown.textContent = '60';
        state.otpTimer = startCountdown(_otpCountdown, _otpResend, 60);
    }

    // Step 3: Resend OTP 
    async function resendOtp() {
        dom();
        _otpResend.className = 'nid-resend-disabled';
        _otpResend.style.pointerEvents = 'none';

        await post(window.__routes.novaIdSend, {
            email: state.email, type: 'otp',
        });

        _otpInputs.forEach(i => { i.value = ''; i.className = 'nid-otp-input'; });
        _otpBtn.disabled = true;
        _otpError.style.display = 'none';
        _otpInputs[0].focus();

        clearInterval(state.otpTimer);
        _otpCountdown.textContent = '60';
        state.otpTimer = startCountdown(_otpCountdown, _otpResend, 60);
    }

    // Step 3: Submit OTP 
    async function submitOtp() {
        dom();
        const otp = _otpInputs.map(i => i.value).join('');
        if (otp.length < 6) return;

        _otpBtn.disabled      = true;
        _otpBtn.textContent   = 'Đang xác nhận...';
        _otpError.style.display = 'none';
        _otpInputs.forEach(i => i.classList.remove('nid-otp-error'));

        const { ok, data } = await post(window.__routes.novaIdVerifyOtp, {
            email: state.email, otp,
        });

        if (!ok) {
            _otpError.textContent   = data.message ?? 'Mã OTP không chính xác.';
            _otpError.style.display = 'block';
            _otpInputs.forEach(i => i.classList.add('nid-otp-error'));
            _otpBtn.disabled    = false;
            _otpBtn.textContent = 'Xác nhận';
            return;
        }

        _otpBtn.textContent = '✓ Thành công';
        setTimeout(() => { window.location.href = data.redirect ?? '/dashboard'; }, 300);
    }

    // OTP input keyboard behaviour 
    function initOtpInputs() {
        dom();
        _otpInputs.forEach((input, idx) => {
            input.addEventListener('keydown', e => {
                if (e.key === 'Backspace') {
                    if (!input.value && idx > 0) _otpInputs[idx - 1].focus();
                    return;
                }
                if (e.key === 'ArrowLeft'  && idx > 0) { e.preventDefault(); _otpInputs[idx - 1].focus(); return; }
                if (e.key === 'ArrowRight' && idx < 5) { e.preventDefault(); _otpInputs[idx + 1].focus(); return; }
            });

            input.addEventListener('input', e => {
                const val = e.target.value.replace(/\D/g, '');
                input.value = val.slice(-1); // chỉ giữ 1 ký tự
                input.classList.toggle('nid-otp-filled', !!input.value);
                _otpError.style.display = 'none';
                input.classList.remove('nid-otp-error');

                if (input.value && idx < 5) _otpInputs[idx + 1].focus();

                // Enable confirm btn khi đủ 6 số
                const full = _otpInputs.every(i => i.value);
                _otpBtn.disabled = !full;
                if (full) _otpBtn.focus();
            });

            // Paste: xử lý dán 6 số liền
            input.addEventListener('paste', e => {
                e.preventDefault();
                const pasted = (e.clipboardData ?? window.clipboardData)
                    .getData('text').replace(/\D/g, '').slice(0, 6);
                pasted.split('').forEach((ch, i) => {
                    if (_otpInputs[i]) {
                        _otpInputs[i].value = ch;
                        _otpInputs[i].classList.add('nid-otp-filled');
                    }
                });
                _otpInputs[Math.min(pasted.length, 5)].focus();
                _otpBtn.disabled = pasted.length < 6;
            });
        });
    }

    // Global key / click 
    function initEvents() {
        document.getElementById('novaIdOverlay')?.addEventListener('click', e => {
            if (e.target === e.currentTarget) close();
        });
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && document.getElementById('novaIdOverlay')?.style.display === 'block') close();
        });
    }

    // Boot 
    document.addEventListener('DOMContentLoaded', () => {
        initOtpInputs();
        initEvents();
    });

    return { open, close, goStep, onEmailInput, submitEmail, resendMagicLink, switchToOtp, resendOtp, submitOtp };
})();

// Export global
window.NID     = NID;
window.nidOpen = NID.open;   // backward compat