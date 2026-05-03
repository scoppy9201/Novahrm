<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('nova-auth::app.title') — NovaHRM</title>
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

            {{-- STEP 1: Nhập email --}}
            <div id="step-email">
                <a href="{{ route('login') }}" class="back-link">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    @lang('nova-auth::app.navigation.back_login')
                </a>
                <h1 class="login-heading" style="margin-top:1rem">
                    @lang('nova-auth::app.steps.email.title')
                </h1>
                <p class="login-subheading">
                    @lang('nova-auth::app.steps.email.description')
                </p>

                <div id="alert-email" class="login-alert" style="display:none">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="alert-email-msg"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="fp-email">@lang('nova-auth::app.auth.email')</label>
                    <div class="form-input-wrap">
                        <input
                            id="fp-email"
                            type="email"
                            class="form-input"
                            placeholder="@lang('nova-auth::app.auth.email_placeholder')"
                            autocomplete="email"
                        />
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                </div>

                <button class="btn-login" id="btn-send-otp">
                    <span class="btn-text">@lang('nova-auth::app.steps.email.send_otp')</span>
                    <div class="spinner"></div>
                </button>
            </div>

            {{-- STEP 2: Nhập OTP --}}
            <div id="step-otp" style="display:none">
                <button class="back-link" onclick="goTo('step-email')">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    @lang('nova-auth::app.navigation.back')
                </button>
                <h1 class="login-heading" style="margin-top:1rem">
                    @lang('nova-auth::app.steps.otp.title')
                </h1>
                <p class="login-subheading">
                    @lang('nova-auth::app.steps.otp.description')
                    <strong id="otp-email-display" style="color:var(--accent)"></strong>
                </p>

                <div id="alert-otp" class="login-alert" style="display:none">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="alert-otp-msg"></span>
                </div>

                <div class="otp-wrap">
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp0"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp1"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp2"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp3"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp4"/>
                    <input class="otp-input" type="text" maxlength="1" inputmode="numeric" id="otp5"/>
                </div>

                <div class="otp-resend">
                    @lang('nova-auth::app.steps.otp.not_received')
                    <button id="btn-resend" class="otp-resend-btn" onclick="resendOtp()">
                        @lang('nova-auth::app.steps.otp.resend')
                    </button>
                    <span id="resend-timer" style="display:none;color:var(--text-dim)">
                        (<span id="timer-count">60</span>s)
                    </span>
                </div>

                <button class="btn-login" id="btn-verify-otp">
                    <span class="btn-text">@lang('nova-auth::app.steps.otp.confirm')</span>
                    <div class="spinner"></div>
                </button>
            </div>

            {{-- STEP 3: Đặt lại mật khẩu --}}
            <div id="step-reset" style="display:none">
                <h1 class="login-heading">@lang('nova-auth::app.steps.reset.title')</h1>
                <p class="login-subheading">@lang('nova-auth::app.steps.reset.description')</p>

                <div id="alert-reset" class="login-alert" style="display:none">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span id="alert-reset-msg"></span>
                </div>

                <div class="form-group">
                    <label class="form-label" for="new-password">
                        @lang('nova-auth::app.steps.reset.new_password')
                    </label>
                    <div class="form-input-wrap">
                        <input
                            id="new-password"
                            type="password"
                            class="form-input"
                            placeholder="@lang('nova-auth::app.steps.reset.new_password_placeholder')"
                        />
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="confirm-password">
                        @lang('nova-auth::app.steps.reset.confirm_password')
                    </label>
                    <div class="form-input-wrap">
                        <input
                            id="confirm-password"
                            type="password"
                            class="form-input"
                            placeholder="@lang('nova-auth::app.steps.reset.confirm_password_placeholder')"
                        />
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                </div>

                <button class="btn-login" id="btn-reset">
                    <span class="btn-text">@lang('nova-auth::app.steps.reset.submit')</span>
                    <div class="spinner"></div>
                </button>
            </div>

        </div>
    </div>

    {{-- RIGHT --}}
    <div class="login-right">
        <canvas id="connectorCanvas"></canvas>

        <div class="float-card float-card-1" id="fc1">
            <div class="fc-label">@lang('nova-auth::app.dashboard.employees_active')</div>
            <div class="fc-val">1,284</div>
            <div class="fc-tag">@lang('nova-auth::app.dashboard.today_up')</div>
        </div>

        <div class="float-card float-card-2" id="fc2">
            <div class="fc-label">@lang('nova-auth::app.dashboard.system_status')</div>
            <div style="display:flex;align-items:center;gap:6px;margin-top:4px">
                <div style="width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>
                <span style="font-size:12px;font-weight:700;color:#22c55e">
                    @lang('nova-auth::app.dashboard.system_online')
                </span>
            </div>
        </div>

        <div class="float-card float-card-3" id="fc3">
            <div class="fc-label">@lang('nova-auth::app.dashboard.today_approval')</div>
            <div style="display:flex;gap:5px;margin-top:5px;flex-wrap:wrap">
                <span class="fc-badge fc-badge-green">@lang('nova-auth::app.dashboard.approved')</span>
                <span class="fc-badge fc-badge-blue">@lang('nova-auth::app.dashboard.pending')</span>
            </div>
        </div>

        <div class="float-card float-card-4" id="fc4">
            <div class="fc-label">@lang('nova-auth::app.dashboard.salary_this_month')</div>
            <div class="fc-val">2.4 tỷ</div>
            <div class="fc-tag" style="color:#FBBF24">@lang('nova-auth::app.dashboard.salary_processed')</div>
        </div>

        <div class="float-card float-card-5" id="fc5">
            <div class="fc-label">@lang('nova-auth::app.dashboard.recruitment')</div>
            <div style="display:flex;gap:5px;margin-top:5px;flex-wrap:wrap">
                <span class="fc-badge fc-badge-purple">@lang('nova-auth::app.dashboard.candidates')</span>
                <span class="fc-badge fc-badge-green">@lang('nova-auth::app.dashboard.offers')</span>
            </div>
        </div>

        <div class="float-card float-card-6" id="fc6">
            <div class="fc-label">@lang('nova-auth::app.dashboard.attendance_today')</div>
            <div class="fc-val">96.4%</div>
            <div class="fc-tag" style="color:#34D399">@lang('nova-auth::app.dashboard.attendance_ontime')</div>
        </div>

        <div class="float-card float-card-7" id="fc7">
            <div class="fc-label">@lang('nova-auth::app.dashboard.training')</div>
            <div class="fc-val">@lang('nova-auth::app.dashboard.courses')</div>
            <div class="fc-tag" style="color:#A78BFA">@lang('nova-auth::app.dashboard.training_running')</div>
        </div>

        <div class="login-right-content">
            <div class="login-right-logo" id="centerLogo">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <h2 class="login-right-title">
                @lang('nova-auth::app.hero.title_line_1')<br>
                @lang('nova-auth::app.hero.title_line_2') <span>@lang('nova-auth::app.hero.title_highlight')</span>
            </h2>
            <p class="login-right-desc">@lang('nova-auth::app.hero.description')</p>
            <div class="login-stats">
                <div class="login-stat">
                    <div class="login-stat-val">10K+</div>
                    <div class="login-stat-label">@lang('nova-auth::app.hero.businesses')</div>
                </div>
                <div class="login-stat">
                    <div class="login-stat-val">99.9%</div>
                    <div class="login-stat-label">@lang('nova-auth::app.hero.uptime')</div>
                </div>
                <div class="login-stat">
                    <div class="login-stat-val">500K+</div>
                    <div class="login-stat-label">@lang('nova-auth::app.hero.employees')</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Các message lấy từ Blade để JS dùng
    const __lang = {
        emailRequired:   @json(__('nova-auth::app.steps.email.email_required')),
        otpSent:         @json(__('nova-auth::app.steps.email.otp_sent')),
        otpRequired:     @json(__('nova-auth::app.steps.otp.otp_required')),
        otpInvalid:      @json(__('nova-auth::app.steps.otp.otp_invalid')),
        otpSuccess:      @json(__('nova-auth::app.steps.otp.otp_success')),
        passwordMin:     @json(__('nova-auth::app.steps.reset.password_min')),
        passwordNoMatch: @json(__('nova-auth::app.steps.reset.password_not_match')),
        resetSuccess:    @json(__('nova-auth::app.steps.reset.reset_success')),
    };

    let currentEmail = '';
    let timerInterval = null;

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
        novaToast(msg, 'error', 4200);
    }
    function hideAlert(id) { return id; }

    function setLoading(btnId, loading) {
        const btn = document.getElementById(btnId);
        btn.classList.toggle('loading', loading);
        btn.disabled = loading;
    }

    // STEP 1
    document.getElementById('btn-send-otp').addEventListener('click', async () => {
        const email = document.getElementById('fp-email').value.trim();
        if (!email) return showAlert('alert-email', __lang.emailRequired);
        hideAlert('alert-email');
        setLoading('btn-send-otp', true);
        try {
            const res = await fetch('/forgot-password/send-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || __lang.otpInvalid);
            currentEmail = email;
            document.getElementById('otp-email-display').textContent = email;
            novaToast(__lang.otpSent, 'success');
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
            input.value = input.value.replace(/\D/g, '').slice(-1);
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

    // STEP 2
    document.getElementById('btn-verify-otp').addEventListener('click', async () => {
        const otp = [...document.querySelectorAll('.otp-input')].map(i => i.value).join('');
        if (otp.length < 6) return showAlert('alert-otp', __lang.otpRequired);
        hideAlert('alert-otp');
        setLoading('btn-verify-otp', true);
        try {
            const res = await fetch('/forgot-password/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: currentEmail, otp })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || __lang.otpInvalid);
            novaToast(__lang.otpSuccess, 'success');
            goTo('step-reset');
        } catch (e) {
            showAlert('alert-otp', e.message);
        } finally {
            setLoading('btn-verify-otp', false);
        }
    });

    // STEP 3
    document.getElementById('btn-reset').addEventListener('click', async () => {
        const password = document.getElementById('new-password').value;
        const confirm  = document.getElementById('confirm-password').value;
        if (password.length < 8) return showAlert('alert-reset', __lang.passwordMin);
        if (password !== confirm) return showAlert('alert-reset', __lang.passwordNoMatch);
        hideAlert('alert-reset');
        setLoading('btn-reset', true);
        try {
            const res = await fetch('/forgot-password/reset', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ email: currentEmail, password, password_confirmation: confirm })
            });
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || __lang.otpInvalid);
            novaToast(__lang.resetSuccess, 'success', 1800);
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