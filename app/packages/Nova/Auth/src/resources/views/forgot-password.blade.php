<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quên mật khẩu — NovaHRM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:300,400,500,600,700,800,900" rel="stylesheet"/>
    @vite([
        'app/packages/Nova/Auth/src/resources/css/app.css',
        'app/packages/Nova/Auth/src/resources/js/app.js',
    ])
</head>
<body>

<div class="login-wrap">
    <div class="login-left">

        <a href="/" class="login-logo">
            <div class="login-logo-icon">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <span class="login-logo-text">Nova<span>HRM</span></span>
        </a>

        <div class="login-form-wrap">

            {{-- ── STEP 1: Nhập email ── --}}
            <div id="step-email">
                <a href="{{ route('login') }}" class="back-link">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Quay lại đăng nhập
                </a>
                <h1 class="login-heading" style="margin-top:1rem">Quên mật khẩu?</h1>
                <p class="login-subheading">Nhập email để nhận mã OTP đặt lại mật khẩu.</p>

                <div id="alert-email" class="login-alert" style="display:none">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="alert-email-msg"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="fp-email">Email</label>
                    <div class="form-input-wrap">
                        <input id="fp-email" type="email" class="form-input" placeholder="Email của bạn" autocomplete="email"/>
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                </div>

                <button class="btn-login" id="btn-send-otp">
                    <span class="btn-text">Gửi mã OTP</span>
                    <div class="spinner"></div>
                </button>
            </div>

            {{-- ── STEP 2: Nhập OTP ── --}}
            <div id="step-otp" style="display:none">
                <button class="back-link" onclick="goTo('step-email')">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Quay lại
                </button>
                <h1 class="login-heading" style="margin-top:1rem">Nhập mã OTP</h1>
                <p class="login-subheading">Chúng tôi đã gửi mã 6 số đến <strong id="otp-email-display" style="color:var(--accent)"></strong></p>

                <div id="alert-otp" class="login-alert" style="display:none">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="alert-otp-msg"></span>
                </div>

                {{-- OTP boxes --}}
                <div class="otp-wrap">
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp0"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp1"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp2"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp3"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp4"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp5"/>
                </div>

                <div class="otp-resend">
                    Không nhận được mã?
                    <button id="btn-resend" class="otp-resend-btn" onclick="resendOtp()">Gửi lại</button>
                    <span id="resend-timer" style="display:none;color:var(--text-dim)">(<span id="timer-count">60</span>s)</span>
                </div>

                <button class="btn-login" id="btn-verify-otp">
                    <span class="btn-text">Xác nhận</span>
                    <div class="spinner"></div>
                </button>
            </div>

            {{-- ── STEP 3: Đặt lại mật khẩu ── --}}
            <div id="step-reset" style="display:none">
                <h1 class="login-heading">Đặt lại mật khẩu</h1>
                <p class="login-subheading">Nhập mật khẩu mới cho tài khoản của bạn.</p>

                <div id="alert-reset" class="login-alert" style="display:none">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="alert-reset-msg"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="new-password">Mật khẩu mới</label>
                    <div class="form-input-wrap">
                        <input id="new-password" type="password" class="form-input" placeholder="Tối thiểu 8 ký tự"/>
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm-password">Xác nhận mật khẩu</label>
                    <div class="form-input-wrap">
                        <input id="confirm-password" type="password" class="form-input" placeholder="Nhập lại mật khẩu"/>
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                </div>

                <button class="btn-login" id="btn-reset">
                    <span class="btn-text">Đặt lại mật khẩu</span>
                    <div class="spinner"></div>
                </button>
            </div>

        </div>
    </div>

    {{-- RIGHT giữ nguyên như login --}}
    <div class="login-right">
        <canvas id="connectorCanvas"></canvas>

        <div class="float-card float-card-1" id="fc1">
            <div class="fc-label">Nhân viên hoạt động</div>
            <div class="fc-val">1,284</div>
            <div class="fc-tag">↑ +12 hôm nay</div>
        </div>
        <div class="float-card float-card-2" id="fc2">
            <div class="fc-label">Trạng thái hệ thống</div>
            <div style="display:flex;align-items:center;gap:6px;margin-top:4px">
                <div style="width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>
                <span style="font-size:12px;font-weight:700;color:#22c55e">Hoạt động ổn định</span>
            </div>
        </div>
        <div class="float-card float-card-3" id="fc3">
            <div class="fc-label">Phê duyệt hôm nay</div>
            <div style="display:flex;gap:5px;margin-top:5px;flex-wrap:wrap">
                <span class="fc-badge fc-badge-green">✓ 24 đã duyệt</span>
                <span class="fc-badge fc-badge-blue">⏳ 6 chờ</span>
            </div>
        </div>
        <div class="float-card float-card-4" id="fc4">
            <div class="fc-label">Lương tháng này</div>
            <div class="fc-val">2.4 tỷ</div>
            <div class="fc-tag" style="color:#FBBF24">↑ Đã xử lý</div>
        </div>
        <div class="float-card float-card-5" id="fc5">
            <div class="fc-label">Tuyển dụng</div>
            <div style="display:flex;gap:5px;margin-top:5px;flex-wrap:wrap">
                <span class="fc-badge fc-badge-purple">12 ứng viên</span>
                <span class="fc-badge fc-badge-green">3 offer</span>
            </div>
        </div>
        <div class="float-card float-card-6" id="fc6">
            <div class="fc-label">Chấm công hôm nay</div>
            <div class="fc-val">96.4%</div>
            <div class="fc-tag" style="color:#34D399">● Đúng giờ</div>
        </div>
        <div class="float-card float-card-7" id="fc7">
            <div class="fc-label">Đào tạo</div>
            <div class="fc-val">8 khóa</div>
            <div class="fc-tag" style="color:#A78BFA">Đang diễn ra</div>
        </div>

        <div class="login-right-content">
            <div class="login-right-logo" id="centerLogo">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <h2 class="login-right-title">Nền tảng quản lý<br>nhân sự <span>toàn diện</span></h2>
            <p class="login-right-desc">Tự động hoá quy trình HR, tính lương chính xác,<br>và phát triển nhân tài cùng NovaHRM.</p>
            <div class="login-stats">
                <div class="login-stat"><div class="login-stat-val">10K+</div><div class="login-stat-label">Doanh nghiệp</div></div>
                <div class="login-stat"><div class="login-stat-val">99.9%</div><div class="login-stat-label">Uptime</div></div>
                <div class="login-stat"><div class="login-stat-val">500K+</div><div class="login-stat-label">Nhân viên</div></div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentEmail = '';
    let timerInterval = null;

    // Chuyển step
    function goTo(stepId) {
        document.querySelectorAll('[id^="step-"]').forEach(el => {
            el.style.display = 'none';
            el.style.animation = '';
        });
        const el = document.getElementById(stepId);
        el.style.display = 'block';
        el.style.animation = 'fadeUp 0.35s ease both';
    }

    function showAlert(id, msg) {
        const el = document.getElementById(id);
        el.style.display = 'flex';
        document.getElementById(id + '-msg').textContent = msg;
    }
    function hideAlert(id) {
        document.getElementById(id).style.display = 'none';
    }

    function setLoading(btnId, loading) {
        const btn = document.getElementById(btnId);
        btn.classList.toggle('loading', loading);
        btn.disabled = loading;
    }

    // STEP 1: Gửi OTP
    document.getElementById('btn-send-otp').addEventListener('click', async () => {
        const email = document.getElementById('fp-email').value.trim();
        if (!email) return showAlert('alert-email', 'Vui lòng nhập email.');
        hideAlert('alert-email');
        setLoading('btn-send-otp', true);

        try {
            const res = await fetch('/forgot-password/send-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Có lỗi xảy ra.');
            currentEmail = email;
            document.getElementById('otp-email-display').textContent = email;
            goTo('step-otp');
            startTimer();
            document.getElementById('otp0').focus();
        } catch (e) {
            showAlert('alert-email', e.message);
        } finally {
            setLoading('btn-send-otp', false);
        }
    });

    // OTP input navigation
    document.querySelectorAll('.otp-input').forEach((input, i, inputs) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/g, '');
            if (input.value && i < inputs.length - 1) inputs[i + 1].focus();
        });
        input.addEventListener('keydown', e => {
            if (e.key === 'Backspace' && !input.value && i > 0) inputs[i - 1].focus();
        });
        input.addEventListener('paste', e => {
            e.preventDefault();
            const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            [...paste].slice(0, 6).forEach((ch, j) => {
                if (inputs[i + j]) inputs[i + j].value = ch;
            });
            const next = inputs[Math.min(i + paste.length, 5)];
            if (next) next.focus();
        });
    });

    // Timer đếm ngược gửi lại
    function startTimer() {
        let count = 60;
        document.getElementById('btn-resend').style.display = 'none';
        document.getElementById('resend-timer').style.display = 'inline';
        document.getElementById('timer-count').textContent = count;
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            count--;
            document.getElementById('timer-count').textContent = count;
            if (count <= 0) {
                clearInterval(timerInterval);
                document.getElementById('btn-resend').style.display = 'inline';
                document.getElementById('resend-timer').style.display = 'none';
            }
        }, 1000);
    }

    function resendOtp() {
        document.getElementById('btn-send-otp').click();
    }

    // STEP 2: Xác nhận OTP
    document.getElementById('btn-verify-otp').addEventListener('click', async () => {
        const otp = [...document.querySelectorAll('.otp-input')].map(i => i.value).join('');
        if (otp.length < 6) return showAlert('alert-otp', 'Vui lòng nhập đủ 6 số.');
        hideAlert('alert-otp');
        setLoading('btn-verify-otp', true);

        try {
            const res = await fetch('/forgot-password/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: currentEmail, otp })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Mã OTP không hợp lệ.');
            goTo('step-reset');
        } catch (e) {
            showAlert('alert-otp', e.message);
        } finally {
            setLoading('btn-verify-otp', false);
        }
    });

    // STEP 3: Đặt lại mật khẩu
    document.getElementById('btn-reset').addEventListener('click', async () => {
        const password = document.getElementById('new-password').value;
        const confirm  = document.getElementById('confirm-password').value;
        if (password.length < 8) return showAlert('alert-reset', 'Mật khẩu tối thiểu 8 ký tự.');
        if (password !== confirm) return showAlert('alert-reset', 'Mật khẩu xác nhận không khớp.');
        hideAlert('alert-reset');
        setLoading('btn-reset', true);

        try {
            const res = await fetch('/forgot-password/reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: currentEmail, password, password_confirmation: confirm })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Có lỗi xảy ra.');
            window.location.href = '/login';
        } catch (e) {
            showAlert('alert-reset', e.message);
        } finally {
            setLoading('btn-reset', false);
        }
    });
</script>

</body>
</html>