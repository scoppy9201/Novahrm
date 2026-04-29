{{-- partials/modals/modal-otp.blade.php --}}

<div class="doc-modal-overlay" id="modal-otp">
    <div class="doc-modal doc-modal-sm">
        <div class="doc-modal-head">
            <div class="doc-modal-title">Xác nhận ký số</div>
            <button class="doc-btn doc-btn-ghost doc-btn-icon" onclick="closeModal('modal-otp')">
                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('documents.signature.sign', $document) }}" id="form-otp-sign">
            @csrf
            <input type="hidden" id="hidden-signature-image" name="signature_image"/>
            <input type="hidden" id="hidden-page-number"    name="page_number" value="1"/>
            <input type="hidden" id="hidden-pos-x"          name="pos_x"       value="10"/>
            <input type="hidden" id="hidden-pos-y"          name="pos_y"       value="270"/>
            <input type="hidden" id="hidden-width"          name="width"       value="80"/>
            <input type="hidden" id="hidden-height"         name="height"      value="30"/>
            <input type="hidden" id="hidden-otp-value"      name="otp"/>

            <div class="doc-modal-body">
                <div class="doc-otp-wrap" style="padding:0;gap:16px">

                    <div class="doc-otp-icon">
                        <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                    </div>

                    {{-- Bước 1: Gửi OTP --}}
                    <div id="otp-step-send" style="width:100%">
                        <div class="doc-otp-title" style="font-size:14px">Gửi mã xác nhận</div>
                        <div class="doc-otp-desc">
                            Mã OTP sẽ được gửi đến email<br>
                            <strong>{{ Auth::user()->email }}</strong>
                        </div>
                        <button type="button" class="doc-btn doc-btn-primary" style="width:100%;margin-top:8px" id="btn-send-otp">
                            <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                            Gửi OTP qua email
                        </button>
                    </div>

                    {{-- Bước 2: Nhập OTP --}}
                    <div id="otp-step-verify" style="display:none;width:100%">
                        <div class="doc-otp-title" style="font-size:14px">Nhập mã OTP</div>
                        <div class="doc-otp-desc">
                            Mã 6 số đã được gửi đến<br>
                            <strong>{{ Auth::user()->email }}</strong>
                        </div>

                        <div class="doc-otp-inputs" style="justify-content:center;margin:12px 0">
                            @for($i = 0; $i < 6; $i++)
                            <input type="text" class="doc-otp-digit" maxlength="1"
                                inputmode="numeric" pattern="[0-9]"
                                data-index="{{ $i }}" autocomplete="off"/>
                            @endfor
                        </div>

                        <div class="doc-otp-resend">
                            <span id="otp-timer-text">Gửi lại sau <span class="doc-otp-countdown" id="otp-countdown">10:00</span></span>
                            <button type="button" id="btn-resend-otp" style="display:none" onclick="sendOtp()">
                                Gửi lại OTP
                            </button>
                        </div>

                        <div id="otp-error" style="display:none;margin-top:10px" class="doc-alert doc-alert-error">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            <span id="otp-error-text">OTP không chính xác hoặc đã hết hạn.</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="doc-modal-foot" id="otp-footer" style="display:none">
                <button type="button" class="doc-btn doc-btn-secondary" onclick="closeModal('modal-otp')">Huỷ</button>
                <button type="submit" class="doc-btn doc-btn-primary" id="btn-confirm-sign" disabled>
                    <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    Xác nhận ký
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    let countdownTimer = null;

    // Gửi OTP 
    document.getElementById('btn-send-otp')?.addEventListener('click', sendOtp);

    async function sendOtp() {
        const btn = document.getElementById('btn-send-otp');
        if (btn) { btn.disabled = true; btn.textContent = 'Đang gửi...'; }

        try {
            const res  = await fetch('{{ route('documents.signature.send-otp', $document) }}', {
                method: 'POST',
                headers: {
                    'Content-Type':  'application/json',
                    'X-CSRF-TOKEN':  document.querySelector('meta[name="csrf-token"]').content,
                    'Accept':        'application/json',
                }
            });
            const data = await res.json();

            if (res.ok) {
                document.getElementById('otp-step-send').style.display   = 'none';
                document.getElementById('otp-step-verify').style.display = 'block';
                document.getElementById('otp-footer').style.display      = 'flex';
                startCountdown(600);
                document.querySelector('.doc-otp-digit')?.focus();
            } else {
                alert(data.message || 'Không thể gửi OTP, thử lại sau.');
                if (btn) { btn.disabled = false; btn.textContent = 'Gửi OTP qua email'; }
            }
        } catch(e) {
            alert('Lỗi kết nối, thử lại sau.');
            if (btn) { btn.disabled = false; btn.textContent = 'Gửi OTP qua email'; }
        }
    }
    window.sendOtp = sendOtp;

    // Countdown 
    function startCountdown(seconds) {
        clearInterval(countdownTimer);
        const timerText   = document.getElementById('otp-timer-text');
        const resendBtn   = document.getElementById('btn-resend-otp');
        const countdownEl = document.getElementById('otp-countdown');
        let remaining = seconds;

        countdownTimer = setInterval(() => {
            remaining--;
            const m = Math.floor(remaining / 60);
            const s = remaining % 60;
            if (countdownEl) countdownEl.textContent = `${m}:${String(s).padStart(2, '0')}`;

            if (remaining <= 0) {
                clearInterval(countdownTimer);
                if (timerText) timerText.style.display = 'none';
                if (resendBtn) resendBtn.style.display = 'inline';
            }
        }, 1000);
    }

    // Nhập OTP 
    const digits     = document.querySelectorAll('.doc-otp-digit');
    const confirmBtn = document.getElementById('btn-confirm-sign');
    const otpHidden  = document.getElementById('hidden-otp-value');

    digits.forEach((input, idx) => {
        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace') {
                e.preventDefault();
                if (input.value) {
                    input.value = '';
                    input.classList.remove('filled');
                } else if (idx > 0) {
                    digits[idx - 1].focus();
                    digits[idx - 1].value = '';
                    digits[idx - 1].classList.remove('filled');
                }
                updateOtp();
                return;
            }

            if (!/^\d$/.test(e.key)) {
                e.preventDefault();
                return;
            }

            e.preventDefault();
            input.value = e.key;  // ghi đè, không append
            input.classList.add('filled');
            updateOtp();

            if (idx < digits.length - 1) {
                digits[idx + 1].focus();
            }
        });

        // Chặn HOÀN TOÀN input event — không cho browser tự xử lý
        input.addEventListener('input', e => {
            input.value = input.value.slice(-1).replace(/\D/g, '');
            if (input.value) {
                input.classList.add('filled');
                updateOtp();
                if (idx < digits.length - 1) digits[idx + 1].focus();
            } else {
                input.classList.remove('filled');
                updateOtp();
            }
        });

        input.addEventListener('paste', e => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData)
                .getData('text')
                .replace(/\D/g, '')
                .slice(0, 6);

            digits.forEach((d, i) => {
                d.value = pasted[i] || '';
                d.classList.toggle('filled', !!pasted[i]);
            });

            updateOtp();
            digits[Math.min(pasted.length, 5)].focus();
        });
    });

    function updateOtp() {
        const otp = [...digits].map(d => d.value).join('');
        if (otpHidden)  otpHidden.value    = otp;
        if (confirmBtn) confirmBtn.disabled = otp.length < 6;
    }

    // Submit 
    document.getElementById('form-otp-sign')?.addEventListener('submit', function(e) {
        const otp = [...digits].map(d => d.value).join('');
        if (otp.length < 6) { e.preventDefault(); return; }
        if (confirmBtn) { confirmBtn.disabled = true; confirmBtn.textContent = 'Đang ký...'; }
    });

    //  Reset modal khi đóng 
    document.getElementById('modal-otp')?.addEventListener('click', function(e) {
        if (e.target === this) resetModal();
    });

    function resetModal() {
        document.getElementById('otp-step-send').style.display   = 'block';
        document.getElementById('otp-step-verify').style.display = 'none';
        document.getElementById('otp-footer').style.display      = 'none';
        digits.forEach(d => { d.value = ''; d.classList.remove('filled'); });
        if (otpHidden)  otpHidden.value    = '';
        if (confirmBtn) confirmBtn.disabled = true;
        clearInterval(countdownTimer);
        const btn = document.getElementById('btn-send-otp');
        if (btn) { btn.disabled = false; btn.textContent = 'Gửi OTP qua email'; }
    }
})();
</script>