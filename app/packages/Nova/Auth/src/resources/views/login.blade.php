<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập — NovaHRM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:300,400,500,600,700,800,900" rel="stylesheet"/>
    <script>
        window.__routes = {
            novaIdSend:      "{{ route('nova-id.send') }}",
            novaIdVerifyOtp: "{{ route('nova-id.verify-otp') }}",
        };
    </script>
    @vite([
        'app/packages/Nova/Auth/src/resources/css/app.css',
        'app/packages/Nova/Auth/src/resources/js/app.js',
    ])
</head>
<body>

<div class="login-wrap">
    {{-- ── LEFT: Form ── --}}
    <div class="login-left">
        {{-- Logo --}}
        <a href="/" class="login-logo">
            <div class="login-logo-icon">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>
            <span class="login-logo-text">Nova<span>HRM</span></span>
        </a>

        <div class="login-form-wrap">
            <h1 class="login-heading">Đăng nhập</h1>
            <p class="login-subheading">Chào mừng trở lại. Đăng nhập để bắt đầu làm việc.</p>

            <form method="POST" action="{{ route('login.store') }}" id="loginForm">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="form-input-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-input"
                            placeholder="Email của bạn"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:7px;">
                        <label class="form-label" style="margin:0;" for="password">Mật khẩu</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:12px; color:var(--accent); text-decoration:underline; font-weight:600;">Quên mật khẩu?</a>
                        @endif
                    </div>
                    <div class="form-input-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="Mật khẩu của bạn"
                            autocomplete="current-password"
                            required
                        >
                        <svg class="form-input-icon" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <button type="button" class="pw-toggle" id="pwToggle" tabindex="-1">
                            <svg id="eyeIcon" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember + Forgot --}}
                <div class="form-row-between">
                    <label class="form-checkbox-wrap">
                        <input type="checkbox" name="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-checkbox-label">Giữ tôi luôn đăng nhập</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">Đăng nhập</span>
                    <div class="spinner"></div>
                </button>
                
            </form>

            <a href="#" class="btn-nova-sso" onclick="event.preventDefault(); nidOpen()">
                <div class="login-logo-icon">
                    <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
                </div>
                Đăng nhập bằng Nova ID
            </a>

            {{-- Divider --}}
            <div class="login-divider">
                <div class="login-divider-line"></div>
                <span class="login-divider-text">Hoặc đăng nhập thông qua SSO</span>
                <div class="login-divider-line"></div>
            </div>

            {{-- SSO --}}
            <div class="sso-grid">
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Đăng nhập bằng Google
                </a>
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M11.4 0H0v11.4h11.4V0z" fill="#F25022"/>
                        <path d="M24 0H12.6v11.4H24V0z" fill="#7FBA00"/>
                        <path d="M11.4 12.6H0V24h11.4V12.6z" fill="#00A4EF"/>
                        <path d="M24 12.6H12.6V24H24V12.6z" fill="#FFB900"/>
                    </svg>
                    Đăng nhập bằng Microsoft
                </a>
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641 0 12.017 0z"/>
                    </svg>
                    Đăng nhập bằng Apple
                </a>
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    Đăng nhập bằng SAML
                </a>
            </div>

            <div class="login-bottom-note">
                Cần hỗ trợ? <a href="#">Liên hệ quản trị viên</a>
            </div>

        </div>
    </div>

    {{-- ── RIGHT: Visual ── --}}
    <div class="login-right">

        {{-- Canvas vẽ đường nối --}}
        <canvas id="connectorCanvas"></canvas>

        {{-- Floating cards --}}
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

        {{-- Center content giữ nguyên --}}
        <div class="login-right-content">
            <div class="login-right-logo" id="centerLogo">
                <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
            </div>

            <h2 class="login-right-title">
                Nền tảng quản lý<br>nhân sự <span>toàn diện</span>
            </h2>
            <p class="login-right-desc">
                Tự động hoá quy trình HR, tính lương chính xác,<br>
                và phát triển nhân tài cùng NovaHRM.
            </p>

            <div class="login-stats">
                <div class="login-stat">
                    <div class="login-stat-val">10K+</div>
                    <div class="login-stat-label">Doanh nghiệp</div>
                </div>
                <div class="login-stat">
                    <div class="login-stat-val">99.9%</div>
                    <div class="login-stat-label">Uptime</div>
                </div>
                <div class="login-stat">
                    <div class="login-stat-val">500K+</div>
                    <div class="login-stat-label">Nhân viên</div>
                </div>
            </div>
        </div>
    </div>
</div>
    {{-- Flash flags --}}
    @if(session('login_success'))
        <script>window.__loginSuccess = true;</script>
    @endif

    @if(session('logout_success'))
        <script>window.__logoutSuccess = true;</script>
    @endif

    {{-- Form logout ẩn --}}
    @if ($errors->any())
        <script>window.__loginError = @json($errors->first());</script>
    @elseif (session('error'))
        <script>window.__loginError = @json(session('error'));</script>
    @endif

    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:none;">
        @csrf
    </form>

    @include('nova-auth::nova-id-modal')
</body>
</html>
