<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NovaHRM - Hệ thống quản lý nhân sự</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:300,400,500,600,700,800" rel="stylesheet" />
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --blue: #1565C0;
            --blue-dark: #0d47a1;
            --blue-light: #1976D2;
            --blue-pale: #EFF6FF;
            --blue-mid: #93C5FD;
            --white: #fff;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-900: #0f172a;
            --text: #0f172a;
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Be Vietnam Pro', sans-serif; color: var(--text); background: var(--white); overflow-x: hidden; }

        /* ── SCROLL REVEAL ── */
        .reveal {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity .7s cubic-bezier(.22,1,.36,1), transform .7s cubic-bezier(.22,1,.36,1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }
        .reveal-delay-4 { transition-delay: .4s; }
        .reveal-delay-5 { transition-delay: .5s; }

        /* ── TOPBAR ── */
        .topbar {
            background: #EFF6FF;
            border-bottom: 1px solid #BFDBFE;
            padding: 7px 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 12px; color: var(--gray-500);
        }
        .topbar-left { display: flex; align-items: center; gap: 8px; }
        .dot-live {
            width: 7px; height: 7px; border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 0 3px rgba(34,197,94,0.18);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%,100% { box-shadow: 0 0 0 3px rgba(34,197,94,0.18); }
            50% { box-shadow: 0 0 0 6px rgba(34,197,94,0.07); }
        }
        .topbar-right { display: flex; align-items: center; gap: 1.5rem; }
        .topbar-right a { color: var(--gray-500); text-decoration: none; transition: color .2s; font-size: 12px; }
        .topbar-right a:hover { color: var(--blue); }
        .tdiv { width: 1px; height: 12px; background: var(--gray-200); }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky; top: 0; z-index: 200;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--gray-200);
            padding: 0 2.5rem;
            display: flex; align-items: center; justify-content: space-between;
            height: 68px;
            transition: box-shadow .3s;
        }
        .navbar.scrolled { box-shadow: 0 4px 24px rgba(15,23,42,0.07); }
        .logo { font-size: 20px; font-weight: 800; color: var(--blue); text-decoration: none; letter-spacing: -0.5px; }
        .logo span { color: #60A5FA; }
        .nav-links { display: flex; align-items: center; gap: 2.2rem; }
        .nav-links a { font-size: 14px; font-weight: 500; color: var(--gray-700); text-decoration: none; transition: color .2s; position: relative; }
        .nav-links a::after { content:''; position:absolute; bottom:-2px; left:0; right:0; height:2px; background:var(--blue); border-radius:2px; transform:scaleX(0); transition:transform .25s; }
        .nav-links a:hover { color: var(--blue); }
        .nav-links a:hover::after { transform: scaleX(1); }
        .nav-actions { display: flex; align-items: center; gap: 10px; }
        .btn-ghost { padding: 8px 18px; border: 1.5px solid var(--gray-200); color: var(--gray-700); background: transparent; border-radius: 100px; font-size: 13.5px; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .2s; font-family: inherit; }
        .btn-ghost:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-pale); }
        .btn-nav-solid { padding: 8px 22px; background: var(--blue); color: #fff; border: none; border-radius: 100px; font-size: 13.5px; font-weight: 600; cursor: pointer; text-decoration: none; transition: background .2s, transform .15s, box-shadow .2s; font-family: inherit; box-shadow: 0 2px 12px rgba(21,101,192,0.25); }
        .btn-nav-solid:hover { background: var(--blue-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(21,101,192,0.3); }

        /* ── HERO ── */
        .hero { position: relative; min-height: 92vh; display: flex; align-items: center; overflow: hidden; }
        .hero-bg {
            position: absolute; inset: 0;
            background: url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1800&q=80') center/cover no-repeat;
            filter: brightness(0.25);
            z-index: 0;
            transform: scale(1.05);
            animation: slow-zoom 20s ease-in-out infinite alternate;
        }
        @keyframes slow-zoom { from { transform: scale(1.05); } to { transform: scale(1.12); } }
        .hero-gradient { position: absolute; inset: 0; background: linear-gradient(105deg, rgba(13,71,161,0.82) 0%, rgba(21,101,192,0.45) 50%, rgba(0,0,0,0.1) 100%); z-index: 1; }
        .hero-noise { position: absolute; inset: 0; z-index: 2; opacity: .03; background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E"); }

        .hero-content { position: relative; z-index: 3; padding: 0 2.5rem; max-width: 720px; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 10px; font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: #93C5FD; margin-bottom: 1.5rem; animation: fadeUp .6s .1s ease both; }
        .hero-eyebrow::before { content: ''; display: block; width: 28px; height: 2px; background: linear-gradient(90deg, #60A5FA, transparent); border-radius: 2px; }
        .hero-title { font-size: clamp(36px, 5.5vw, 60px); font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 1.4rem; letter-spacing: -1.5px; animation: fadeUp .6s .18s ease both; }
        .hero-title em { color: #60A5FA; font-style: normal; }
        .hero-title .dot { color: #3B82F6; }
        .hero-desc { font-size: 16.5px; color: #BFDBFE; line-height: 1.8; margin-bottom: 2.5rem; max-width: 520px; animation: fadeUp .6s .26s ease both; }
        .hero-btns { display: flex; gap: 14px; flex-wrap: wrap; animation: fadeUp .6s .34s ease both; }
        .btn-hero-fill { padding: 15px 32px; background: var(--blue); color: #fff; border: none; border-radius: 100px; font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none; transition: background .2s, transform .15s, box-shadow .2s; font-family: inherit; box-shadow: 0 4px 20px rgba(21,101,192,0.4); }
        .btn-hero-fill:hover { background: var(--blue-dark); transform: translateY(-2px); box-shadow: 0 8px 28px rgba(21,101,192,0.5); }
        .btn-hero-border { padding: 14px 32px; background: rgba(255,255,255,0.08); color: #fff; border: 1.5px solid rgba(255,255,255,0.35); border-radius: 100px; font-size: 15px; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .2s; font-family: inherit; backdrop-filter: blur(8px); }
        .btn-hero-border:hover { background: rgba(255,255,255,0.16); border-color: rgba(255,255,255,0.6); transform: translateY(-1px); }

        /* hero stat cards */
        .hero-cards { position: absolute; right: 4rem; top: 50%; transform: translateY(-50%); z-index: 3; display: flex; flex-direction: column; gap: 14px; animation: fadeLeft .7s .4s ease both; }
        @keyframes fadeLeft { from { opacity:0; transform: translateX(30px) translateY(-50%); } to { opacity:1; transform: translateX(0) translateY(-50%); } }
        .fcard { background: rgba(255,255,255,0.09); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.16); border-radius: 18px; padding: 16px 22px; min-width: 220px; transition: transform .3s, background .3s; }
        .fcard:hover { transform: translateY(-3px); background: rgba(255,255,255,0.14); }
        .fcard-label { font-size: 11px; color: #93C5FD; margin-bottom: 6px; font-weight: 500; letter-spacing: .5px; }
        .fcard-val { font-size: 24px; font-weight: 800; color: #fff; line-height: 1; letter-spacing: -0.5px; }
        .fcard-tag { display: inline-flex; align-items: center; gap: 4px; margin-top: 8px; background: rgba(96,165,250,0.18); color: #93C5FD; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .fcard-tag::before { content: '↑'; font-size: 10px; }

        /* scroll indicator */
        .scroll-down { position: absolute; bottom: 2.5rem; left: 50%; transform: translateX(-50%); z-index: 3; display: flex; flex-direction: column; align-items: center; gap: 8px; color: rgba(255,255,255,0.3); font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; animation: fadeUp 1s .8s ease both; }
        .scroll-mouse { width: 22px; height: 34px; border: 1.5px solid rgba(255,255,255,0.25); border-radius: 12px; display: flex; justify-content: center; padding-top: 6px; }
        .scroll-wheel { width: 3px; height: 6px; background: rgba(255,255,255,0.4); border-radius: 2px; animation: scroll-anim 1.8s infinite; }
        @keyframes scroll-anim { 0%{opacity:1;transform:translateY(0)} 80%{opacity:0;transform:translateY(10px)} 100%{opacity:0} }

        /* ── STATS STRIP ── */
        .stats-strip { background: var(--blue); padding: 3rem 2.5rem; display: flex; justify-content: center; gap: 0; flex-wrap: wrap; }
        .sstat { text-align: center; padding: 0 4rem; position: relative; }
        .sstat:not(:last-child)::after { content:''; position:absolute; right:0; top:50%; transform:translateY(-50%); height:40px; width:1px; background:rgba(255,255,255,0.15); }
        .sstat-num { font-size: 36px; font-weight: 800; color: #fff; letter-spacing: -1px; }
        .sstat-lbl { font-size: 13px; color: #93C5FD; margin-top: 4px; font-weight: 500; }

        /* ── SECTION BASE ── */
        .section { padding: 6rem 2.5rem; }
        .section-alt { background: var(--gray-50); }
        .s-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--blue); margin-bottom: 0.75rem; }
        .s-title { font-size: clamp(28px, 3.5vw, 42px); font-weight: 800; color: var(--text); line-height: 1.15; max-width: 500px; margin-bottom: 0.5rem; letter-spacing: -1px; }
        .s-sub { font-size: 15px; color: var(--gray-500); line-height: 1.75; max-width: 480px; margin-bottom: 3.5rem; }

        /* ── FEATURES ── */
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 20px; }
        .fcard2 { background: var(--white); border: 1px solid var(--gray-200); border-radius: 20px; padding: 2.2rem; transition: box-shadow .3s, transform .3s, border-color .3s; position: relative; overflow: hidden; }
        .fcard2::before { content:''; position:absolute; inset:0; background: linear-gradient(135deg, rgba(21,101,192,0.03) 0%, transparent 60%); opacity:0; transition: opacity .3s; }
        .fcard2:hover { box-shadow: 0 16px 48px rgba(21,101,192,0.12); transform: translateY(-4px); border-color: #BFDBFE; }
        .fcard2:hover::before { opacity: 1; }
        .fcard2-icon { width: 52px; height: 52px; border-radius: 16px; background: var(--blue-pale); display: flex; align-items: center; justify-content: center; margin-bottom: 1.4rem; transition: background .3s, transform .3s; }
        .fcard2:hover .fcard2-icon { background: #DBEAFE; transform: scale(1.08); }
        .fcard2-icon svg { width: 24px; height: 24px; stroke: var(--blue); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .fcard2-title { font-size: 15.5px; font-weight: 700; color: var(--text); margin-bottom: 9px; }
        .fcard2-desc { font-size: 13.5px; color: var(--gray-500); line-height: 1.8; }

        /* ── HOW IT WORKS ── */
        .steps-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 3rem; }
        .step { text-align: center; }
        .step-num { width: 56px; height: 56px; border-radius: 50%; background: var(--blue); color: #fff; font-size: 20px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.4rem; box-shadow: 0 8px 24px rgba(21,101,192,0.3); transition: transform .3s, box-shadow .3s; }
        .step:hover .step-num { transform: scale(1.1); box-shadow: 0 12px 32px rgba(21,101,192,0.4); }
        .step-title { font-size: 16px; font-weight: 700; margin-bottom: 9px; color: var(--text); }
        .step-desc { font-size: 13.5px; color: var(--gray-500); line-height: 1.8; }
        .step-connector { display: none; }

        /* ── CTA ── */
        .cta-section { background: linear-gradient(135deg, #0d47a1 0%, #1565C0 50%, #1976D2 100%); padding: 6rem 2.5rem; text-align: center; position: relative; overflow: hidden; }
        .cta-section::before { content:''; position:absolute; top:-60%; left:-10%; width:60%; height:200%; background: rgba(255,255,255,0.03); border-radius: 50%; }
        .cta-section::after { content:''; position:absolute; bottom:-60%; right:-10%; width:50%; height:200%; background: rgba(255,255,255,0.03); border-radius: 50%; }
        .cta-inner { position: relative; z-index: 1; }
        .cta-badge { display: inline-block; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: #BFDBFE; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 16px; border-radius: 100px; margin-bottom: 1.5rem; }
        .cta-title { font-size: clamp(28px, 4vw, 44px); font-weight: 800; color: #fff; margin-bottom: 1rem; letter-spacing: -1px; line-height: 1.15; }
        .cta-sub { font-size: 16px; color: #BFDBFE; margin-bottom: 2.5rem; line-height: 1.7; }
        .cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .btn-cta-white { padding: 15px 32px; background: #fff; color: var(--blue); border: none; border-radius: 100px; font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none; transition: transform .2s, box-shadow .2s; font-family: inherit; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }
        .btn-cta-white:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(0,0,0,0.2); }
        .btn-cta-outline { padding: 14px 32px; background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,0.4); border-radius: 100px; font-size: 15px; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .2s; font-family: inherit; }
        .btn-cta-outline:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.7); transform: translateY(-1px); }

        /* ── FOOTER ── */
        footer { background: var(--gray-900); padding: 2rem 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .footer-logo { font-size: 17px; font-weight: 800; color: #60A5FA; letter-spacing: -0.3px; }
        .footer-logo span { color: #93C5FD; }
        .footer-links { display: flex; gap: 1.5rem; }
        .footer-links a { font-size: 12px; color: #475569; text-decoration: none; transition: color .2s; }
        .footer-links a:hover { color: #60A5FA; }
        footer p { font-size: 12px; color: #334155; }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 900px) {
            .hero-cards { display: none; }
            .sstat { padding: 1rem 2.5rem; }
            .sstat:not(:last-child)::after { display:none; }
        }
        @media (max-width: 768px) {
            .topbar, .nav-links { display: none; }
            .hero-content { padding: 0 1.5rem; }
            .section { padding: 4rem 1.5rem; }
            .cta-section { padding: 4rem 1.5rem; }
            footer { justify-content: center; text-align: center; flex-direction: column; }
            .footer-links { justify-content: center; }
        }
    </style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
    <div class="topbar-left">
        <span class="dot-live"></span>
        Hệ thống đang hoạt động bình thường
    </div>
    <div class="topbar-right">
        <a href="#">Hỗ trợ kỹ thuật</a>
        <div class="tdiv"></div>
        <a href="#">Liên hệ HR</a>
        <div class="tdiv"></div>
        @auth
            <a href="{{ url('/admin') }}">Vào hệ thống</a>
        @else
            <a href="{{ route('filament.admin.auth.login') }}">Đăng nhập</a>
        @endauth
    </div>
</div>

{{-- NAVBAR --}}
<nav class="navbar" id="navbar">
    <a href="/" class="logo">Nova<span>HRM</span></a>
    <div class="nav-links">
        <a href="#features">Tính năng</a>
        <a href="#how">Cách dùng</a>
        <a href="#cta">Liên hệ</a>
    </div>
    <div class="nav-actions">
        @auth
            <a href="{{ url('/admin') }}" class="btn-ghost">Dashboard</a>
        @else
            <a href="{{ route('filament.admin.auth.login') }}" class="btn-ghost">Đăng nhập</a>
            <a href="{{ route('filament.admin.auth.register') }}" class="btn-nav-solid">Bắt đầu miễn phí</a>
        @endauth
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-gradient"></div>
    <div class="hero-noise"></div>
    <div class="hero-content">
        <div class="hero-eyebrow">Hệ thống quản lý nhân sự</div>
        <h1 class="hero-title">
            Nơi các đội nhân sự<br>
            tìm đến để <em>phát triển</em><span class="dot"> .</span>
        </h1>
        <p class="hero-desc">Kết hợp quản lý nhân viên, chấm công và tính lương trên một nền tảng duy nhất — được hỗ trợ bởi công nghệ hiện đại, mang lại kết quả nhanh chóng.</p>
        <div class="hero-btns">
            <a href="{{ route('filament.admin.auth.login') }}" class="btn-hero-fill">Vào hệ thống</a>
            <a href="#features" class="btn-hero-border">Xem tính năng</a>
        </div>
    </div>
    <div class="hero-cards">
        <div class="fcard">
            <div class="fcard-label">Nhân viên đang quản lý</div>
            <div class="fcard-val">50,000+</div>
            <div class="fcard-tag">12% tháng này</div>
        </div>
        <div class="fcard">
            <div class="fcard-label">Tỉ lệ chấm công đúng giờ</div>
            <div class="fcard-val">98.4%</div>
            <div class="fcard-tag">Đạt mục tiêu</div>
        </div>
        <div class="fcard">
            <div class="fcard-label">Doanh nghiệp tin dùng</div>
            <div class="fcard-val">500+</div>
            <div class="fcard-tag">Toàn quốc</div>
        </div>
    </div>
    <div class="scroll-down">
        <div class="scroll-mouse"><div class="scroll-wheel"></div></div>
        <span>Cuộn xuống</span>
    </div>
</section>

{{-- STATS --}}
<div class="stats-strip">
    <div class="sstat reveal"><div class="sstat-num">500+</div><div class="sstat-lbl">Doanh nghiệp tin dùng</div></div>
    <div class="sstat reveal reveal-delay-1"><div class="sstat-num">50k+</div><div class="sstat-lbl">Nhân viên đang sử dụng</div></div>
    <div class="sstat reveal reveal-delay-2"><div class="sstat-num">99.9%</div><div class="sstat-lbl">Uptime đảm bảo</div></div>
    <div class="sstat reveal reveal-delay-3"><div class="sstat-num">24/7</div><div class="sstat-lbl">Hỗ trợ kỹ thuật</div></div>
</div>

{{-- FEATURES --}}
<section class="section" id="features">
    <div class="reveal"><div class="s-eyebrow">Tính năng nổi bật</div></div>
    <div class="reveal reveal-delay-1"><div class="s-title">Phát triển mọi đội nhóm<br>với một không gian</div></div>
    <div class="reveal reveal-delay-2"><div class="s-sub">Tất cả công cụ bạn cần để quản lý nhân sự hiệu quả — trong một nền tảng duy nhất, dễ dùng và mạnh mẽ.</div></div>
    <div class="features-grid">
        <div class="fcard2 reveal reveal-delay-1">
            <div class="fcard2-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div class="fcard2-title">Quản lý nhân viên</div>
            <div class="fcard2-desc">Hồ sơ đầy đủ, hợp đồng lao động, phân phòng ban và lịch sử công việc chi tiết.</div>
        </div>
        <div class="fcard2 reveal reveal-delay-2">
            <div class="fcard2-icon"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
            <div class="fcard2-title">Chấm công & Nghỉ phép</div>
            <div class="fcard2-desc">Theo dõi giờ làm việc, tăng ca, nghỉ phép và báo cáo chính xác theo thời gian thực.</div>
        </div>
        <div class="fcard2 reveal reveal-delay-3">
            <div class="fcard2-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
            <div class="fcard2-title">Tính lương tự động</div>
            <div class="fcard2-desc">Tính lương, thưởng, phụ cấp và khấu trừ tự động. Xuất phiếu lương PDF chuyên nghiệp.</div>
        </div>
        <div class="fcard2 reveal reveal-delay-1">
            <div class="fcard2-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <div class="fcard2-title">Phân quyền vai trò</div>
            <div class="fcard2-desc">Kiểm soát truy cập chặt chẽ theo vai trò Admin, HR, Trưởng phòng và Nhân viên.</div>
        </div>
        <div class="fcard2 reveal reveal-delay-2">
            <div class="fcard2-icon"><svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
            <div class="fcard2-title">Báo cáo & Thống kê</div>
            <div class="fcard2-desc">Dashboard trực quan, báo cáo chi tiết theo phòng ban, thời gian và hiệu suất nhân sự.</div>
        </div>
        <div class="fcard2 reveal reveal-delay-3">
            <div class="fcard2-icon"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div>
            <div class="fcard2-title">Thông báo tự động</div>
            <div class="fcard2-desc">Nhắc sinh nhật, hợp đồng hết hạn và sự kiện quan trọng được gửi tự động.</div>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section class="section section-alt" id="how">
    <div class="reveal"><div class="s-eyebrow">Cách hoạt động</div></div>
    <div class="reveal reveal-delay-1"><div class="s-title">Bắt đầu chỉ trong<br>3 bước đơn giản</div></div>
    <div class="steps-grid" style="margin-top:3rem">
        <div class="step reveal reveal-delay-1">
            <div class="step-num">1</div>
            <div class="step-title">Tạo tài khoản</div>
            <div class="step-desc">Đăng ký tài khoản Admin và thiết lập thông tin doanh nghiệp của bạn chỉ trong vài phút.</div>
        </div>
        <div class="step reveal reveal-delay-2">
            <div class="step-num">2</div>
            <div class="step-title">Thêm nhân viên</div>
            <div class="step-desc">Import danh sách hoặc thêm từng nhân viên với hồ sơ, hợp đồng và thông tin đầy đủ.</div>
        </div>
        <div class="step reveal reveal-delay-3">
            <div class="step-num">3</div>
            <div class="step-title">Quản lý & Báo cáo</div>
            <div class="step-desc">Theo dõi chấm công, tính lương và xem báo cáo tổng hợp ngay trên dashboard.</div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section" id="cta">
    <div class="cta-inner">
        <div class="reveal"><div class="cta-badge">Miễn phí · Không cần thẻ tín dụng</div></div>
        <div class="reveal reveal-delay-1"><div class="cta-title">Sẵn sàng đưa nhân sự<br>lên tầm cao mới?</div></div>
        <div class="reveal reveal-delay-2"><div class="cta-sub">Hàng trăm doanh nghiệp đã tin dùng NovaHRM.<br>Đến lượt bạn trải nghiệm sự khác biệt.</div></div>
        <div class="cta-btns reveal reveal-delay-3">
            <a href="{{ route('filament.admin.auth.register') }}" class="btn-cta-white">Bắt đầu miễn phí</a>
            <a href="{{ route('filament.admin.auth.login') }}" class="btn-cta-outline">Đăng nhập</a>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer>
    <div class="footer-logo">Nova<span>HRM</span></div>
    <div class="footer-links">
        <a href="#">Điều khoản</a>
        <a href="#">Bảo mật</a>
        <a href="#">Hỗ trợ</a>
    </div>
    <p>© {{ date('Y') }} NovaHRM. All rights reserved.</p>
</footer>

<script>
    // Navbar shadow on scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    });

    // Scroll reveal
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));
</script>
</body>
</html>