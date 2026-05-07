<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('nova-auth::app.auth.login_title') — NovaHRM</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:300,400,500,600,700,800,900" rel="stylesheet"/>
    <script>
        window.__routes = {
            novaIdSend:      "{{ route('nova-id.send') }}",
            novaIdVerifyOtp: "{{ route('nova-id.verify-otp') }}",
        };
    </script>
    @vite([
        'packages/Nova/Auth/src/resources/css/app.css',
        'packages/Nova/Auth/src/resources/js/app.js',
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
            <h1 class="login-heading">@lang('nova-auth::app.auth.login_title')</h1>
            <p class="login-subheading">@lang('nova-auth::app.auth.login_subtitle', ['platform' => __('nova-auth::app.auth.platform')])</p>

            <form method="POST" action="{{ route('login.store') }}" id="loginForm">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" for="email">@lang('nova-auth::app.auth.email')</label>
                    <div class="form-input-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            class="form-input"
                            placeholder="@lang('nova-auth::app.auth.email_placeholder')"
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
                        <label class="form-label" style="margin:0;" for="password">@lang('nova-auth::app.auth.password')</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:12px; color:var(--accent); text-decoration:underline; font-weight:600;">
                                @lang('nova-auth::app.auth.forgot_password')
                            </a>
                        @endif
                    </div>
                    <div class="form-input-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-input"
                            placeholder="@lang('nova-auth::app.auth.password_placeholder')"
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

                {{-- Remember --}}
                <div class="form-row-between">
                    <label class="form-checkbox-wrap">
                        <input type="checkbox" name="remember" class="form-checkbox" {{ old('remember') ? 'checked' : '' }}>
                        <span class="form-checkbox-label">@lang('nova-auth::app.auth.remember_me')</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">@lang('nova-auth::app.auth.login_button')</span>
                    <div class="spinner"></div>
                </button>
            </form>

            {{-- Nova ID --}}
            <a href="#" class="btn-nova-sso" onclick="event.preventDefault(); nidOpen()">
                <div class="login-logo-icon">
                    <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
                </div>
                @lang('nova-auth::app.auth.login_with_nova_id')
            </a>

            {{-- Divider --}}
            <div class="login-divider">
                <div class="login-divider-line"></div>
                <span class="login-divider-text">@lang('nova-auth::app.sso.divider')</span>
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
                    @lang('nova-auth::app.sso.google')
                </a>
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M11.4 0H0v11.4h11.4V0z" fill="#F25022"/>
                        <path d="M24 0H12.6v11.4H24V0z" fill="#7FBA00"/>
                        <path d="M11.4 12.6H0V24h11.4V12.6z" fill="#00A4EF"/>
                        <path d="M24 12.6H12.6V24H24V12.6z" fill="#FFB900"/>
                    </svg>
                    @lang('nova-auth::app.sso.microsoft')
                </a>
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.8-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                    </svg>
                    @lang('nova-auth::app.sso.apple')
                </a>
                <a href="#" class="btn-sso">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                    @lang('nova-auth::app.sso.saml')
                </a>
            </div>

            <div class="login-bottom-note">
                @lang('nova-auth::app.support.need_help')
                <a href="#">@lang('nova-auth::app.support.contact_admin')</a>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Visual ── --}}
    <div class="login-right">

        <canvas id="connectorCanvas"></canvas>

        {{-- Floating cards --}}
        <div class="float-card float-card-1" id="fc1">
            <div class="fc-label">@lang('nova-auth::app.dashboard.employees_active')</div>
            <div class="fc-val">1,284</div>
            <div class="fc-tag">@lang('nova-auth::app.dashboard.today_up')</div>
        </div>

        <div class="float-card float-card-2" id="fc2">
            <div class="fc-label">@lang('nova-auth::app.dashboard.system_status')</div>
            <div style="display:flex;align-items:center;gap:6px;margin-top:4px">
                <div style="width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>
                <span style="font-size:12px;font-weight:700;color:#22c55e">@lang('nova-auth::app.dashboard.system_online')</span>
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
            <p class="login-right-desc">
                @lang('nova-auth::app.hero.description')
            </p>

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

@if(session('login_success'))
    <script>window.__loginSuccess = true;</script>
@endif

@if(session('logout_success'))
    <script>window.__logoutSuccess = true;</script>
@endif

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
