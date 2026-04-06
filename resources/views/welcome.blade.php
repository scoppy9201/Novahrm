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
            --dark-bg: #0b1120;
            --dark-card: #111827;
            --dark-border: rgba(255,255,255,0.07);
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Be Vietnam Pro', sans-serif; color: var(--text); background: var(--white); overflow-x: hidden; }

        /* SCROLL REVEAL */
        .reveal { opacity: 0; transform: translateY(36px); transition: opacity .7s cubic-bezier(.22,1,.36,1), transform .7s cubic-bezier(.22,1,.36,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: .1s; }
        .reveal-delay-2 { transition-delay: .2s; }
        .reveal-delay-3 { transition-delay: .3s; }
        .reveal-delay-4 { transition-delay: .4s; }
        .reveal-delay-5 { transition-delay: .5s; }

        /* TOPBAR */
        .topbar { background: #EFF6FF; border-bottom: 1px solid #BFDBFE; padding: 7px 2.5rem; display: flex; align-items: center; justify-content: space-between; font-size: 12px; color: var(--gray-500); }
        .topbar-left { display: flex; align-items: center; gap: 8px; }
        .dot-live { width: 7px; height: 7px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 3px rgba(34,197,94,0.18); animation: pulse-dot 2s infinite; }
        @keyframes pulse-dot { 0%,100% { box-shadow: 0 0 0 3px rgba(34,197,94,0.18); } 50% { box-shadow: 0 0 0 6px rgba(34,197,94,0.07); } }
        .topbar-right { display: flex; align-items: center; gap: 1.5rem; }
        .topbar-right a { color: var(--gray-500); text-decoration: none; transition: color .2s; font-size: 12px; }
        .topbar-right a:hover { color: var(--blue); }
        .tdiv { width: 1px; height: 12px; background: var(--gray-200); }

        /* NAVBAR */
        .navbar { position: sticky; top: 0; z-index: 200; background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-bottom: 1px solid var(--gray-200); padding: 0 2.5rem; display: flex; align-items: center; justify-content: space-between; height: 68px; transition: box-shadow .3s; }
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

        /* HERO */
        .hero { position: relative; min-height: 92vh; display: flex; align-items: center; overflow: hidden; }
        .hero-bg { position: absolute; inset: 0; background: url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1800&q=80') center/cover no-repeat; filter: brightness(0.25); z-index: 0; transform: scale(1.05); animation: slow-zoom 20s ease-in-out infinite alternate; }
        @keyframes slow-zoom { from { transform: scale(1.05); } to { transform: scale(1.12); } }
        .hero-gradient { position: absolute; inset: 0; background: linear-gradient(105deg, rgba(13,71,161,0.82) 0%, rgba(21,101,192,0.45) 50%, rgba(0,0,0,0.1) 100%); z-index: 1; }
        .hero-content { position: relative; z-index: 3; padding: 0 2.5rem; max-width: 720px; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 10px; font-size: 11px; font-weight: 600; letter-spacing: 2.5px; text-transform: uppercase; color: #93C5FD; margin-bottom: 1.5rem; animation: fadeUp .6s .1s ease both; }
        .hero-eyebrow::before { content: ''; display: block; width: 28px; height: 2px; background: linear-gradient(90deg, #60A5FA, transparent); border-radius: 2px; }
        .hero-title { font-size: clamp(36px, 5.5vw, 60px); font-weight: 800; color: #fff; line-height: 1.1; margin-bottom: 1.4rem; letter-spacing: -1.5px; animation: fadeUp .6s .18s ease both; }
        .hero-title em { color: #60A5FA; font-style: normal; }
        .hero-desc { font-size: 16.5px; color: #BFDBFE; line-height: 1.8; margin-bottom: 2.5rem; max-width: 520px; animation: fadeUp .6s .26s ease both; }
        .hero-btns { display: flex; gap: 14px; flex-wrap: wrap; animation: fadeUp .6s .34s ease both; }
        .btn-hero-fill { padding: 15px 32px; background: var(--blue); color: #fff; border: none; border-radius: 100px; font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none; transition: background .2s, transform .15s, box-shadow .2s; font-family: inherit; box-shadow: 0 4px 20px rgba(21,101,192,0.4); }
        .btn-hero-fill:hover { background: var(--blue-dark); transform: translateY(-2px); box-shadow: 0 8px 28px rgba(21,101,192,0.5); }
        .btn-hero-border { padding: 14px 32px; background: rgba(255,255,255,0.08); color: #fff; border: 1.5px solid rgba(255,255,255,0.35); border-radius: 100px; font-size: 15px; font-weight: 500; cursor: pointer; text-decoration: none; transition: all .2s; font-family: inherit; backdrop-filter: blur(8px); }
        .btn-hero-border:hover { background: rgba(255,255,255,0.16); border-color: rgba(255,255,255,0.6); transform: translateY(-1px); }

        /* HERO CARDS */
        .hero-cards { position: absolute; right: 4rem; top: 50%; transform: translateY(-50%); z-index: 3; display: flex; flex-direction: column; gap: 14px; animation: fadeLeft .7s .4s ease both; }
        @keyframes fadeLeft { from { opacity:0; transform: translateX(30px) translateY(-50%); } to { opacity:1; transform: translateX(0) translateY(-50%); } }
        .fcard { background: rgba(255,255,255,0.09); backdrop-filter: blur(24px); border: 1px solid rgba(255,255,255,0.16); border-radius: 18px; padding: 16px 22px; min-width: 220px; transition: transform .3s, background .3s; }
        .fcard:hover { transform: translateY(-3px); background: rgba(255,255,255,0.14); }
        .fcard-label { font-size: 11px; color: #93C5FD; margin-bottom: 6px; font-weight: 500; }
        .fcard-val { font-size: 24px; font-weight: 800; color: #fff; line-height: 1; letter-spacing: -0.5px; }
        .fcard-tag { display: inline-flex; align-items: center; gap: 4px; margin-top: 8px; background: rgba(96,165,250,0.18); color: #93C5FD; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
        .fcard-tag::before { content: '↑'; font-size: 10px; }

        .scroll-down { position: absolute; bottom: 2.5rem; left: 50%; transform: translateX(-50%); z-index: 3; display: flex; flex-direction: column; align-items: center; gap: 8px; color: rgba(255,255,255,0.3); font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; animation: fadeUp 1s .8s ease both; }
        .scroll-mouse { width: 22px; height: 34px; border: 1.5px solid rgba(255,255,255,0.25); border-radius: 12px; display: flex; justify-content: center; padding-top: 6px; }
        .scroll-wheel { width: 3px; height: 6px; background: rgba(255,255,255,0.4); border-radius: 2px; animation: scroll-anim 1.8s infinite; }
        @keyframes scroll-anim { 0%{opacity:1;transform:translateY(0)} 80%{opacity:0;transform:translateY(10px)} 100%{opacity:0} }

        /* STATS */
        .stats-strip { background: var(--blue); padding: 3rem 2.5rem; display: flex; justify-content: center; gap: 0; flex-wrap: wrap; }
        .sstat { text-align: center; padding: 0 4rem; position: relative; }
        .sstat:not(:last-child)::after { content:''; position:absolute; right:0; top:50%; transform:translateY(-50%); height:40px; width:1px; background:rgba(255,255,255,0.15); }
        .sstat-num { font-size: 36px; font-weight: 800; color: #fff; letter-spacing: -1px; }
        .sstat-lbl { font-size: 13px; color: #93C5FD; margin-top: 4px; font-weight: 500; }

        /* SECTION */
        .section { padding: 6rem 2.5rem; }
        .section-alt { background: var(--gray-50); }
        .s-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--blue); margin-bottom: 0.75rem; }
        .s-title { font-size: clamp(28px, 3.5vw, 42px); font-weight: 800; color: var(--text); line-height: 1.15; max-width: 500px; margin-bottom: 0.5rem; letter-spacing: -1px; }
        .s-sub { font-size: 15px; color: var(--gray-500); line-height: 1.75; max-width: 480px; margin-bottom: 3.5rem; }

        /* FEATURES — căn giữa, 2 cột */
        #features { text-align: center; }
        #features .s-title,
        #features .s-sub { margin-left: auto; margin-right: auto; }
        .features-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 420px)); gap: 20px; justify-content: center; max-width: 900px; margin: 0 auto; }
        .fcard2 { background: var(--white); border: 1px solid var(--gray-200); border-radius: 20px; padding: 2.2rem; transition: box-shadow .3s, transform .3s, border-color .3s; position: relative; overflow: hidden; text-align: left; }
        .fcard2::before { content:''; position:absolute; inset:0; background: linear-gradient(135deg, rgba(21,101,192,0.03) 0%, transparent 60%); opacity:0; transition: opacity .3s; }
        .fcard2:hover { box-shadow: 0 16px 48px rgba(21,101,192,0.12); transform: translateY(-4px); border-color: #BFDBFE; }
        .fcard2:hover::before { opacity: 1; }
        .fcard2-icon { width: 52px; height: 52px; border-radius: 16px; background: var(--blue-pale); display: flex; align-items: center; justify-content: center; margin-bottom: 1.4rem; transition: background .3s, transform .3s; }
        .fcard2:hover .fcard2-icon { background: #DBEAFE; transform: scale(1.08); }
        .fcard2-icon svg { width: 24px; height: 24px; stroke: var(--blue); fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .fcard2-title { font-size: 15.5px; font-weight: 700; color: var(--text); margin-bottom: 9px; }
        .fcard2-desc { font-size: 13.5px; color: var(--gray-500); line-height: 1.8; }

        /* HOW IT WORKS */
        .hiw-wrap { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
        .hiw-eyebrow { font-size: 11px; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: var(--blue); margin-bottom: 1rem; }
        .hiw-title { font-size: clamp(26px, 3vw, 38px); font-weight: 800; color: var(--text); line-height: 1.15; letter-spacing: -1px; margin-bottom: 1rem; }
        .hiw-sub { font-size: 14.5px; color: var(--gray-500); line-height: 1.8; margin-bottom: 2.5rem; }

        .step-item { display: flex; gap: 1.2rem; align-items: flex-start; padding: 1.2rem 1.4rem; border-radius: 16px; border: 1px solid transparent; transition: all .3s; cursor: default; margin-bottom: 12px; }
        .step-item:hover { background: #fff; border-color: #BFDBFE; box-shadow: 0 8px 32px rgba(21,101,192,0.08); }
        .step-num-circle { width: 36px; height: 36px; min-width: 36px; border-radius: 50%; background: var(--blue); color: #fff; font-size: 14px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(21,101,192,0.3); }
        .step-item:hover .step-num-circle { transform: scale(1.1); box-shadow: 0 6px 18px rgba(21,101,192,0.4); transition: all .3s; }
        .step-text-title { font-size: 15px; font-weight: 700; color: var(--text); margin-bottom: 5px; }
        .step-text-desc { font-size: 13.5px; color: var(--gray-500); line-height: 1.7; }

        /* RIGHT PANEL */
        .hiw-panel { background: #fff; border: 1px solid var(--gray-200); border-radius: 24px; padding: 2rem; box-shadow: 0 20px 60px rgba(21,101,192,0.07); }
        .hiw-panel-header { margin-bottom: 1.5rem; }
        .hiw-panel-label { font-size: 11px; font-weight: 600; color: var(--gray-400); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px; }
        .hiw-panel-val { font-size: 32px; font-weight: 800; color: var(--text); letter-spacing: -1px; line-height: 1; }
        .hiw-panel-badge { display: inline-block; margin-left: 10px; background: #DCFCE7; color: #16a34a; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; vertical-align: middle; }
        .hiw-stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
        .hiw-stat-box { background: var(--gray-50); border-radius: 14px; padding: 1rem 1.1rem; }
        .hiw-stat-label { font-size: 11px; color: var(--gray-400); margin-bottom: 4px; }
        .hiw-stat-val { font-size: 22px; font-weight: 800; color: var(--text); letter-spacing: -0.5px; }
        .hiw-stat-sub { font-size: 11px; color: #22c55e; font-weight: 600; margin-top: 3px; }
        .hiw-ai-box { background: #F0FDF4; border: 1px solid #BBF7D0; border-radius: 14px; padding: 1rem 1.2rem; }
        .hiw-ai-label { font-size: 11px; font-weight: 700; color: #16a34a; margin-bottom: 5px; }
        .hiw-ai-text { font-size: 13px; color: #166534; line-height: 1.6; }

        /* CTA */
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

        /* FOOTER */
        .footer-main { background: var(--dark-bg); padding: 4rem 2.5rem 2rem; }
        .footer-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1.6fr 1fr 1fr 1fr 1fr; gap: 2.5rem; padding-bottom: 3rem; border-bottom: 1px solid var(--dark-border); }
        .footer-brand .f-logo { font-size: 22px; font-weight: 800; color: #60A5FA; letter-spacing: -0.5px; text-decoration: none; display: inline-block; margin-bottom: 1rem; }
        .footer-brand .f-logo span { color: #93C5FD; }
        .footer-brand p { font-size: 13px; color: #64748b; line-height: 1.8; max-width: 220px; margin-bottom: 1.5rem; }
        .footer-socials { display: flex; gap: 8px; }
        .f-social { width: 32px; height: 32px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 12px; font-weight: 700; text-decoration: none; transition: all .2s; }
        .f-social:hover { border-color: #60A5FA; color: #60A5FA; background: rgba(96,165,250,0.1); }
        .footer-col h4 { font-size: 12px; font-weight: 700; color: #e2e8f0; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 1.2rem; }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-col ul li a { font-size: 13px; color: #64748b; text-decoration: none; transition: color .2s; line-height: 1.5; }
        .footer-col ul li a:hover { color: #93C5FD; }
        .footer-bottom { max-width: 1100px; margin: 0 auto; padding-top: 1.8rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .footer-bottom p { font-size: 12px; color: #334155; }
        .footer-bottom-links { display: flex; gap: 1.5rem; flex-wrap: wrap; }
        .footer-bottom-links a { font-size: 12px; color: #334155; text-decoration: none; transition: color .2s; }
        .footer-bottom-links a:hover { color: #60A5FA; }
        .footer-status { display: flex; align-items: center; gap: 6px; font-size: 12px; color: #334155; }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 0 2px rgba(34,197,94,0.2); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 1024px) {
            .hiw-wrap { grid-template-columns: 1fr; gap: 3rem; }
            .footer-grid { grid-template-columns: 1fr 1fr 1fr; }
            .footer-brand { grid-column: 1 / -1; }
        }
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
            .footer-main { padding: 3rem 1.5rem 1.5rem; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
            .footer-brand { grid-column: 1 / -1; }
            .footer-bottom { flex-direction: column; align-items: flex-start; }
            .features-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; }
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
    <div class="hero-content">
        <div class="hero-eyebrow">Hệ thống quản lý nhân sự</div>
        <h1 class="hero-title">
            Nơi các đội nhân sự<br>
            tìm đến để <em>phát triển</em>
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

{{-- HOW IT WORKS — 2 COLUMNS --}}
<section class="section section-alt" id="how">
    <div class="hiw-wrap">

        <!-- LEFT -->
        <div>
            <div class="reveal"><div class="hiw-eyebrow">Quy trình làm việc</div></div>
            <div class="reveal reveal-delay-1">
                <h2 class="hiw-title">Khởi động hệ thống chỉ trong vài giờ,<br>chứ không phải vài tuần.</h2>
            </div>
            <div class="reveal reveal-delay-2">
                <p class="hiw-sub">Lập kế hoạch, thiết lập và vận hành với các bước hướng dẫn rõ ràng giúp mọi nhóm luôn phối hợp nhịp nhàng.</p>
            </div>

            <div class="step-item reveal reveal-delay-2">
                <div class="step-num-circle">1</div>
                <div>
                    <div class="step-text-title">Tạo tài khoản & Cấu hình</div>
                    <div class="step-text-desc">Đăng ký, thiết lập thông tin doanh nghiệp, phòng ban và các chính sách lương thưởng cơ bản.</div>
                </div>
            </div>

            <div class="step-item reveal reveal-delay-3">
                <div class="step-num-circle">2</div>
                <div>
                    <div class="step-text-title">Thêm nhân viên & Phân quyền</div>
                    <div class="step-text-desc">Import danh sách hoặc thêm từng nhân viên, gán vai trò và quyền truy cập phù hợp.</div>
                </div>
            </div>

            <div class="step-item reveal reveal-delay-4">
                <div class="step-num-circle">3</div>
                <div>
                    <div class="step-text-title">Quản lý & Xem báo cáo</div>
                    <div class="step-text-desc">Theo dõi chấm công, tính lương tự động và xem thống kê tổng hợp trên dashboard thời gian thực.</div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="hiw-panel reveal reveal-delay-2">
            <div class="hiw-panel-header">
                <div class="hiw-panel-label">Hiệu suất hệ thống</div>
                <div class="hiw-panel-val">
                    Nhanh hơn 2,4 lần
                    <span class="hiw-panel-badge">30 ngày qua</span>
                </div>
            </div>
            <div class="hiw-stats-row">
                <div class="hiw-stat-box">
                    <div class="hiw-stat-label">Chấm công tự động</div>
                    <div class="hiw-stat-val">98.4%</div>
                    <div class="hiw-stat-sub">↑ Đúng giờ</div>
                </div>
                <div class="hiw-stat-box">
                    <div class="hiw-stat-label">Tỉ lệ xử lý lương</div>
                    <div class="hiw-stat-val">99.1%</div>
                    <div class="hiw-stat-sub">↑ Chính xác</div>
                </div>
                <div class="hiw-stat-box">
                    <div class="hiw-stat-label">Nhân viên đang dùng</div>
                    <div class="hiw-stat-val">50k+</div>
                    <div class="hiw-stat-sub">↑ 12% tháng này</div>
                </div>
                <div class="hiw-stat-box">
                    <div class="hiw-stat-label">Uptime hệ thống</div>
                    <div class="hiw-stat-val">99.9%</div>
                    <div class="hiw-stat-sub">↑ Ổn định</div>
                </div>
            </div>
            <div class="hiw-ai-box">
                <div class="hiw-ai-label">💡 Gợi ý thông minh</div>
                <div class="hiw-ai-text">Hệ thống phát hiện 3 nhân viên sắp hết hạn hợp đồng trong 30 ngày tới. Hãy xem xét gia hạn để tránh gián đoạn.</div>
            </div>
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

{{-- FOOTER — DARK MULTI-COLUMN --}}
<footer class="footer-main">
    <div class="footer-grid">

        <!-- Brand -->
        <div class="footer-brand">
            <a href="/" class="f-logo">Nova<span>HRM</span></a>
            <p>Nền tảng quản lý nhân sự hiện đại, giúp doanh nghiệp Việt vận hành hiệu quả và chuyên nghiệp hơn.</p>
            <div class="footer-socials">
                <a href="#" class="f-social">f</a>
                <a href="#" class="f-social">in</a>
                <a href="#" class="f-social">yt</a>
                <a href="#" class="f-social">x</a>
            </div>
        </div>

        <!-- Col 1 -->
        <div class="footer-col">
            <h4>Tính năng</h4>
            <ul>
                <li><a href="#">Quản lý nhân viên</a></li>
                <li><a href="#">Chấm công & Ca làm</a></li>
                <li><a href="#">Tính lương tự động</a></li>
                <li><a href="#">Báo cáo & Thống kê</a></li>
                <li><a href="#">Phân quyền vai trò</a></li>
                <li><a href="#">Thông báo tự động</a></li>
            </ul>
        </div>

        <!-- Col 2 -->
        <div class="footer-col">
            <h4>Công cụ</h4>
            <ul>
                <li><a href="#">Import nhân viên</a></li>
                <li><a href="#">Xuất phiếu lương PDF</a></li>
                <li><a href="#">Dashboard quản trị</a></li>
                <li><a href="#">Lịch nghỉ phép</a></li>
                <li><a href="#">Hợp đồng lao động</a></li>
            </ul>
        </div>

        <!-- Col 3 -->
        <div class="footer-col">
            <h4>Công ty</h4>
            <ul>
                <li><a href="#">Về chúng tôi</a></li>
                <li><a href="#">Đội ngũ phát triển</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Tuyển dụng</a></li>
            </ul>
        </div>

        <!-- Col 4 -->
        <div class="footer-col">
            <h4>Hỗ trợ</h4>
            <ul>
                <li><a href="#">Trung tâm hỗ trợ</a></li>
                <li><a href="#">Tài liệu hướng dẫn</a></li>
                <li><a href="#">Hỗ trợ kỹ thuật</a></li>
                <li><a href="#">Cộng đồng người dùng</a></li>
                <li><a href="#">Báo lỗi</a></li>
            </ul>
        </div>

    </div>

    <!-- Bottom bar -->
    <div class="footer-bottom">
        <p>© {{ date('Y') }} NovaHRM. All rights reserved.</p>
        <div class="footer-status">
            <span class="status-dot"></span>
            Tất cả hệ thống hoạt động bình thường
        </div>
        <div class="footer-bottom-links">
            <a href="#">Điều khoản sử dụng</a>
            <a href="#">Chính sách bảo mật</a>
            <a href="#">Bảo vệ dữ liệu</a>
            <a href="#">Quản lý cookie</a>
        </div>
    </div>
</footer>

<script>
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    });

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