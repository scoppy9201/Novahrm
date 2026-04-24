<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NovaHRM - Hệ thống quản lý nhân sự</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:300,400,500,600,700,800,900" rel="stylesheet" />
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --blue: #1565C0;
            --blue-dark: #0d47a1;
            --blue-light: #1976D2;
            --blue-bright: #2196F3;
            --blue-pale: #EFF6FF;
            --blue-glow: rgba(21,101,192,0.5);
            --accent: #60A5FA;
            --accent-dim: #93C5FD;
            --dark-bg: #070d1a;
            --dark-1: #0b1220;
            --dark-2: #0f1829;
            --dark-card: rgba(255,255,255,0.04);
            --dark-border: rgba(255,255,255,0.08);
            --dark-border-hover: rgba(96,165,250,0.3);
            --text-bright: #f0f6ff;
            --text-mid: #8da4be;
            --text-dim: #4a6080;
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: var(--dark-bg);
            color: var(--text-bright);
            overflow-x: hidden;
        }

        /* ── NOISE TEXTURE OVERLAY ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            height: 64px;
            background: rgba(7, 13, 26, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--dark-border);
            transition: all 0.3s;
        }
        .navbar.scrolled {
            background: rgba(7, 13, 26, 0.97);
            box-shadow: 0 4px 40px rgba(0,0,0,0.4);
        }

        .logo {
            font-size: 20px;
            font-weight: 900;
            color: var(--accent);
            text-decoration: none;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo-icon {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, var(--blue), var(--accent));
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-icon svg { width: 16px; height: 16px; fill: white; }
        .logo span { color: #fff; }

        .nav-center {
            display: flex;
            align-items: center;
            gap: 0.2rem;
        }
        .nav-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 14px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-mid);
            text-decoration: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            border: none;
            font-family: inherit;
        }
        .nav-item:hover { color: var(--text-bright); background: rgba(255,255,255,0.05); }
        .nav-item svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; transition: transform 0.2s; }
        .nav-item:hover svg { transform: rotate(180deg); }

        /* Dropdown */
        .nav-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            min-width: 220px;
            background: var(--dark-2);
            border: 1px solid var(--dark-border);
            border-radius: 14px;
            padding: 8px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            opacity: 0;
            pointer-events: none;
            transform: translateY(-8px);
            transition: all 0.2s;
        }
        .nav-item:hover .nav-dropdown,
        .nav-item:focus-within .nav-dropdown {
            opacity: 1;
            pointer-events: all;
            transform: translateY(0);
        }
        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            font-size: 13px;
            color: var(--text-mid);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s;
        }
        .dropdown-link:hover { background: rgba(255,255,255,0.05); color: var(--text-bright); }
        .dropdown-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--blue-bright); flex-shrink: 0; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-login {
            padding: 8px 18px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-mid);
            background: none;
            border: 1px solid var(--dark-border);
            border-radius: 100px;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.2s;
        }
        .btn-login:hover { color: var(--text-bright); border-color: rgba(255,255,255,0.2); }
        .btn-demo {
            padding: 9px 22px;
            font-size: 13.5px;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), var(--blue-bright));
            border: none;
            border-radius: 100px;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.2s;
            box-shadow: 0 4px 20px rgba(21,101,192,0.4);
        }
        .btn-demo:hover { transform: translateY(-1px); box-shadow: 0 8px 28px rgba(21,101,192,0.5); }

        /* ── HERO ── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 120px 2.5rem 100px;
            text-align: center;
            overflow: visible;
        }

        /* Background glow effects */
        .hero-glow-1 {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 900px;
            height: 600px;
            background: radial-gradient(ellipse at center, rgba(21,101,192,0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute;
            top: 20%;
            left: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(ellipse at center, rgba(96,165,250,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-glow-3 {
            position: absolute;
            top: 20%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(ellipse at center, rgba(21,101,192,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 680px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(96,165,250,0.1);
            border: 1px solid rgba(96,165,250,0.25);
            color: var(--accent);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 100px;
            margin-bottom: 1.8rem;
            animation: fadeUp 0.6s 0.1s ease both;
        }
        .hero-badge-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%,100% { box-shadow: 0 0 6px var(--accent); }
            50% { box-shadow: 0 0 14px var(--accent); }
        }

        .hero-title {
            font-size: clamp(30px, 4vw, 52px);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -2px;
            margin-bottom: 1.2rem;
            animation: fadeUp 0.6s 0.18s ease both;
        }
        .hero-title .line-white { color: #fff; display: block; }
        .hero-title .line-blue {
            color: var(--accent);
            display: block;
            background: linear-gradient(90deg, #60A5FA, #93C5FD, #1976D2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 15px;
            color: var(--text-mid);
            line-height: 1.8;
            max-width: 460px;
            margin: 0 auto 2rem;
            animation: fadeUp 0.6s 0.26s ease both;
        }

        .hero-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
            animation: fadeUp 0.6s 0.34s ease both;
            margin-bottom: 4rem;
        }
        .btn-hero-fill {
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--blue), var(--blue-bright));
            color: #fff;
            border: none;
            border-radius: 100px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            box-shadow: 0 6px 28px rgba(21,101,192,0.45);
            transition: all 0.2s;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-hero-fill:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(21,101,192,0.55); }
        .btn-hero-fill svg { width: 16px; height: 16px; fill: none; stroke: white; stroke-width: 2; }
        .btn-hero-ghost {
            padding: 13px 28px;
            background: rgba(255,255,255,0.05);
            color: var(--text-bright);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 100px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.2s;
            backdrop-filter: blur(10px);
        }
        .btn-hero-ghost:hover { background: rgba(255,255,255,0.09); border-color: rgba(255,255,255,0.2); }

        /* Dashboard Preview */
        .hero-preview {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1160px;
            margin: 0 auto;
            animation: fadeUp 0.8s 0.5s ease both;
            padding-bottom: 0.5rem;
        }
        .preview-frame {
            background: var(--dark-1);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            overflow: visible; 
            box-shadow:
                0 0 0 1px rgba(96,165,250,0.1),
                0 40px 100px rgba(0,0,0,0.6),
                0 0 80px rgba(21,101,192,0.15);
            position: relative;
        }
        .preview-clip {
            border-radius: 20px;
            overflow: hidden;
        }
        .preview-frame::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(96,165,250,0.4), transparent);
        }
        .preview-bar {
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .preview-dots { display: flex; gap: 6px; }
        .preview-dot {
            width: 10px; height: 10px; border-radius: 50%;
        }
        .preview-dot:nth-child(1) { background: #ff5f57; }
        .preview-dot:nth-child(2) { background: #febc2e; }
        .preview-dot:nth-child(3) { background: #28c840; }
        .preview-url {
            flex: 1;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 6px;
            padding: 5px 14px;
            font-size: 11px;
            color: var(--text-dim);
            text-align: center;
            max-width: 300px;
            margin: 0 auto;
        }

        /* Dashboard content inside preview */
        .dashboard-inner {
            display: grid;
            grid-template-columns: 180px 1fr;
            min-height: 440px;
            overflow: visible;
        }
        .dash-sidebar {
            background: rgba(0,0,0,0.2);
            border-right: 1px solid rgba(255,255,255,0.05);
            padding: 1.2rem 0;
        }
        .dash-sidebar-logo {
            padding: 0 1.2rem 1rem;
            font-size: 14px;
            font-weight: 800;
            color: var(--accent);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 0.8rem;
        }
        .dash-nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 1.2rem;
            font-size: 11.5px;
            color: var(--text-dim);
            cursor: default;
        }
        .dash-nav-item.active {
            background: rgba(21,101,192,0.2);
            color: var(--accent);
            border-right: 2px solid var(--accent);
        }
        .dash-nav-dot {
            width: 5px; height: 5px; border-radius: 50%;
            background: currentColor; flex-shrink: 0;
        }

        .dash-main {
            padding: 1.8rem 2rem;
            overflow: visible;
        }
        .dash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.2rem;
        }
        .dash-title { font-size: 14px; font-weight: 700; color: var(--text-bright); }
        .dash-date { font-size: 11px; color: var(--text-dim); }
        .dash-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 14px;
            overflow: visible;
        }
        .dash-stat {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 14px 16px;
            position: relative;
        }
        .dash-stat-label { font-size: 9px; color: var(--text-dim); margin-bottom: 4px; }
        .dash-stat-val { font-size: 18px; font-weight: 800; color: var(--text-bright); }
        .dash-stat-tag { font-size: 9px; color: #22c55e; margin-top: 2px; }

        .dash-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            overflow: visible;
        }
        .dash-card {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 16px;
            position: relative;
        }
        .dash-card-title { font-size: 10px; font-weight: 600; color: var(--text-mid); margin-bottom: 10px; }

        /* Mini bar chart */
        .mini-chart {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 72px;
        }
        .mini-bar {
            flex: 1;
            background: linear-gradient(180deg, var(--blue-bright), var(--blue));
            border-radius: 3px 3px 0 0;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        .mini-bar:nth-child(3) { opacity: 1; }

        /* Mini table */
        .mini-table { display: flex; flex-direction: column; gap: 6px; }
        .mini-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 10px;
        }
        .mini-row-name { color: var(--text-mid); }
        .mini-row-badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 600;
        }
        .badge-green { background: rgba(34,197,94,0.15); color: #22c55e; }
        .badge-blue { background: rgba(96,165,250,0.15); color: #60A5FA; }
        .badge-orange { background: rgba(251,146,60,0.15); color: #fb923c; }

        /* Floating cards on dashboard */
        .float-card {
            position: absolute;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 14px;
            padding: 14px 18px;
            animation: float 4s ease-in-out infinite;
        }
        .float-card-1 {
            right: -30px;
            top: 20%;
            animation-delay: 0s;
        }
        .float-card-2 {
            left: -40px;
            bottom: 20%;
            animation-delay: -2s;
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .float-val { font-size: 20px; font-weight: 800; color: #fff; }
        .float-label { font-size: 10px; color: var(--text-mid); margin-top: 3px; }
        .float-up { font-size: 10px; color: #22c55e; margin-top: 5px; font-weight: 600; }

        /* ── CLIENTS STRIP ── */
        .clients-strip {
            position: relative;
            z-index: 2;
            padding: 1.5rem 2.5rem;
            border-top: 1px solid var(--dark-border);
            border-bottom: 1px solid var(--dark-border);
        }
        .clients-label {
            text-align: center;
            font-size: 12px;
            color: var(--text-dim);
            font-weight: 500;
            margin-bottom: 2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .clients-label span { color: var(--accent); }
        .clients-logos {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3.5rem;
            flex-wrap: wrap;
            opacity: 0.5;
            filter: grayscale(1) brightness(1.5);
            transition: opacity 0.3s;
        }
        .clients-logos:hover { opacity: 0.7; }
        .client-logo {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-mid);
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 7px;
        }
        .client-logo .cl-dot {
            width: 18px; height: 18px;
            border-radius: 4px;
            background: var(--text-dim);
        }

        /* ── FEATURES ── */
        .section {
            position: relative;
            z-index: 2;
            padding: 6rem 2.5rem;
        }
        .section-inner { max-width: 1100px; margin: 0 auto; }
        .s-eyebrow {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 0.8rem;
        }
        .s-title {
            font-size: clamp(30px, 3.5vw, 46px);
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -1.5px;
            max-width: 540px;
            margin-bottom: 0.8rem;
        }
        .s-sub {
            font-size: 15px;
            color: var(--text-mid);
            line-height: 1.8;
            max-width: 480px;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .fcard {
            background: var(--dark-card);
            border: 1px solid var(--dark-border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        .fcard::before {
            content:'';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(21,101,192,0.06) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .fcard:hover {
            border-color: rgba(96,165,250,0.25);
            box-shadow: 0 20px 60px rgba(21,101,192,0.12);
            transform: translateY(-4px);
        }
        .fcard:hover::before { opacity: 1; }

        .fcard-icon {
            width: 48px; height: 48px;
            background: rgba(21,101,192,0.15);
            border: 1px solid rgba(21,101,192,0.3);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1.2rem;
            transition: all 0.3s;
        }
        .fcard:hover .fcard-icon {
            background: rgba(21,101,192,0.25);
            border-color: rgba(96,165,250,0.4);
        }
        .fcard-icon svg {
            width: 22px; height: 22px;
            stroke: var(--accent);
            fill: none;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .fcard-title { font-size: 15px; font-weight: 700; color: #fff; margin-bottom: 8px; }
        .fcard-desc { font-size: 13.5px; color: var(--text-mid); line-height: 1.75; }

        /* ── HOW IT WORKS ── */
        .hiw-wrap {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }
        .hiw-title {
            font-size: clamp(26px, 3vw, 40px);
            font-weight: 900;
            color: #fff;
            line-height: 1.1;
            letter-spacing: -1px;
            margin-bottom: 0.8rem;
        }
        .hiw-sub { font-size: 14.5px; color: var(--text-mid); line-height: 1.8; margin-bottom: 2rem; }

        .step-item {
            display: flex;
            gap: 1.2rem;
            align-items: flex-start;
            padding: 1rem 1.2rem;
            border-radius: 14px;
            border: 1px solid transparent;
            transition: all 0.3s;
            margin-bottom: 10px;
        }
        .step-item:hover {
            background: rgba(255,255,255,0.03);
            border-color: var(--dark-border);
        }
        .step-num {
            width: 34px; height: 34px; min-width: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--blue-bright));
            color: #fff;
            font-size: 13px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(21,101,192,0.4);
        }
        .step-title { font-size: 14.5px; font-weight: 700; color: #fff; margin-bottom: 4px; }
        .step-desc { font-size: 13px; color: var(--text-mid); line-height: 1.7; }

        /* Right panel */
        .hiw-panel {
            background: var(--dark-1);
            border: 1px solid var(--dark-border);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4), 0 0 60px rgba(21,101,192,0.1);
        }
        .panel-header { margin-bottom: 1.5rem; }
        .panel-label { font-size: 11px; color: var(--text-dim); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px; }
        .panel-val { font-size: 28px; font-weight: 900; color: #fff; letter-spacing: -1px; }
        .panel-badge {
            display: inline-block;
            margin-left: 10px;
            background: rgba(34,197,94,0.15);
            color: #22c55e;
            font-size: 11px; font-weight: 700;
            padding: 3px 10px; border-radius: 20px;
            vertical-align: middle;
        }
        .panel-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
        .panel-stat {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 12px;
            padding: 1rem;
        }
        .panel-stat-label { font-size: 10px; color: var(--text-dim); margin-bottom: 5px; }
        .panel-stat-val { font-size: 22px; font-weight: 800; color: #fff; letter-spacing: -0.5px; }
        .panel-stat-trend { font-size: 10px; color: #22c55e; font-weight: 600; margin-top: 3px; }
        .panel-ai {
            background: rgba(21,101,192,0.1);
            border: 1px solid rgba(21,101,192,0.25);
            border-radius: 12px;
            padding: 1rem 1.2rem;
        }
        .panel-ai-label { font-size: 11px; font-weight: 700; color: var(--accent); margin-bottom: 5px; }
        .panel-ai-text { font-size: 12.5px; color: var(--accent-dim); line-height: 1.6; }

        /* ── CTA ── */
        .cta-section {
            position: relative;
            z-index: 2;
            padding: 7rem 2.5rem;
            text-align: center;
            overflow: hidden;
        }
        .cta-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(21,101,192,0.3) 0%, transparent 70%);
            border-top: 1px solid var(--dark-border);
            border-bottom: 1px solid var(--dark-border);
        }
        .cta-inner { position: relative; z-index: 2; max-width: 700px; margin: 0 auto; }
        .cta-badge {
            display: inline-block;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: var(--accent-dim);
            font-size: 11px; font-weight: 600;
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 5px 18px; border-radius: 100px;
            margin-bottom: 1.5rem;
        }
        .cta-title {
            font-size: clamp(30px, 4.5vw, 52px);
            font-weight: 900;
            color: #fff;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 1rem;
        }
        .cta-sub { font-size: 16px; color: var(--text-mid); margin-bottom: 2.5rem; line-height: 1.7; }
        .cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
        .btn-cta-fill {
            padding: 14px 32px;
            background: linear-gradient(135deg, var(--blue), var(--blue-bright));
            color: #fff;
            border: none;
            border-radius: 100px;
            font-size: 15px; font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            box-shadow: 0 6px 28px rgba(21,101,192,0.45);
            transition: all 0.2s;
        }
        .btn-cta-fill:hover { transform: translateY(-2px); box-shadow: 0 10px 36px rgba(21,101,192,0.55); }
        .btn-cta-ghost {
            padding: 13px 28px;
            background: rgba(255,255,255,0.05);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 100px;
            font-size: 15px; font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.2s;
        }
        .btn-cta-ghost:hover { background: rgba(255,255,255,0.09); }

        /* ── FOOTER ── */
        .footer {
            position: relative;
            z-index: 2;
            background: var(--dark-1);
            border-top: 1px solid var(--dark-border);
            padding: 4rem 2.5rem 2rem;
        }
        .footer-grid {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.8fr 1fr 1fr 1fr 1fr;
            gap: 2.5rem;
            padding-bottom: 3rem;
            border-bottom: 1px solid var(--dark-border);
        }
        .f-brand-logo {
            font-size: 20px; font-weight: 900;
            color: var(--accent);
            text-decoration: none;
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 1rem;
        }
        .f-brand-logo-icon {
            width: 26px; height: 26px;
            background: linear-gradient(135deg, var(--blue), var(--accent));
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
        }
        .f-brand-logo-icon svg { width: 14px; height: 14px; fill: white; }
        .f-brand-logo span { color: #fff; }
        .f-brand-desc { font-size: 13px; color: var(--text-dim); line-height: 1.8; max-width: 230px; margin-bottom: 1.5rem; }
        .f-socials { display: flex; gap: 8px; }
        .f-social {
            width: 32px; height: 32px;
            border-radius: 50%;
            border: 1px solid var(--dark-border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-dim);
            font-size: 11px; font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }
        .f-social:hover { border-color: var(--accent); color: var(--accent); background: rgba(96,165,250,0.08); }
        .footer-col h4 {
            font-size: 11px; font-weight: 700;
            color: var(--text-bright);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1.2rem;
        }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 9px; }
        .footer-col ul li a {
            font-size: 13px;
            color: var(--text-dim);
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-col ul li a:hover { color: var(--accent-dim); }

        .footer-bottom {
            max-width: 1100px;
            margin: 0 auto;
            padding-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-bottom p { font-size: 12px; color: var(--text-dim); }
        .f-status { display: flex; align-items: center; gap: 6px; font-size: 12px; color: var(--text-dim); }
        .f-status-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; box-shadow: 0 0 6px rgba(34,197,94,0.5); }
        .footer-links { display: flex; gap: 1.5rem; }
        .footer-links a { font-size: 12px; color: var(--text-dim); text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: var(--accent-dim); }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .reveal { opacity: 0; transform: translateY(32px); transition: opacity 0.7s cubic-bezier(.22,1,.36,1), transform 0.7s cubic-bezier(.22,1,.36,1); }
        .reveal.visible { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.1s; }
        .reveal-delay-2 { transition-delay: 0.2s; }
        .reveal-delay-3 { transition-delay: 0.3s; }
        .reveal-delay-4 { transition-delay: 0.4s; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hiw-wrap { grid-template-columns: 1fr; gap: 3rem; }
            .footer-grid { grid-template-columns: 1fr 1fr 1fr; }
            .footer-brand { grid-column: 1 / -1; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .nav-center { display: none; }
            .hero { padding: 100px 1.5rem 60px; }
            .section { padding: 4rem 1.5rem; }
            .features-grid { grid-template-columns: 1fr; }
            .dashboard-inner { grid-template-columns: 1fr; }
            .dash-sidebar { display: none; }
            .sstat { padding: 1rem 2rem; }
            .sstat:not(:last-child)::after { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 2rem; }
            .footer-bottom { flex-direction: column; align-items: flex-start; }
            .footer-links { flex-wrap: wrap; gap: 1rem; }
        }

        /* ── DEPTH SPOTLIGHT PRO ── */
        .dash-stat, .dash-card {
            position: relative;
            will-change: transform, filter, opacity;
            transition:
                transform 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                opacity 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                filter 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 0.9s cubic-bezier(0.16, 1, 0.3, 1),
                border-color 0.9s ease,
                background 0.9s ease;
        }

        .dash-stat.dimmed, .dash-card.dimmed {
            opacity: 0.18;
            filter: blur(2px) saturate(0.1) brightness(0.45);
            transform: scale(0.975) translateY(2px);
        }

        .dash-stat.spotlight, .dash-card.spotlight {
            opacity: 1;
            filter: blur(0px) saturate(1.4) brightness(1.15);
            transform: translateY(-10px) scale(1.07);
            border-color: rgba(96,165,250,0.6) !important;
            background: rgba(12, 28, 62, 0.95) !important;
            box-shadow:
                0 2px 0 rgba(96,165,250,0.5),
                0 24px 60px rgba(21,101,192,0.45),
                0 8px 24px rgba(0,0,0,0.4),
                0 0 0 1px rgba(96,165,250,0.25),
                0 0 60px rgba(96,165,250,0.08);
            z-index: 20;
        }

        /* ── MARQUEE ── */
        .marquee-wrapper {
            overflow: hidden;
            mask-image: linear-gradient(90deg, transparent, black 10%, black 90%, transparent);
            -webkit-mask-image: linear-gradient(90deg, transparent, black 10%, black 90%, transparent);
        }
        .marquee-track {
            display: flex;
            align-items: center;
            gap: 5rem;
            width: max-content;
            animation: marquee 50s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }
        @keyframes marquee {
            from { transform: translateX(0); }
            to { transform: translateX(-50%); }
        }
        .marquee-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            font-size: 17px;
            font-weight: 800;
            color: var(--text-mid);
            white-space: nowrap;
            opacity: 0.65;
            filter: grayscale(0.3) brightness(1.3);
            transition: opacity 0.3s, filter 0.3s;
            cursor: default;
            letter-spacing: -0.3px;
        }
        .marquee-logo svg {
            width: 36px;
            height: 36px;
        }
        .marquee-logo:hover {
            opacity: 1;
            filter: grayscale(0) brightness(1.5);
        }
        /* Cards được phép tràn ra ngoài frame */
        .preview-frame {
            overflow: visible !important;
        }
        .dashboard-inner {
            overflow: visible;
        }
        .dash-main {
            overflow: visible;
        }
        .dash-stats {
            overflow: visible;
        }
        .dash-row {
            overflow: visible;
        }

        /* Spotlight card nổi hẳn ra ngoài */
        .dash-stat.spotlight, .dash-card.spotlight {
            opacity: 1;
            filter: blur(0px) saturate(1.4) brightness(1.15);
            transform: translateY(-18px) scale(1.12) translateZ(0);
            border-color: rgba(96,165,250,0.6) !important;
            background: rgba(10, 22, 50, 0.98) !important;
            box-shadow:
                0 2px 0 rgba(96,165,250,0.6),
                0 30px 80px rgba(21,101,192,0.55),
                0 10px 30px rgba(0,0,0,0.5),
                0 0 0 1px rgba(96,165,250,0.3),
                0 0 80px rgba(96,165,250,0.12);
            z-index: 100;
        }

        /* Floating tooltip khi card spotlight */
        .spot-tooltip {
            position: absolute;
            top: -52px;
            left: 50%;
            transform: translateX(-50%) translateY(6px);
            background: rgba(10, 20, 45, 0.97);
            border: 1px solid rgba(96,165,250,0.4);
            border-radius: 10px;
            padding: 7px 13px;
            font-size: 10px;
            font-weight: 600;
            color: var(--accent);
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.4s cubic-bezier(0.34,1.56,0.64,1);
            backdrop-filter: blur(12px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
            z-index: 200;
        }
        .spot-tooltip::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            width: 8px; height: 8px;
            background: rgba(10,20,45,0.97);
            border-right: 1px solid rgba(96,165,250,0.4);
            border-bottom: 1px solid rgba(96,165,250,0.4);
        }
        .dash-stat.spotlight .spot-tooltip,
        .dash-card.spotlight .spot-tooltip {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
        .spot-tooltip {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .spot-tooltip svg {
            stroke: var(--accent);
            flex-shrink: 0;
        }
        .spot-tooltip {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .spot-tooltip svg {
            stroke: var(--accent);
            flex-shrink: 0;
        }

        /* ── FEATURE SLIDER ── */
        .feat-slider {
            position: relative;
            padding: 0 60px;
        }
        .feat-slides {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
        }
        .feat-slide {
            display: none;
            grid-template-columns: 1fr 1.2fr;
            gap: 0;
            border-radius: 20px;
            overflow: hidden;
            min-height: 380px;
            transition: background 0.6s ease;
        }
        .feat-slide.active { display: grid; animation: slideIn 0.5s cubic-bezier(0.16,1,0.3,1) both; }

        /* Màu riêng từng slide */
        .feat-slide:nth-child(1) { background: linear-gradient(135deg, rgba(13,71,161,0.35) 0%, rgba(7,13,26,0.8) 60%); border: 1px solid rgba(33,150,243,0.2); }
        .feat-slide:nth-child(1):hover { background: linear-gradient(135deg, rgba(13,71,161,0.5) 0%, rgba(11,18,32,0.9) 60%); border-color: rgba(33,150,243,0.4); }

        .feat-slide:nth-child(2) { background: linear-gradient(135deg, rgba(6,78,59,0.35) 0%, rgba(7,13,26,0.8) 60%); border: 1px solid rgba(34,197,94,0.2); }
        .feat-slide:nth-child(2):hover { background: linear-gradient(135deg, rgba(6,78,59,0.5) 0%, rgba(11,18,32,0.9) 60%); border-color: rgba(34,197,94,0.4); }

        .feat-slide:nth-child(3) { background: linear-gradient(135deg, rgba(109,40,217,0.3) 0%, rgba(7,13,26,0.8) 60%); border: 1px solid rgba(167,139,250,0.2); }
        .feat-slide:nth-child(3):hover { background: linear-gradient(135deg, rgba(109,40,217,0.45) 0%, rgba(11,18,32,0.9) 60%); border-color: rgba(167,139,250,0.4); }

        .feat-slide:nth-child(4) { background: linear-gradient(135deg, rgba(180,83,9,0.3) 0%, rgba(7,13,26,0.8) 60%); border: 1px solid rgba(251,146,60,0.2); }
        .feat-slide:nth-child(4):hover { background: linear-gradient(135deg, rgba(180,83,9,0.45) 0%, rgba(11,18,32,0.9) 60%); border-color: rgba(251,146,60,0.4); }

        .feat-slide:nth-child(1) .feat-tag { color: #60A5FA; }
        .feat-slide:nth-child(1) .feat-dot-color { background: #60A5FA; }
        .feat-slide:nth-child(2) .feat-tag { color: #22c55e; }
        .feat-slide:nth-child(3) .feat-tag { color: #a78bfa; }
        .feat-slide:nth-child(4) .feat-tag { color: #fb923c; }

        /* Dot active màu theo slide */
        .feat-dot.active[data-idx="0"] { background: #60A5FA; }
        .feat-dot.active[data-idx="1"] { background: #22c55e; }
        .feat-dot.active[data-idx="2"] { background: #a78bfa; }
        .feat-dot.active[data-idx="3"] { background: #fb923c; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .feat-left {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 1rem;
            border-right: 1px solid rgba(255,255,255,0.06);
        }
        .feat-tag {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--accent);
            text-transform: uppercase;
        }
        .feat-title {
            font-size: clamp(18px, 2vw, 24px);
            font-weight: 800;
            color: #fff;
            line-height: 1.3;
            letter-spacing: -0.5px;
        }
        .feat-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .feat-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13.5px;
            color: var(--text-mid);
            line-height: 1.5;
        }
        .feat-list li svg {
            stroke: var(--accent);
            flex-shrink: 0;
        }
        .feat-btns {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 0.5rem;
        }
        .feat-right {
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0,0,0,0.15);
        }
        .feat-preview {
            width: 100%;
            background: var(--dark-1);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .fp-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .fp-row {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            align-items: center;
            padding: 7px 6px;
            border-radius: 8px;
            font-size: 11px;
            color: var(--text-bright);
            transition: background 0.2s;
        }
        .fp-row:hover { background: rgba(255,255,255,0.04); }
        .fp-row-header {
            font-size: 9px;
            font-weight: 700;
            color: var(--text-dim);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .fp-avatar {
            width: 22px; height: 22px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 8px; font-weight: 800; color: #fff;
            flex-shrink: 0;
        }

        /* Arrows */
        .feat-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px; height: 42px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-mid);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }
        .feat-arrow:hover {
            background: rgba(96,165,250,0.1);
            border-color: rgba(96,165,250,0.3);
            color: var(--accent);
        }
        .feat-prev { left: 0; }
        .feat-next { right: 0; }

        /* Dots */
        .feat-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 1.5rem;
        }
        .feat-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            cursor: pointer;
            transition: all 0.3s;
        }
        .feat-dot.active {
            width: 24px;
            border-radius: 4px;
            background: var(--accent);
        }

        .feat-main-title {
            position: relative;
            display: inline-block;
        }
        .feat-divider {
            color: rgba(255,255,255,0.3);
            margin: 0 10px;
            font-weight: 300;
        }
        .feat-glow-text {
            color: var(--accent);
            position: relative;
        }
        .feat-glow-text::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 200%;
            background: radial-gradient(ellipse at center, rgba(96,165,250,0.35) 0%, transparent 70%);
            pointer-events: none;
            animation: glowPulse 3s ease-in-out infinite;
        }
        @keyframes glowPulse {
            0%, 100% { opacity: 0.6; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 1; transform: translate(-50%, -50%) scale(1.15); }
        }

        /* Spotlight theo cursor */
        .feat-main-title .cursor-light {
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s;
        }

        /* ── AI SECTION ── */
        .ai-section {
            position: relative;
            z-index: 2;
            padding: 6rem 2.5rem;
            text-align: center;
            overflow: hidden;
        }

        .ai-section-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 30%, rgba(21,101,192,0.18) 0%, transparent 65%);
            pointer-events: none;
        }

        .ai-hero-title {
            font-size: clamp(20px, 2.5vw, 36px);
            font-weight: 900;
            color: #fff;
            letter-spacing: -2px;
            line-height: 1.1;
            margin-bottom: 1.5rem;
        }
        .ai-hero-title span {
            background: linear-gradient(90deg, #60A5FA, #93C5FD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .ai-hero-title {
            font-size: clamp(20px, 2.5vw, 36px);
            font-weight: 900;
            color: #fff;
            letter-spacing: -1.5px;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            cursor: default;
        }
        .ai-hero-title span {
            background: linear-gradient(90deg, #60A5FA, #93C5FD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .ai-title-divider {
            color: rgba(255,255,255,0.3);
            margin: 0 10px;
            font-weight: 300;
            -webkit-text-fill-color: rgba(255,255,255,0.3);
        }
        .ai-title-cursor-light {
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s;
            opacity: 0;
        }
        .ai-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, rgba(21,101,192,0.3), rgba(96,165,250,0.15));
            border: 1px solid rgba(96,165,250,0.4);
            color: #93C5FD;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 24px;
            border-radius: 100px;
            margin-bottom: 4rem;
            position: relative;
            overflow: hidden;
            cursor: default;
        }
        .ai-badge::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            animation: shimmer 2.5s infinite;
        }
        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 200%; }
        }

        /* Layout 3 cột */
        .ai-layout {
            position: relative;
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 340px 1fr 220px;
            gap: 0;
            align-items: center;
            min-height: 500px;
        }

        /* ── TRÁI: Chat Panel ── */
        .ai-chat-panel {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: left;
            position: relative;
            z-index: 5;
            box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        }
        .ai-chat-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.2rem;
        }
        .ai-chat-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1565C0, #60A5FA);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .ai-chat-greeting {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
        }
        .ai-chat-greeting span { color: #60A5FA; }

        .ai-chat-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
            text-align: left;
            background: none;
            width: 100%;
            font-family: inherit;
            color: inherit;
        }
        .ai-chat-item:hover {
            background: rgba(255,255,255,0.04);
            border-color: rgba(255,255,255,0.08);
        }
        .ai-chat-item.active {
            background: linear-gradient(135deg, rgba(21,101,192,0.4), rgba(33,150,243,0.25));
            border-color: rgba(96,165,250,0.5);
            box-shadow: 0 4px 20px rgba(21,101,192,0.3);
        }
        .ai-chat-item-icon {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: rgba(255,255,255,0.06);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .ai-chat-item.active .ai-chat-item-icon {
            background: rgba(96,165,250,0.2);
        }
        .ai-chat-item-icon svg {
            width: 14px; height: 14px;
            stroke: var(--text-dim);
            fill: none; stroke-width: 2;
            stroke-linecap: round; stroke-linejoin: round;
        }
        .ai-chat-item.active .ai-chat-item-icon svg {
            stroke: #60A5FA;
        }
        .ai-chat-item-text {
            font-size: 12.5px;
            color: var(--text-mid);
            line-height: 1.5;
            font-weight: 500;
        }
        .ai-chat-item.active .ai-chat-item-text {
            color: #e0eeff;
        }

        /* ── GIỮA: Gem + Lines ── */
        .ai-center-col {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
        }
        .ai-gem-wrap {
            position: relative;
            z-index: 4;
        }
        .ai-gem {
            width: 110px; height: 110px;
            background: linear-gradient(135deg, rgba(33,150,243,0.9), rgba(96,165,250,0.7));
            clip-path: polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%);
            display: flex; align-items: center; justify-content: center;
            animation: gemPulse 3s ease-in-out infinite;
            position: relative;
            cursor: default;
        }
        .ai-gem::before {
            content: '';
            position: absolute;
            inset: -8px;
            background: radial-gradient(ellipse, rgba(96,165,250,0.35) 0%, transparent 70%);
            clip-path: polygon(50% 0%, 93% 25%, 93% 75%, 50% 100%, 7% 75%, 7% 25%);
            animation: gemPulse 3s ease-in-out infinite reverse;
        }
        .ai-gem svg {
            width: 44px; height: 44px;
            fill: white;
            filter: drop-shadow(0 0 12px rgba(255,255,255,0.6));
            position: relative; z-index: 2;
        }
        @keyframes gemPulse {
            0%, 100% {
                box-shadow: 0 0 30px rgba(96,165,250,0.4), 0 0 60px rgba(33,150,243,0.2);
                transform: scale(1);
            }
            50% {
                box-shadow: 0 0 50px rgba(96,165,250,0.7), 0 0 100px rgba(33,150,243,0.4);
                transform: scale(1.05);
            }
        }

        /* SVG connector lines */
        .ai-lines-svg {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 2;
        }
        .ai-line-curve {
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            opacity: 0;
            animation: lineAppear 1s ease forwards;
        }
        #line0 { animation-delay: 0.1s; }
        #line1 { animation-delay: 0.2s; }
        #line2 { animation-delay: 0.3s; }
        #line3 { animation-delay: 0.4s; }
        #line4 { animation-delay: 0.5s; }
        #line5 { animation-delay: 0.6s; }
        #line6 { animation-delay: 0.7s; }
        #line7 { animation-delay: 0.8s; }

        @keyframes lineAppear {
            from { opacity: 0; }
            to   { opacity: 0.6; }
        }

        .ai-flow-dot {
            filter: drop-shadow(0 0 4px currentColor);
            opacity: 0.9;
        }
        .ai-line:nth-child(2) { animation-delay: -0.5s; }
        .ai-line:nth-child(3) { animation-delay: -1s; }
        .ai-line:nth-child(4) { animation-delay: -1.5s; }
        .ai-line:nth-child(5) { animation-delay: -2s; }
        .ai-line:nth-child(6) { animation-delay: -2.5s; }
        @keyframes lineDash {
            to { stroke-dashoffset: -60; }
        }

        .ai-chat-avatar {
            width: 40px; height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #1e3a8a, #1d4ed8);
            border: 1px solid rgba(96,165,250,0.4);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 16px rgba(29,78,216,0.4), 0 0 0 1px rgba(96,165,250,0.15);
            position: relative;
            overflow: visible;
        }
        .ai-chat-avatar::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 13px;
            background: linear-gradient(135deg, rgba(96,165,250,0.3), transparent);
            pointer-events: none;
        }
        /* Result card nổi */
        .ai-result-card {
            position: absolute;
            bottom: 60px;
            right: -20px;
            width: 280px;
            background: rgba(10,20,45,0.97);
            border: 1px solid rgba(96,165,250,0.3);
            border-radius: 16px;
            padding: 16px 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5), 0 0 40px rgba(21,101,192,0.2);
            text-align: left;
            z-index: 10;
            opacity: 0;
            transform: translateY(12px);
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
            pointer-events: none;
            backdrop-filter: blur(20px);
        }
        .ai-result-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .ai-result-title {
            font-size: 11px;
            font-weight: 700;
            color: #60A5FA;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        .ai-result-summary {
            font-size: 12px;
            color: var(--text-mid);
            margin-bottom: 10px;
            line-height: 1.5;
        }
        .ai-result-summary strong { color: #e0eeff; }
        .ai-result-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .ai-result-row {
            display: flex;
            align-items: flex-start;
            gap: 7px;
            font-size: 11px;
            color: var(--text-mid);
            line-height: 1.4;
        }
        .ai-result-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 3px;
        }

        /* ── PHẢI: Bot Icons ── */
        .ai-bots-col {
            position: relative;
            height: 500px;
        }
        .ai-bot {
            position: absolute;
            width: 52px; height: 52px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            display: flex; align-items: center; justify-content: center;
            animation: botFloat 4s ease-in-out infinite;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            backdrop-filter: blur(8px);
        }
        .ai-bot:nth-child(1)  { top: 4%;   right: 60px; animation-delay: 0s; }
        .ai-bot:nth-child(2)  { top: 4%;   right: 5px;  animation-delay: -0.4s; }
        .ai-bot:nth-child(3)  { top: 22%;  right: 20px; animation-delay: -0.8s; }
        .ai-bot:nth-child(4)  { top: 40%;  right: 50px; animation-delay: -1.2s; }
        .ai-bot:nth-child(5)  { top: 58%;  right: 10px; animation-delay: -1.6s; }
        .ai-bot:nth-child(6)  { top: 72%;  right: 70px; animation-delay: -2s; }
        .ai-bot:nth-child(7)  { top: 72%;  right: 10px; animation-delay: -2.4s; }
        .ai-bot:nth-child(8)  { top: 88%;  right: 40px; animation-delay: -2.8s; }

        .ai-bot-badge {
            position: absolute;
            bottom: -3px; right: -3px;
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px;
            border: 2px solid var(--dark-bg);
            font-weight: 800;
        }
        .ai-bot svg {
            width: 24px; height: 24px;
        }
        @keyframes botFloat {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-10px); }
        }

        @media (max-width: 900px) {
            .ai-layout {
                grid-template-columns: 1fr;
            }
            .ai-center-col, .ai-bots-col { display: none; }
            .ai-chat-panel { max-width: 400px; margin: 0 auto; }
            .ai-result-card { display: none; }
        }

        /* ── JOURNEY SECTION ── */
        .journey-section {
            position: relative;
            z-index: 2;
            padding: 6rem 2.5rem;
            text-align: center;
            overflow: hidden;
            border-top: 1px solid var(--dark-border);
        }
        .journey-bg {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 50% 0%, rgba(21,101,192,0.15) 0%, transparent 60%);
            pointer-events: none;
        }
        .journey-title {
            font-size: clamp(24px, 3vw, 42px);
            font-weight: 900;
            color: #fff;
            letter-spacing: -1.5px;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            cursor: default;
        }
        .journey-title span {
            background: linear-gradient(90deg, #60A5FA, #93C5FD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .journey-title-light {
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96,165,250,0.15) 0%, transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            transition: opacity 0.3s;
            opacity: 0;
        }
        .journey-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 28px;
            background: linear-gradient(135deg, var(--blue), var(--blue-bright));
            color: #fff;
            border: none;
            border-radius: 100px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            box-shadow: 0 6px 28px rgba(21,101,192,0.45);
            transition: all 0.2s;
            margin-bottom: 3.5rem;
        }
        .journey-cta-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 36px rgba(21,101,192,0.55);
        }

        /* ── TABS ── */
        .journey-tabs {
            display: flex;
            align-items: center;
            gap: 0;
            max-width: 860px;
            margin: 0 auto 0;
            position: relative;
        }
        .journey-tab {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            cursor: pointer;
            padding-bottom: 1rem;
            position: relative;
            background: none;
            border: none;
            font-family: inherit;
            color: var(--text-dim);
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s;
            justify-content: flex-start;
            padding-left: 8px;
        }
        .journey-tab:hover { color: var(--text-mid); }
        .journey-tab.active { color: #fff; }
        .journey-tab-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800;
            flex-shrink: 0;
            transition: all 0.3s;
            background: transparent;
        }
        .journey-tab.active .journey-tab-num {
            background: linear-gradient(135deg, var(--blue), var(--blue-bright));
            border-color: transparent;
            color: #fff;
            box-shadow: 0 4px 14px rgba(21,101,192,0.5);
        }

        /* Progress bar dưới tabs */
        .journey-progress-wrap {
            max-width: 860px;
            margin: 0 auto;
            height: 3px;
            background: rgba(255,255,255,0.07);
            border-radius: 10px;
            margin-bottom: 2rem;
            position: relative;
            overflow: visible;
        }
        .journey-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--blue), #60A5FA);
            border-radius: 10px;
            transition: width 0.5s cubic-bezier(0.16,1,0.3,1);
            position: relative;
        }
        .journey-progress-dot {
            position: absolute;
            right: -5px; top: 50%;
            transform: translateY(-50%);
            width: 10px; height: 10px;
            border-radius: 50%;
            background: #60A5FA;
            box-shadow: 0 0 10px rgba(96,165,250,0.8);
        }

        /* ── CONTENT PANEL ── */
        .journey-panel {
            max-width: 860px;
            margin: 0 auto;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            overflow: hidden;
            min-height: 360px;
            box-shadow: 0 30px 80px rgba(0,0,0,0.4);
        }
        .journey-left {
            padding: 2rem 1.8rem;
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            border-right: 1px solid rgba(255,255,255,0.06);
            min-width: 0;
        }
        .journey-left-icon {
            width: 52px; height: 52px;
            border-radius: 16px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: auto;
        }
        .journey-left-icon svg {
            width: 26px; height: 26px;
            stroke: #60A5FA;
            fill: none; stroke-width: 1.8;
            stroke-linecap: round; stroke-linejoin: round;
        }
        .journey-left-title {
            font-size: 26px;
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.5px;
            text-align: left;
        }
        .journey-left-desc {
            font-size: 13px;
            color: var(--text-dim);
            line-height: 1.7;
            text-align: left;
        }

        /* ── RIGHT: Flow diagram ── */
        .journey-right {
            padding: 2rem;
            background: rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .journey-flow {
            width: 100%;
            position: relative;
        }

        /* Flow nodes */
        .jflow-node {
            position: absolute;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 11px;
            color: var(--text-mid);
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
            opacity: 0;
            transform: translateY(8px);
        }
        .jflow-node.show {
            opacity: 1;
            transform: translateY(0);
        }
        .jflow-node.highlight {
            border-color: rgba(96,165,250,0.5);
            background: rgba(21,101,192,0.2);
            color: #e0eeff;
            box-shadow: 0 4px 20px rgba(21,101,192,0.3);
        }
        .jflow-num {
            width: 20px; height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), #60A5FA);
            color: #fff;
            font-size: 10px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 0 10px rgba(96,165,250,0.5);
        }
        .jflow-node svg {
            width: 13px; height: 13px;
            stroke: #60A5FA;
            fill: none; stroke-width: 2;
            flex-shrink: 0;
        }

        /* SVG connector trong flow */
        .jflow-svg {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            pointer-events: none;
        }
        .jflow-path {
            fill: none;
            stroke: url(#jflowGrad);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-dasharray: 6 3;
            animation: jflowDash 2s linear infinite;
            opacity: 0.7;
        }
        @keyframes jflowDash {
            to { stroke-dashoffset: -36; }
        }
        .jflow-arrow {
            fill: #60A5FA;
            filter: drop-shadow(0 0 4px rgba(96,165,250,0.8));
        }

        /* Slide transition */
        .journey-slide {
            display: none;
        }
        .journey-slide.active {
            display: grid;
            grid-template-columns: 260px 1fr;
            width: 100%;
            animation: journeyIn 0.45s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes journeyIn {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 768px) {
            .journey-panel { grid-template-columns: 1fr; }
            .journey-slide.active { grid-template-columns: 1fr; }
            .journey-right { display: none; }
            .journey-tabs { gap: 0; }
            .journey-tab span { display: none; }
        }

        /* Flow nodes dùng flexbox thay absolute */
        .jflow-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 1.2rem;
            width: 100%;
        }
        .jflow-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 12px;
            color: var(--text-mid);
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
        }
        .jflow-item.show {
            opacity: 1;
            transform: translateX(0);
        }
        .jflow-item.highlight {
            border-color: rgba(96,165,250,0.4);
            background: rgba(21,101,192,0.15);
            color: #e0eeff;
        }
        .jflow-item-num {
            width: 22px; height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), #60A5FA);
            color: #fff;
            font-size: 10px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 0 8px rgba(96,165,250,0.4);
        }
        .jflow-item svg {
            width: 13px; height: 13px;
            stroke: #60A5FA;
            fill: none; stroke-width: 2;
            flex-shrink: 0;
        }
        .jflow-connector {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 16px;
            opacity: 0.4;
        }
        .jflow-connector svg {
            width: 14px; height: 14px;
            stroke: #60A5FA;
            fill: none; stroke-width: 2;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="/" class="logo">
        <div class="logo-icon">
            <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
        </div>
        Nova<span>HRM</span>
    </a>

    <div class="nav-center">
        <div class="nav-item" tabindex="0">
            Sản phẩm
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            <div class="nav-dropdown">
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Quản lý nhân viên</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Chấm công & Ca làm</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Tính lương tự động</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Báo cáo & Thống kê</a>
            </div>
        </div>
        <div class="nav-item" tabindex="0">
            Giải pháp & Giá
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            <div class="nav-dropdown">
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Doanh nghiệp vừa</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Tập đoàn lớn</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Bảng giá</a>
            </div>
        </div>
        <div class="nav-item" tabindex="0">
            Lĩnh vực
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            <div class="nav-dropdown">
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Sản xuất</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Bán lẻ</a>
                <a href="#" class="dropdown-link"><span class="dropdown-dot"></span>Dịch vụ tài chính</a>
            </div>
        </div>
        <a href="#" class="nav-item">Tin tức</a>
        <a href="#" class="nav-item">Khách hàng</a>
        <a href="#" class="nav-item">Về chúng tôi</a>
    </div>

    <div class="nav-right">
        <a href="#" class="btn-login">Đăng nhập</a>
        <a href="#" class="btn-demo">Đăng ký Demo</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>
    <div class="hero-glow-3"></div>

    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            Hệ thống quản lý nhân sự hiện đại
        </div>
        <h1 class="hero-title">
            <span class="line-white">Nền tảng quản trị</span>
            <span class="line-blue">nhân sự toàn diện</span>
        </h1>
        <p class="hero-desc">
            Nhanh chóng nắm bắt thông tin nhân sự dưới góc nhìn đa chiều để đưa ra quyết định chính xác và kịp thời.
        </p>
        <div class="hero-btns">
            <a href="#" class="btn-hero-fill">
                Đăng ký Demo
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="#features" class="btn-hero-ghost">Xem tính năng</a>
        </div>
    </div>

    <!-- Dashboard Preview -->
    <div class="hero-preview">
        <div class="preview-frame">
            <div class="preview-clip"> 
                <div class="preview-bar">
                    <div class="preview-dots">
                        <div class="preview-dot"></div>
                        <div class="preview-dot"></div>
                        <div class="preview-dot"></div>
                    </div>
                    <div class="preview-url">app.novahrm.vn/dashboard</div>
                </div>
            </div>
            <div class="dashboard-inner">
                <!-- Sidebar -->
                <div class="dash-sidebar">
                    <div class="dash-sidebar-logo">NovaHRM</div>
                    <div class="dash-nav-item active"><span class="dash-nav-dot"></span>Dashboard</div>
                    <div class="dash-nav-item"><span class="dash-nav-dot"></span>Nhân viên</div>
                    <div class="dash-nav-item"><span class="dash-nav-dot"></span>Chấm công</div>
                    <div class="dash-nav-item"><span class="dash-nav-dot"></span>Lương thưởng</div>
                    <div class="dash-nav-item"><span class="dash-nav-dot"></span>Nghỉ phép</div>
                    <div class="dash-nav-item"><span class="dash-nav-dot"></span>Báo cáo</div>
                    <div class="dash-nav-item"><span class="dash-nav-dot"></span>Cài đặt</div>
                </div>
                <!-- Main content -->
                <div class="dash-main">
                    <div class="dash-header">
                        <div>
                            <div class="dash-title">Tổng quan nhân sự</div>
                            <div class="dash-date" style="margin-top:2px">Tháng 4, 2026 · Cập nhật vừa xong</div>
                        </div>
                        <div style="display:flex;gap:6px;align-items:center">
                            <div style="width:6px;height:6px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e"></div>
                            <span style="font-size:10px;color:#22c55e;font-weight:600">Live</span>
                        </div>
                    </div>
                    <div class="dash-stats">
                        <div class="dash-stat">
                                <div class="spot-tooltip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    Nhân viên
                                </div>
                            <div class="dash-stat-label">Tổng nhân viên</div>
                            <div class="dash-stat-val">1,248</div>
                            <div style="display:flex;align-items:center;gap:4px;margin-top:5px">
                                <div style="flex:1;height:3px;background:rgba(255,255,255,0.06);border-radius:10px;overflow:hidden">
                                    <div style="width:78%;height:100%;background:linear-gradient(90deg,#1565C0,#60A5FA);border-radius:10px"></div>
                                </div>
                                <span style="font-size:8px;color:#60A5FA">78%</span>
                            </div>
                            <div class="dash-stat-tag">↑ +12 tháng này</div>
                        </div>
                        <div class="dash-stat">
                                <div class="spot-tooltip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Chấm công
                                </div>
                            <div class="dash-stat-label">Đúng giờ hôm nay</div>
                            <div class="dash-stat-val">98.4%</div>
                            <div style="display:flex;align-items:center;gap:4px;margin-top:5px">
                                <div style="flex:1;height:3px;background:rgba(255,255,255,0.06);border-radius:10px;overflow:hidden">
                                    <div style="width:98%;height:100%;background:linear-gradient(90deg,#059669,#22c55e);border-radius:10px"></div>
                                </div>
                                <span style="font-size:8px;color:#22c55e">98%</span>
                            </div>
                            <div class="dash-stat-tag">↑ Đạt mục tiêu</div>
                        </div>
                        <div class="dash-stat">
                                <div class="spot-tooltip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    Nghỉ phép
                                </div>
                            <div class="dash-stat-label">Đang nghỉ phép</div>
                            <div class="dash-stat-val">24</div>
                            <div style="display:flex;align-items:center;gap:4px;margin-top:5px">
                                <div style="flex:1;height:3px;background:rgba(255,255,255,0.06);border-radius:10px;overflow:hidden">
                                    <div style="width:18%;height:100%;background:linear-gradient(90deg,#d97706,#fb923c);border-radius:10px"></div>
                                </div>
                                <span style="font-size:8px;color:#fb923c">18%</span>
                            </div>
                            <div class="dash-stat-tag" style="color:#fb923c">↓ -3 so với hôm qua</div>
                        </div>
                        <div class="dash-stat">
                                <div class="spot-tooltip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    Tính lương
                                </div>
                            <div class="dash-stat-label">Lương tháng này</div>
                            <div class="dash-stat-val">4.2 tỷ</div>
                            <div style="display:flex;align-items:center;gap:4px;margin-top:5px">
                                <div style="flex:1;height:3px;background:rgba(255,255,255,0.06);border-radius:10px;overflow:hidden">
                                    <div style="width:92%;height:100%;background:linear-gradient(90deg,#7c3aed,#a78bfa);border-radius:10px"></div>
                                </div>
                                <span style="font-size:8px;color:#a78bfa">92%</span>
                            </div>
                            <div class="dash-stat-tag">↑ Đã tính xong</div>
                        </div>
                    </div>
                    <div class="dash-row">
                        <div class="dash-card">
                            <div class="spot-tooltip">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                Biểu đồ
                            </div>
                            <div class="dash-card-title">CHẤM CÔNG 7 NGÀY</div>
                            <div class="mini-chart" style="gap:5px;align-items:flex-end;height:56px">
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--text-dim)">65</span>
                                    <div class="mini-bar" style="height:65%;width:100%"></div>
                                    <span style="font-size:7px;color:var(--text-dim)">T2</span>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--text-dim)">80</span>
                                    <div class="mini-bar" style="height:80%;width:100%"></div>
                                    <span style="font-size:7px;color:var(--text-dim)">T3</span>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--text-dim)">70</span>
                                    <div class="mini-bar" style="height:70%;width:100%"></div>
                                    <span style="font-size:7px;color:var(--text-dim)">T4</span>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--text-dim)">90</span>
                                    <div class="mini-bar" style="height:90%;width:100%"></div>
                                    <span style="font-size:7px;color:var(--text-dim)">T5</span>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--text-dim)">85</span>
                                    <div class="mini-bar" style="height:85%;width:100%"></div>
                                    <span style="font-size:7px;color:var(--text-dim)">T6</span>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--accent)">100</span>
                                    <div class="mini-bar" style="height:100%;width:100%;opacity:1;box-shadow:0 0 8px rgba(96,165,250,0.5)"></div>
                                    <span style="font-size:7px;color:var(--accent)">T7</span>
                                </div>
                                <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:1">
                                    <span style="font-size:7px;color:var(--text-dim)">78</span>
                                    <div class="mini-bar" style="height:78%;width:100%"></div>
                                    <span style="font-size:7px;color:var(--text-dim)">CN</span>
                                </div>
                            </div>
                        </div>
                        <div class="dash-card">
                                <div class="spot-tooltip">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Nhân viên
                                </div>
                            <div class="dash-card-title">NHÂN VIÊN GẦN ĐÂY</div>
                            <div class="mini-table">
                                <div class="mini-row">
                                    <div style="display:flex;align-items:center;gap:6px">
                                        <div style="width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,#1565C0,#60A5FA);display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:700;color:#fff;flex-shrink:0">BH</div>
                                        <span class="mini-row-name">Bùi Mạnh Hưng</span>
                                    </div>
                                    <span class="mini-row-badge badge-green">● Đang làm</span>
                                </div>
                                <div class="mini-row">
                                    <div style="display:flex;align-items:center;gap:6px">
                                        <div style="width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,#0d47a1,#1976D2);display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:700;color:#fff;flex-shrink:0">TX</div>
                                        <span class="mini-row-name">Trần Xuân Huyền</span>
                                    </div>
                                    <span class="mini-row-badge badge-blue">● Nghỉ phép</span>
                                </div>
                                <div class="mini-row">
                                    <div style="display:flex;align-items:center;gap:6px">
                                        <div style="width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,#7c3aed,#a78bfa);display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:700;color:#fff;flex-shrink:0">NA</div>
                                        <span class="mini-row-name">Nguyễn Ngọc Anh</span>
                                    </div>
                                    <span class="mini-row-badge badge-orange">● Tăng ca</span>
                                </div>
                                <div class="mini-row">
                                    <div style="display:flex;align-items:center;gap:6px">
                                        <div style="width:20px;height:20px;border-radius:50%;background:linear-gradient(135deg,#065f46,#22c55e);display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:700;color:#fff;flex-shrink:0">BA</div>
                                        <span class="mini-row-name">Bùi Phương Anh</span>
                                    </div>
                                    <span class="mini-row-badge badge-green">● Đang làm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CLIENTS STRIP -->
<div class="clients-strip">
    <div class="clients-label"><span>11,000+</span> doanh nghiệp đã tin dùng NovaHRM</div>
    <div class="marquee-wrapper">
        <div class="marquee-track">
            <!-- Set 1 -->
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1a3a6b"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#60A5FA" font-size="13" font-weight="800">VP</text></svg>
                VPBank
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#7b1a1a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#fca5a5" font-size="11" font-weight="800">JB</text></svg>
                Jollibee
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1a4a2a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#86efac" font-size="11" font-weight="800">NG</text></svg>
                Nagaco
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1e3a5f"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#93c5fd" font-size="14" font-weight="800">AC</text></svg>
                ACB
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#4a1a6b"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#c4b5fd" font-size="11" font-weight="800">VJ</text></svg>
                VietJet Air
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#3a2a0a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#fcd34d" font-size="11" font-weight="800">TH</text></svg>
                ThaiHa Books
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#0a2a4a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#7dd3fc" font-size="11" font-weight="800">MB</text></svg>
                MBBank
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#2a1a4a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#d8b4fe" font-size="11" font-weight="800">VT</text></svg>
                Viettel
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1a3a1a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#6ee7b7" font-size="11" font-weight="800">VN</text></svg>
                Vingroup
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#3a1a0a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#fdba74" font-size="11" font-weight="800">FPT</text></svg>
                FPT Corp
            </div>
            <!-- Set 2 — duplicate để loop liền mạch -->
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1a3a6b"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#60A5FA" font-size="13" font-weight="800">VP</text></svg>
                VPBank
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#7b1a1a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#fca5a5" font-size="11" font-weight="800">JB</text></svg>
                Jollibee
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1a4a2a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#86efac" font-size="11" font-weight="800">NG</text></svg>
                Nagaco
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1e3a5f"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#93c5fd" font-size="14" font-weight="800">AC</text></svg>
                ACB
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#4a1a6b"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#c4b5fd" font-size="11" font-weight="800">VJ</text></svg>
                VietJet Air
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#3a2a0a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#fcd34d" font-size="11" font-weight="800">TH</text></svg>
                ThaiHa Books
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#0a2a4a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#7dd3fc" font-size="11" font-weight="800">MB</text></svg>
                MBBank
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#2a1a4a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#d8b4fe" font-size="11" font-weight="800">VT</text></svg>
                Viettel
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#1a3a1a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#6ee7b7" font-size="11" font-weight="800">VN</text></svg>
                Vingroup
            </div>
            <div class="marquee-logo">
                <svg width="22" height="22" viewBox="0 0 40 40"><rect width="40" height="40" rx="8" fill="#3a1a0a"/><text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle" fill="#fdba74" font-size="11" font-weight="800">FPT</text></svg>
                FPT Corp
            </div>
        </div>
    </div>
</div>

<!-- FEATURES -->
<section class="section" id="features">
    <div class="section-inner">
        <div class="reveal" style="text-align:center;margin-bottom:3.5rem">
            <div class="s-eyebrow" style="justify-content:center;display:flex">Tính năng nổi bật</div>
            <h2 class="s-title feat-main-title" style="max-width:100%;text-align:center;font-size:clamp(28px,3.5vw,44px)">
            Một nền tảng <span class="feat-divider">|</span> <span class="feat-glow-text">Mọi giải pháp</span>
            </h2>
        </div>

        <div class="feat-slider">
            <button class="feat-arrow feat-prev" onclick="featSlide(-1)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="feat-arrow feat-next" onclick="featSlide(1)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div class="feat-slides">

                <!-- Slide 1 -->
                <div class="feat-slide active">
                    <div class="feat-left">
                        <div class="feat-tag">QUẢN LÝ NHÂN SỰ</div>
                        <h3 class="feat-title">Quản trị nhân viên toàn diện, hồ sơ đầy đủ</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                Hồ sơ nhân viên đầy đủ, hợp đồng lao động số
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Phân quyền vai trò Admin, HR, Trưởng phòng
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                Theo dõi lịch sử công việc và hiệu suất
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">Xem chi tiết</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">Demo tính năng</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">Danh sách nhân viên</span>
                                <span style="font-size:10px;color:var(--accent);font-weight:600">1,248 người</span>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:8px;margin-top:10px">
                                <div class="fp-row fp-row-header">
                                    <span>Họ tên</span><span>Phòng ban</span><span>Trạng thái</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#1565C0,#60A5FA)">BH</div>
                                        <span>Bùi Mạnh Hưng</span>
                                    </div>
                                    <span style="color:var(--text-mid)">Kỹ thuật</span>
                                    <span class="mini-row-badge badge-green">Đang làm</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">TX</div>
                                        <span>Trần Xuân Huyền</span>
                                    </div>
                                    <span style="color:var(--text-mid)">Marketing</span>
                                    <span class="mini-row-badge badge-blue">Nghỉ phép</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#065f46,#22c55e)">NA</div>
                                        <span>Nguyễn Ngọc Anh</span>
                                    </div>
                                    <span style="color:var(--text-mid)">Kinh doanh</span>
                                    <span class="mini-row-badge badge-orange">Tăng ca</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#1e3a5f,#2196F3)">PA</div>
                                        <span>Bùi Phương Anh</span>
                                    </div>
                                    <span style="color:var(--text-mid)">Kế toán</span>
                                    <span class="mini-row-badge badge-green">Đang làm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="feat-slide">
                    <div class="feat-left">
                        <div class="feat-tag">CHẤM CÔNG & LỊCH LÀM</div>
                        <h3 class="feat-title">Theo dõi giờ làm chính xác, tăng ca tự động</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                Chấm công qua app, QR code, khuôn mặt
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Quản lý ca làm, lịch trực theo phòng ban
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                Báo cáo tổng hợp theo tuần, tháng, quý
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">Xem chi tiết</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">Demo tính năng</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">Biểu đồ chấm công tuần này</span>
                                <span style="font-size:10px;color:#22c55e;font-weight:600">98.4% đúng giờ</span>
                            </div>
                            <div style="display:flex;align-items:flex-end;gap:8px;height:100px;margin-top:16px">
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:var(--text-dim)">T2</span>
                                    <div style="width:100%;height:65%;background:linear-gradient(180deg,#2196F3,#1565C0);border-radius:4px 4px 0 0"></div>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:var(--text-dim)">T3</span>
                                    <div style="width:100%;height:80%;background:linear-gradient(180deg,#2196F3,#1565C0);border-radius:4px 4px 0 0"></div>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:var(--text-dim)">T4</span>
                                    <div style="width:100%;height:70%;background:linear-gradient(180deg,#2196F3,#1565C0);border-radius:4px 4px 0 0"></div>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:var(--accent)">T5</span>
                                    <div style="width:100%;height:100%;background:linear-gradient(180deg,#60A5FA,#1976D2);border-radius:4px 4px 0 0;box-shadow:0 0 12px rgba(96,165,250,0.4)"></div>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:var(--text-dim)">T6</span>
                                    <div style="width:100%;height:85%;background:linear-gradient(180deg,#2196F3,#1565C0);border-radius:4px 4px 0 0"></div>
                                </div>
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:5px">
                                    <span style="font-size:8px;color:var(--text-dim)">T7</span>
                                    <div style="width:100%;height:50%;background:linear-gradient(180deg,#2196F3,#1565C0);border-radius:4px 4px 0 0;opacity:0.5"></div>
                                </div>
                            </div>
                            <div style="display:flex;gap:10px;margin-top:14px">
                                <div style="flex:1;background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:8px;padding:8px 10px">
                                    <div style="font-size:9px;color:var(--text-dim)">Đúng giờ</div>
                                    <div style="font-size:16px;font-weight:800;color:#22c55e">1,228</div>
                                </div>
                                <div style="flex:1;background:rgba(251,146,60,0.08);border:1px solid rgba(251,146,60,0.2);border-radius:8px;padding:8px 10px">
                                    <div style="font-size:9px;color:var(--text-dim)">Trễ giờ</div>
                                    <div style="font-size:16px;font-weight:800;color:#fb923c">14</div>
                                </div>
                                <div style="flex:1;background:rgba(96,165,250,0.08);border:1px solid rgba(96,165,250,0.2);border-radius:8px;padding:8px 10px">
                                    <div style="font-size:9px;color:var(--text-dim)">Tăng ca</div>
                                    <div style="font-size:16px;font-weight:800;color:var(--accent)">38</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="feat-slide">
                    <div class="feat-left">
                        <div class="feat-tag">TÍNH LƯƠNG TỰ ĐỘNG</div>
                        <h3 class="feat-title">Tính lương chính xác, xuất phiếu lương PDF</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                Tính lương, thưởng, phụ cấp tự động
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Xuất phiếu lương PDF chuyên nghiệp
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                Tự động khấu trừ BHXH, thuế TNCN
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">Xem chi tiết</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">Demo tính năng</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">Bảng lương tháng 4/2026</span>
                                <span style="font-size:10px;color:#22c55e;font-weight:600">✓ Đã duyệt</span>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:7px;margin-top:10px">
                                <div class="fp-row fp-row-header">
                                    <span>Nhân viên</span><span>Lương cơ bản</span><span>Thực lãnh</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#1565C0,#60A5FA)">BH</div>
                                        <span>Bùi Mạnh Hưng</span>
                                    </div>
                                    <span style="color:var(--text-mid)">18,000,000</span>
                                    <span style="color:#22c55e;font-weight:700">21,500,000</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">TX</div>
                                        <span>Trần Xuân Huyền</span>
                                    </div>
                                    <span style="color:var(--text-mid)">15,000,000</span>
                                    <span style="color:#22c55e;font-weight:700">15,000,000</span>
                                </div>
                                <div class="fp-row">
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <div class="fp-avatar" style="background:linear-gradient(135deg,#065f46,#22c55e)">NA</div>
                                        <span>Nguyễn Ngọc Anh</span>
                                    </div>
                                    <span style="color:var(--text-mid)">20,000,000</span>
                                    <span style="color:#22c55e;font-weight:700">26,800,000</span>
                                </div>
                            </div>
                            <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.06);display:flex;justify-content:space-between;align-items:center">
                                <span style="font-size:10px;color:var(--text-dim)">Tổng chi lương tháng này</span>
                                <span style="font-size:16px;font-weight:900;color:#fff">4.2 <span style="color:var(--accent)">tỷ</span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="feat-slide">
                    <div class="feat-left">
                        <div class="feat-tag">BÁO CÁO & THỐNG KÊ</div>
                        <h3 class="feat-title">Dashboard trực quan, báo cáo chi tiết realtime</h3>
                        <ul class="feat-list">
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                                Dashboard tổng hợp theo phòng ban, thời gian
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                Xuất báo cáo Excel, PDF chỉ 1 click
                            </li>
                            <li>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/></svg>
                                Cảnh báo thông minh, nhắc nhở tự động
                            </li>
                        </ul>
                        <div class="feat-btns">
                            <a href="#" class="btn-cta-fill" style="font-size:13px;padding:10px 22px">Xem chi tiết</a>
                            <a href="#" class="btn-cta-ghost" style="font-size:13px;padding:10px 22px">Demo tính năng</a>
                        </div>
                    </div>
                    <div class="feat-right">
                        <div class="feat-preview">
                            <div class="fp-header">
                                <span style="font-size:11px;color:var(--text-dim)">Tổng quan hiệu suất</span>
                                <span style="font-size:10px;color:var(--accent);font-weight:600">Tháng 4/2026</span>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-top:10px">
                                <div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:10px;padding:10px">
                                    <div style="font-size:9px;color:var(--text-dim);margin-bottom:4px">Chấm công đúng giờ</div>
                                    <div style="font-size:20px;font-weight:900;color:#22c55e">98.4%</div>
                                    <div style="height:3px;background:rgba(255,255,255,0.06);border-radius:10px;margin-top:6px;overflow:hidden">
                                        <div style="width:98%;height:100%;background:#22c55e;border-radius:10px"></div>
                                    </div>
                                </div>
                                <div style="background:rgba(96,165,250,0.08);border:1px solid rgba(96,165,250,0.2);border-radius:10px;padding:10px">
                                    <div style="font-size:9px;color:var(--text-dim);margin-bottom:4px">Xử lý lương chính xác</div>
                                    <div style="font-size:20px;font-weight:900;color:var(--accent)">99.1%</div>
                                    <div style="height:3px;background:rgba(255,255,255,0.06);border-radius:10px;margin-top:6px;overflow:hidden">
                                        <div style="width:99%;height:100%;background:var(--accent);border-radius:10px"></div>
                                    </div>
                                </div>
                                <div style="background:rgba(167,139,250,0.08);border:1px solid rgba(167,139,250,0.2);border-radius:10px;padding:10px">
                                    <div style="font-size:9px;color:var(--text-dim);margin-bottom:4px">Nhân viên active</div>
                                    <div style="font-size:20px;font-weight:900;color:#a78bfa">50k+</div>
                                    <div style="height:3px;background:rgba(255,255,255,0.06);border-radius:10px;margin-top:6px;overflow:hidden">
                                        <div style="width:85%;height:100%;background:#a78bfa;border-radius:10px"></div>
                                    </div>
                                </div>
                                <div style="background:rgba(251,146,60,0.08);border:1px solid rgba(251,146,60,0.2);border-radius:10px;padding:10px">
                                    <div style="font-size:9px;color:var(--text-dim);margin-bottom:4px">Uptime hệ thống</div>
                                    <div style="font-size:20px;font-weight:900;color:#fb923c">99.9%</div>
                                    <div style="height:3px;background:rgba(255,255,255,0.06);border-radius:10px;margin-top:6px;overflow:hidden">
                                        <div style="width:99%;height:100%;background:#fb923c;border-radius:10px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Dots -->
            <div class="feat-dots">
                <span class="feat-dot active" data-idx="0" onclick="featGoTo(0)"></span>
                <span class="feat-dot" data-idx="1" onclick="featGoTo(1)"></span>
                <span class="feat-dot" data-idx="2" onclick="featGoTo(2)"></span>
                <span class="feat-dot" data-idx="3" onclick="featGoTo(3)"></span>
            </div>
        </div>
    </div>
</section>

<!-- JOURNEY SECTION -->
<section class="journey-section" id="how">
    <div class="journey-bg"></div>

    <div class="reveal">
        <h2 class="journey-title" id="journeyTitle">
            Đồng hành cùng doanh nghiệp
            <br><span>xuyên suốt</span> lộ trình chuyển đổi số
            <div class="journey-title-light" id="journeyTitleLight"></div>
        </h2>
    </div>

    <div class="reveal reveal-delay-1">
        <a href="#" class="journey-cta-btn">
            Tư vấn triển khai ngay
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>

    <!-- Tabs -->
    <div class="journey-tabs reveal reveal-delay-2">
        <button class="journey-tab active" onclick="journeyGoTo(0)">
            <div class="journey-tab-num">1</div>
            <span>Tư vấn</span>
        </button>
        <button class="journey-tab" onclick="journeyGoTo(1)">
            <div class="journey-tab-num">2</div>
            <span>Số hóa</span>
        </button>
        <button class="journey-tab" onclick="journeyGoTo(2)">
            <div class="journey-tab-num">3</div>
            <span>Tối ưu hóa</span>
        </button>
        <button class="journey-tab" onclick="journeyGoTo(3)">
            <div class="journey-tab-num">4</div>
            <span>Dữ liệu hóa</span>
        </button>
    </div>

    <!-- Progress bar -->
    <div class="journey-progress-wrap reveal reveal-delay-2">
        <div class="journey-progress-bar" id="journeyBar" style="width:25%">
            <div class="journey-progress-dot"></div>
        </div>
    </div>

    <!-- Panel -->
    <div class="journey-panel reveal reveal-delay-3" id="journeyPanel">

        <!-- SLIDE 1: Tư vấn -->
        <div class="journey-slide active" id="jslide-0">
            <div class="journey-left">
                <div class="journey-left-icon">
                    <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="journey-left-title">Tư vấn</div>
                <div class="journey-left-desc">Khảo sát hiện trạng vận hành của doanh nghiệp. Tư vấn, đào tạo, xây dựng quy trình nâng cao khả năng vận hành & thiết kế lộ trình số hóa phù hợp.</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0">
                        <div class="jflow-item-num">1</div>
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Khảo sát nhu cầu doanh nghiệp
                    </div>
                    <div class="jflow-connector">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num">2</div>
                        <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Thiết kế lộ trình & tối ưu quy trình
                    </div>
                    <div class="jflow-connector">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num">3</div>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Hướng dẫn & tư vấn chuyên sâu
                    </div>
                    <div class="jflow-connector">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num">4</div>
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Tổng kết & đánh giá
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 2: Số hóa -->
        <div class="journey-slide" id="jslide-1">
            <div class="journey-left">
                <div class="journey-left-icon">
                    <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div class="journey-left-title">Số hóa</div>
                <div class="journey-left-desc">Triển khai hệ thống NovaHRM, số hóa toàn bộ dữ liệu nhân sự, chấm công, lương thưởng. Đào tạo nhân viên sử dụng thành thạo nền tảng.</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0" style="border-color:rgba(34,197,94,0.4);background:rgba(5,150,105,0.15)">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">1</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span style="color:#e0eeff">Import dữ liệu nhân sự hàng loạt</span>
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">2</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Cấu hình chấm công & ca làm
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">3</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        Đào tạo nhân viên sử dụng
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">4</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="20 6 9 17 4 12"/></svg>
                        Go-live & kiểm tra thực tế
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 3: Tối ưu hóa -->
        <div class="journey-slide" id="jslide-2">
            <div class="journey-left">
                <div class="journey-left-icon">
                    <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                </div>
                <div class="journey-left-title">Tối ưu hóa</div>
                <div class="journey-left-desc">Phân tích dữ liệu vận hành thực tế, tối ưu quy trình nhân sự, tự động hóa các tác vụ lặp lại và nâng cao hiệu suất toàn hệ thống.</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0" style="border-color:rgba(167,139,250,0.4);background:rgba(124,58,237,0.15)">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">1</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <span style="color:#e0eeff">Phân tích báo cáo hiệu suất</span>
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">2</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        Tự động hóa quy trình lặp lại
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">3</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        Tinh chỉnh chính sách lương thưởng
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">4</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="20 6 9 17 4 12"/></svg>
                        Đánh giá & cải tiến liên tục
                    </div>
                </div>
            </div>
        </div>

        <!-- SLIDE 4: Dữ liệu hóa -->
        <div class="journey-slide" id="jslide-3">
            <div class="journey-left">
                <div class="journey-left-icon">
                    <svg viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                </div>
                <div class="journey-left-title">Dữ liệu hóa</div>
                <div class="journey-left-desc">Xây dựng kho dữ liệu nhân sự tập trung, phân tích xu hướng dài hạn và đưa ra dự báo thông minh hỗ trợ ra quyết định chiến lược.</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0" style="border-color:rgba(251,146,60,0.4);background:rgba(194,65,12,0.15)">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">1</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                        <span style="color:#e0eeff">Tập trung hóa kho dữ liệu nhân sự</span>
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">2</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        Phân tích xu hướng dài hạn
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">3</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        Cảnh báo & dự báo thông minh
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">4</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="20 6 9 17 4 12"/></svg>
                        Báo cáo chiến lược cho lãnh đạo
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- AI SECTION -->
<section class="ai-section">
    <div class="ai-section-bg"></div>

    <div class="reveal">
        <h2 class="ai-hero-title" id="aiHeroTitle">
            Thông tin <span>tức thời</span>
            <span class="ai-title-divider">|</span>
            quyết định <span>chính xác</span>
            <div class="ai-title-cursor-light" id="aiTitleLight"></div>
        </h2>
    </div>

    <div class="reveal reveal-delay-1">
        <div class="ai-badge">✦ Nova AI Coming Soon</div>
    </div>

    <div class="ai-layout reveal reveal-delay-2">

        <!-- TRÁI: Chat Panel -->
        <div class="ai-chat-panel">
        <div class="ai-chat-header">
            <div class="ai-chat-avatar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                    <rect x="4" y="9" width="16" height="11" rx="3" fill="url(#avatarGrad)" opacity="0.9"/>
                    <rect x="7" y="4" width="10" height="7" rx="2.5" fill="url(#avatarGrad)"/>
                    <line x1="12" y1="4" x2="12" y2="2" stroke="#93c5fd" stroke-width="1.5" stroke-linecap="round"/>
                    <circle cx="12" cy="1.5" r="1" fill="#60A5FA"/>
                    <circle cx="9.5" cy="7.5" r="1.2" fill="#fff" opacity="0.95"/>
                    <circle cx="9.8" cy="7.5" r="0.5" fill="#1e40af"/>
                    <circle cx="14.5" cy="7.5" r="1.2" fill="#fff" opacity="0.95"/>
                    <circle cx="14.8" cy="7.5" r="0.5" fill="#1e40af"/>
                    <path d="M 9.5 12.5 Q 12 14 14.5 12.5" stroke="#93c5fd" stroke-width="1" fill="none" stroke-linecap="round"/>
                    <rect x="2.5" y="11" width="2" height="4" rx="1" fill="#60A5FA" opacity="0.7"/>
                    <rect x="19.5" y="11" width="2" height="4" rx="1" fill="#60A5FA" opacity="0.7"/>
                    <circle cx="9.5" cy="15" r="1" fill="#22d3ee" opacity="0.8"/>
                    <circle cx="12" cy="15" r="1" fill="#60A5FA" opacity="0.8">
                        <animate attributeName="opacity" values="0.8;0.2;0.8" dur="1.8s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="14.5" cy="15" r="1" fill="#818cf8" opacity="0.8"/>
                    <defs>
                        <linearGradient id="avatarGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#1d4ed8"/>
                            <stop offset="100%" stop-color="#3b82f6"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="ai-chat-greeting">Hey <span>Nova AI</span></div>
        </div>

            <button class="ai-chat-item active" onclick="aiSelect(this, 0)">
                <div class="ai-chat-item-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <span class="ai-chat-item-text">Có đề xuất nào đang cần phê duyệt không?</span>
            </button>

            <button class="ai-chat-item" onclick="aiSelect(this, 1)">
                <div class="ai-chat-item-icon">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/></svg>
                </div>
                <span class="ai-chat-item-text">Tóm tắt công việc của team tôi trong tuần này</span>
            </button>

            <button class="ai-chat-item" onclick="aiSelect(this, 2)">
                <div class="ai-chat-item-icon">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <span class="ai-chat-item-text">Tình hình tài chính của công ty, doanh thu và chi phí có đang đi theo kế hoạch không?</span>
            </button>

            <button class="ai-chat-item" onclick="aiSelect(this, 3)">
                <div class="ai-chat-item-icon">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <span class="ai-chat-item-text">Hôm nay tôi có những cuộc họp nào quan trọng?</span>
            </button>
        </div>

        <!-- GIỮA: Gem + SVG Lines + Result Card -->
        <div class="ai-center-col">
            <!-- SVG Lines -->
            <svg class="ai-lines-svg" viewBox="0 0 500 500" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="lineGrad0" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#60A5FA" stop-opacity="0.9"/>
                        <stop offset="100%" stop-color="#60A5FA" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad1" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#818cf8" stop-opacity="0.8"/>
                        <stop offset="100%" stop-color="#818cf8" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad2" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#34d399" stop-opacity="0.8"/>
                        <stop offset="100%" stop-color="#34d399" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad3" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#60A5FA" stop-opacity="0.7"/>
                        <stop offset="100%" stop-color="#60A5FA" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad4" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#f472b6" stop-opacity="0.7"/>
                        <stop offset="100%" stop-color="#f472b6" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad5" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#fb923c" stop-opacity="0.7"/>
                        <stop offset="100%" stop-color="#fb923c" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad6" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#a78bfa" stop-opacity="0.7"/>
                        <stop offset="100%" stop-color="#a78bfa" stop-opacity="0.05"/>
                    </linearGradient>
                    <linearGradient id="lineGrad7" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#22d3ee" stop-opacity="0.7"/>
                        <stop offset="100%" stop-color="#22d3ee" stop-opacity="0.05"/>
                    </linearGradient>

                    <!-- Filter glow cho lines -->
                    <filter id="lineGlow">
                        <feGaussianBlur stdDeviation="2" result="blur"/>
                        <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                    </filter>
                </defs>

                <!-- 8 curved lines tới 8 bots, mỗi line 1 màu riêng -->
                <!-- Bot 1: top-right cao -->
                <path class="ai-line-curve" id="line0"
                    d="M 250 250 C 320 240, 400 140, 500 60"
                    stroke="url(#lineGrad0)" filter="url(#lineGlow)"/>

                <!-- Bot 2: top-right -->
                <path class="ai-line-curve" id="line1"
                    d="M 250 250 C 330 235, 420 175, 500 110"
                    stroke="url(#lineGrad1)" filter="url(#lineGlow)"/>

                <!-- Bot 3: upper-mid right -->
                <path class="ai-line-curve" id="line2"
                    d="M 250 250 C 340 245, 430 215, 500 185"
                    stroke="url(#lineGrad2)" filter="url(#lineGlow)"/>

                <!-- Bot 4: mid right -->
                <path class="ai-line-curve" id="line3"
                    d="M 250 250 C 350 250, 440 255, 500 260"
                    stroke="url(#lineGrad3)" filter="url(#lineGlow)"/>

                <!-- Bot 5: lower-mid right -->
                <path class="ai-line-curve" id="line4"
                    d="M 250 250 C 340 258, 430 295, 500 330"
                    stroke="url(#lineGrad4)" filter="url(#lineGlow)"/>

                <!-- Bot 6: lower right -->
                <path class="ai-line-curve" id="line5"
                    d="M 250 250 C 330 268, 415 340, 500 390"
                    stroke="url(#lineGrad5)" filter="url(#lineGlow)"/>

                <!-- Bot 7: bottom right -->
                <path class="ai-line-curve" id="line6"
                    d="M 250 250 C 320 275, 410 380, 500 430"
                    stroke="url(#lineGrad6)" filter="url(#lineGlow)"/>

                <!-- Bot 8: bottom-far right -->
                <path class="ai-line-curve" id="line7"
                    d="M 250 250 C 310 290, 400 430, 500 480"
                    stroke="url(#lineGrad7)" filter="url(#lineGlow)"/>

                <!-- Flowing dots chạy trên mỗi line -->
                <circle class="ai-flow-dot" r="3" fill="#60A5FA">
                    <animateMotion dur="2s" repeatCount="indefinite" begin="0s">
                        <mpath href="#line0"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#818cf8">
                    <animateMotion dur="2.3s" repeatCount="indefinite" begin="-0.3s">
                        <mpath href="#line1"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#34d399">
                    <animateMotion dur="2.1s" repeatCount="indefinite" begin="-0.6s">
                        <mpath href="#line2"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#60A5FA">
                    <animateMotion dur="1.9s" repeatCount="indefinite" begin="-0.9s">
                        <mpath href="#line3"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#f472b6">
                    <animateMotion dur="2.4s" repeatCount="indefinite" begin="-1.2s">
                        <mpath href="#line4"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#fb923c">
                    <animateMotion dur="2.2s" repeatCount="indefinite" begin="-1.5s">
                        <mpath href="#line5"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#a78bfa">
                    <animateMotion dur="2.5s" repeatCount="indefinite" begin="-1.8s">
                        <mpath href="#line6"/>
                    </animateMotion>
                </circle>
                <circle class="ai-flow-dot" r="3" fill="#22d3ee">
                    <animateMotion dur="2s" repeatCount="indefinite" begin="-2.1s">
                        <mpath href="#line7"/>
                    </animateMotion>
                </circle>
            </svg>

            <!-- Gem trung tâm -->
            <div class="ai-gem-wrap">
                <div class="ai-gem">
                    <svg viewBox="0 0 24 24" fill="white">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                    </svg>
                </div>
            </div>

            <!-- Result Card nổi -->
            <div class="ai-result-card visible" id="aiResultCard">
                <div class="ai-result-title" id="aiResultTitle">Đề xuất cần phê duyệt</div>
                <div class="ai-result-summary" id="aiResultSummary">
                    Hiện tại bạn có <strong>9 đề xuất</strong> cần phê duyệt:
                </div>
                <div class="ai-result-list" id="aiResultList">
                    <div class="ai-result-row">
                        <div class="ai-result-dot" style="background:#f59e0b"></div>
                        <span><strong style="color:#fbbf24">3 đề xuất</strong> được gắn dấu sao</span>
                    </div>
                    <div class="ai-result-row">
                        <div class="ai-result-dot" style="background:#ef4444"></div>
                        <span><strong style="color:#f87171">3 đề xuất</strong> quá hạn</span>
                    </div>
                    <div class="ai-result-row">
                        <div class="ai-result-dot" style="background:#fb923c"></div>
                        <span><strong style="color:#fb923c">2 đề xuất</strong> có thời hạn dưới 1 ngày</span>
                    </div>
                    <div class="ai-result-row">
                        <div class="ai-result-dot" style="background:#60A5FA"></div>
                        <span><strong style="color:#93c5fd">5 đề xuất</strong> đã được cấp dưới của bạn phê duyệt và bạn là người duyệt cuối cùng</span>
                    </div>
                    <div class="ai-result-row">
                        <div class="ai-result-dot" style="background:#34d399"></div>
                        <span><strong style="color:#6ee7b7">3 đề xuất</strong> liên quan đến phê duyệt chi phí — khoản tiền ra cần bạn phê duyệt để có thể tiếp tục dự án</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- PHẢI: Bot Icons -->
        <div class="ai-bots-col">

            <div class="ai-bot" style="animation-delay:0s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.6)"/>
                    <circle cx="20" cy="16" r="6" stroke="#60A5FA" stroke-width="1.5"/>
                    <path d="M10 32c0-5.5 4.5-10 10-10s10 4.5 10 10" stroke="#60A5FA" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <div class="ai-bot-badge" style="background:#22c55e">✓</div>
            </div>

            <div class="ai-bot" style="animation-delay:-0.4s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(127,29,29,0.6)"/>
                    <rect x="12" y="12" width="16" height="16" rx="3" stroke="#f87171" stroke-width="1.5"/>
                    <line x1="16" y1="18" x2="24" y2="18" stroke="#f87171" stroke-width="1.5"/>
                    <line x1="16" y1="22" x2="21" y2="22" stroke="#f87171" stroke-width="1.5"/>
                </svg>
                <div class="ai-bot-badge" style="background:#ef4444">!</div>
            </div>

            <div class="ai-bot" style="animation-delay:-0.8s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(6,78,59,0.6)"/>
                    <polyline points="10,22 17,15 22,20 30,12" stroke="#22c55e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="ai-bot-badge" style="background:#3b82f6">↑</div>
            </div>

            <div class="ai-bot" style="animation-delay:-1.2s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.5)"/>
                    <circle cx="20" cy="20" r="7" stroke="#60A5FA" stroke-width="1.5"/>
                    <polyline points="20,14 20,20 24,22" stroke="#60A5FA" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <div class="ai-bot-badge" style="background:#8b5cf6">⏱</div>
            </div>

            <div class="ai-bot" style="animation-delay:-1.6s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.5)"/>
                    <path d="M20 10 L28 25 L12 25 Z" stroke="#60A5FA" stroke-width="1.5" stroke-linejoin="round"/>
                </svg>
                <div class="ai-bot-badge" style="background:#f59e0b">★</div>
            </div>

            <div class="ai-bot" style="animation-delay:-2s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(88,28,135,0.5)"/>
                    <rect x="11" y="15" width="18" height="12" rx="2" stroke="#a78bfa" stroke-width="1.5"/>
                    <line x1="15" y1="15" x2="15" y2="11" stroke="#a78bfa" stroke-width="1.5"/>
                    <line x1="25" y1="15" x2="25" y2="11" stroke="#a78bfa" stroke-width="1.5"/>
                </svg>
                <div class="ai-bot-badge" style="background:#22c55e">W</div>
            </div>

            <div class="ai-bot" style="animation-delay:-2.4s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(5,46,22,0.6)"/>
                    <circle cx="20" cy="20" r="7" stroke="#22c55e" stroke-width="1.5"/>
                    <line x1="20" y1="13" x2="20" y2="27" stroke="#22c55e" stroke-width="1.5"/>
                    <line x1="13" y1="20" x2="27" y2="20" stroke="#22c55e" stroke-width="1.5"/>
                </svg>
                <div class="ai-bot-badge" style="background:#60A5FA">+</div>
            </div>

            <div class="ai-bot" style="animation-delay:-2.8s">
                <svg viewBox="0 0 40 40" fill="none">
                    <rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.5)"/>
                    <circle cx="16" cy="16" r="4" stroke="#60A5FA" stroke-width="1.5"/>
                    <circle cx="26" cy="24" r="4" stroke="#93c5fd" stroke-width="1.5"/>
                    <line x1="19" y1="19" x2="23" y2="21" stroke="#60A5FA" stroke-width="1" stroke-dasharray="2 2"/>
                </svg>
                <div class="ai-bot-badge" style="background:#ef4444">⚙</div>
            </div>

        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section" id="cta">
    <div class="cta-bg"></div>
    <div class="cta-inner">
        <div class="reveal"><div class="cta-badge">Miễn phí · Không cần thẻ tín dụng</div></div>
        <div class="reveal reveal-delay-1"><h2 class="cta-title">Sẵn sàng đưa nhân sự<br>lên tầm cao mới?</h2></div>
        <div class="reveal reveal-delay-2"><p class="cta-sub">Hàng trăm doanh nghiệp đã tin dùng NovaHRM.<br>Đến lượt bạn trải nghiệm sự khác biệt.</p></div>
        <div class="cta-btns reveal reveal-delay-3">
            <a href="#" class="btn-cta-fill">Đăng ký Demo miễn phí</a>
            <a href="#" class="btn-cta-ghost">Đăng nhập</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <div class="footer-grid">
        <div>
            <a href="/" class="f-brand-logo">
                <div class="f-brand-logo-icon">
                    <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
                </div>
                Nova<span>HRM</span>
            </a>
            <p class="f-brand-desc">Nền tảng quản lý nhân sự hiện đại, giúp doanh nghiệp Việt vận hành hiệu quả và chuyên nghiệp hơn.</p>
            <div class="f-socials">
                <a href="#" class="f-social">f</a>
                <a href="#" class="f-social">in</a>
                <a href="#" class="f-social">yt</a>
                <a href="#" class="f-social">x</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Tính năng</h4>
            <ul>
                <li><a href="#">Quản lý nhân viên</a></li>
                <li><a href="#">Chấm công & Ca làm</a></li>
                <li><a href="#">Tính lương tự động</a></li>
                <li><a href="#">Báo cáo & Thống kê</a></li>
                <li><a href="#">Phân quyền vai trò</a></li>
            </ul>
        </div>
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
        <div class="footer-col">
            <h4>Công ty</h4>
            <ul>
                <li><a href="#">Về chúng tôi</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Liên hệ</a></li>
                <li><a href="#">Tuyển dụng</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Hỗ trợ</h4>
            <ul>
                <li><a href="#">Trung tâm hỗ trợ</a></li>
                <li><a href="#">Tài liệu hướng dẫn</a></li>
                <li><a href="#">Hỗ trợ kỹ thuật</a></li>
                <li><a href="#">Cộng đồng</a></li>
                <li><a href="#">Báo lỗi</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 NovaHRM. All rights reserved.</p>
        <div class="f-status">
            <div class="f-status-dot"></div>
            Tất cả hệ thống hoạt động bình thường
        </div>
        <div class="footer-links">
            <a href="#">Điều khoản sử dụng</a>
            <a href="#">Chính sách bảo mật</a>
            <a href="#">Bảo vệ dữ liệu</a>
        </div>
    </div>
</footer>

<script>
    // Navbar scroll
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
    }, { threshold: 0.1 });
    reveals.forEach(el => observer.observe(el));

    const spotCards = [
        ...document.querySelectorAll('.dash-stat'),
        ...document.querySelectorAll('.dash-card')
    ];
    let spotIdx = 0;

    function runSpotlight() {
        spotCards.forEach(c => c.classList.remove('spotlight', 'dimmed'));
        spotCards.forEach(c => c.classList.add('dimmed'));
        spotCards[spotIdx].classList.remove('dimmed');
        spotCards[spotIdx].classList.add('spotlight');
        spotIdx = (spotIdx + 1) % spotCards.length;
        setTimeout(runSpotlight, 2400);
    }
    setTimeout(runSpotlight, 1000);

    // Feature slider
    let featIdx = 0;
    const featSlides = document.querySelectorAll('.feat-slide');
    const featDots = document.querySelectorAll('.feat-dot');

    function featGoTo(idx) {
        featSlides[featIdx].classList.remove('active');
        featDots[featIdx].classList.remove('active');
        featIdx = (idx + featSlides.length) % featSlides.length;
        featSlides[featIdx].classList.add('active');
        featDots[featIdx].classList.add('active');
    }
    function featSlide(dir) { featGoTo(featIdx + dir); }

    // Auto slide mỗi 5 giây
    setInterval(() => featSlide(1), 5000);

    // Cursor glow trên title
    const featTitle = document.querySelector('.feat-main-title');
    if (featTitle) {
        const light = document.createElement('div');
        light.className = 'cursor-light';
        light.style.opacity = '0';
        featTitle.appendChild(light);

        featTitle.addEventListener('mousemove', e => {
            const r = featTitle.getBoundingClientRect();
            light.style.left = (e.clientX - r.left) + 'px';
            light.style.top = (e.clientY - r.top) + 'px';
            light.style.opacity = '1';
        });
        featTitle.addEventListener('mouseleave', () => {
            light.style.opacity = '0';
        });
    }

    // ── AI SECTION ──
    const aiResults = [
        {
            title: "Đề xuất cần phê duyệt",
            summary: "Hiện tại bạn có <strong>9 đề xuất</strong> cần phê duyệt:",
            list: [
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 đề xuất", text: " được gắn dấu sao" },
                { color: "#ef4444", textColor: "#f87171", bold: "3 đề xuất", text: " quá hạn" },
                { color: "#fb923c", textColor: "#fb923c", bold: "2 đề xuất", text: " có thời hạn dưới 1 ngày" },
                { color: "#60A5FA", textColor: "#93c5fd", bold: "5 đề xuất", text: " đã được cấp dưới phê duyệt, bạn là người duyệt cuối" },
                { color: "#34d399", textColor: "#6ee7b7", bold: "3 đề xuất", text: " liên quan chi phí cần bạn phê duyệt để tiếp tục dự án" },
            ]
        },
        {
            title: "Tóm tắt công việc tuần này",
            summary: "Team bạn đã hoàn thành <strong>87% KPI</strong> tuần này:",
            list: [
                { color: "#22c55e", textColor: "#4ade80", bold: "12 task", text: " đã hoàn thành đúng hạn" },
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 task", text: " đang trong tiến trình" },
                { color: "#ef4444", textColor: "#f87171", bold: "1 task", text: " bị trễ deadline cần xử lý" },
                { color: "#60A5FA", textColor: "#93c5fd", bold: "5 cuộc họp", text: " đã diễn ra, 2 còn lại trong tuần" },
                { color: "#a78bfa", textColor: "#c4b5fd", bold: "2 thành viên", text: " đang nghỉ phép, cần phân công lại" },
            ]
        },
        {
            title: "Tình hình tài chính tháng này",
            summary: "Doanh thu đạt <strong>92% kế hoạch</strong>, chi phí tốt:",
            list: [
                { color: "#22c55e", textColor: "#4ade80", bold: "4.2 tỷ VNĐ", text: " doanh thu tháng này" },
                { color: "#60A5FA", textColor: "#93c5fd", bold: "1.8 tỷ VNĐ", text: " chi phí vận hành, thấp hơn 8% dự kiến" },
                { color: "#f59e0b", textColor: "#fbbf24", bold: "3 khoản", text: " chi phí phát sinh cần phê duyệt" },
                { color: "#34d399", textColor: "#6ee7b7", bold: "Lợi nhuận", text: " tháng này ước đạt 2.4 tỷ VNĐ" },
                { color: "#fb923c", textColor: "#fb923c", bold: "Cảnh báo:", text: " ngân sách marketing sắp hết hạn mức" },
            ]
        },
        {
            title: "Lịch họp hôm nay",
            summary: "Bạn có <strong>4 cuộc họp</strong> quan trọng hôm nay:",
            list: [
                { color: "#60A5FA", textColor: "#93c5fd", bold: "09:00", text: " — Họp kick-off dự án Q2 (60 phút)" },
                { color: "#22c55e", textColor: "#4ade80", bold: "11:00", text: " — Review sprint với team kỹ thuật" },
                { color: "#f59e0b", textColor: "#fbbf24", bold: "14:00", text: " — Báo cáo tháng với Ban giám đốc" },
                { color: "#a78bfa", textColor: "#c4b5fd", bold: "16:30", text: " — 1-on-1 với trưởng phòng Marketing" },
                { color: "#34d399", textColor: "#6ee7b7", bold: "Gợi ý:", text: " chuẩn bị slide báo cáo trước 13:30" },
            ]
        }
    ];

    function aiSelect(el, idx) {
        document.querySelectorAll('.ai-chat-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');

        const data = aiResults[idx];
        const card = document.getElementById('aiResultCard');
        const title = document.getElementById('aiResultTitle');
        const summary = document.getElementById('aiResultSummary');
        const list = document.getElementById('aiResultList');

        // Ẩn card
        card.classList.remove('visible');
        list.innerHTML = '';

        setTimeout(() => {
            // Set title + summary ngay
            title.textContent = data.title;
            summary.innerHTML = data.summary;
            list.innerHTML = '';

            // Hiện card
            card.classList.add('visible');

            // Từng dòng bullet xuất hiện lần lượt
            data.list.forEach((row, i) => {
                setTimeout(() => {
                    const div = document.createElement('div');
                    div.className = 'ai-result-row';
                    div.style.opacity = '0';
                    div.style.transform = 'translateX(-10px)';
                    div.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                    div.innerHTML = `
                        <div class="ai-result-dot" style="background:${row.color}"></div>
                        <span>
                            <strong style="color:${row.textColor}">${row.bold}</strong>${row.text}
                        </span>
                    `;
                    list.appendChild(div);

                    // Trigger animation sau 1 frame
                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            div.style.opacity = '1';
                            div.style.transform = 'translateX(0)';
                        });
                    });

                }, i * 350); // mỗi dòng delay 350ms
            });

        }, 220);
    }

    // Auto cycle qua các item mỗi 3.5 giây
    let aiAutoIdx = 0;
    const aiItems = document.querySelectorAll('.ai-chat-item');

    function aiAutoCycle() {
        if (aiItems.length === 0) return;
        aiAutoIdx = (aiAutoIdx + 1) % aiItems.length;
        aiSelect(aiItems[aiAutoIdx], aiAutoIdx);
    }

    // Chỉ auto cycle khi user không hover vào panel
    let aiHovered = false;
    const aiPanel = document.querySelector('.ai-chat-panel');
    if (aiPanel) {
        aiPanel.addEventListener('mouseenter', () => aiHovered = true);
        aiPanel.addEventListener('mouseleave', () => aiHovered = false);
    }

    setInterval(() => {
        if (!aiHovered) aiAutoCycle();
    }, 3500);
    // Cursor glow cho AI title
    const aiHeroTitle = document.getElementById('aiHeroTitle');
    const aiTitleLight = document.getElementById('aiTitleLight');
    if (aiHeroTitle && aiTitleLight) {
        aiHeroTitle.addEventListener('mousemove', e => {
            const r = aiHeroTitle.getBoundingClientRect();
            aiTitleLight.style.left = (e.clientX - r.left) + 'px';
            aiTitleLight.style.top  = (e.clientY - r.top) + 'px';
            aiTitleLight.style.opacity = '1';
        });
        aiHeroTitle.addEventListener('mouseleave', () => {
            aiTitleLight.style.opacity = '0';
        });
    }

    // ── JOURNEY SECTION ──
    let journeyIdx = 0;
    const journeyBarWidths = ['25%', '50%', '75%', '100%'];

    function journeyGoTo(idx) {
        // Ẩn slide cũ
        document.getElementById('jslide-' + journeyIdx).classList.remove('active');

        // Update tabs
        document.querySelectorAll('.journey-tab').forEach((tab, i) => {
            tab.classList.toggle('active', i === idx);
        });

        // Update progress bar
        document.getElementById('journeyBar').style.width = journeyBarWidths[idx];

        // Hiện slide mới
        journeyIdx = idx;
        const newSlide = document.getElementById('jslide-' + idx);
        newSlide.classList.add('active');

        // Animate items theo data-delay
        const items = newSlide.querySelectorAll('.jflow-item');
        items.forEach(item => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(10px)';
        });
        items.forEach(item => {
            const delay = parseInt(item.getAttribute('data-delay') || 0);
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, delay);
        });

        // Animate từng node lần lượt
        nodes.forEach((n, i) => {
            setTimeout(() => {
                n.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                n.style.opacity = '1';
                n.style.transform = 'translateY(0)';
                n.classList.add('show');
            }, i * 150);
        });
    }

    // Auto cycle mỗi 4 giây
    let journeyHovered = false;
    let journeyAuto;

    function journeyStartAuto() {
        journeyAuto = setInterval(() => {
            if (!journeyHovered) {
                journeyGoTo((journeyIdx + 1) % 4);
            }
        }, 4000);
    }

    // Pause khi hover vào panel
    const journeyPanel = document.getElementById('journeyPanel');
    if (journeyPanel) {
        journeyPanel.addEventListener('mouseenter', () => journeyHovered = true);
        journeyPanel.addEventListener('mouseleave', () => journeyHovered = false);
    }

    // Cursor glow cho journey title
    const journeyTitle = document.getElementById('journeyTitle');
    const journeyTitleLight = document.getElementById('journeyTitleLight');
    if (journeyTitle && journeyTitleLight) {
        journeyTitle.addEventListener('mousemove', e => {
            const r = journeyTitle.getBoundingClientRect();
            journeyTitleLight.style.left = (e.clientX - r.left) + 'px';
            journeyTitleLight.style.top  = (e.clientY - r.top) + 'px';
            journeyTitleLight.style.opacity = '1';
        });
        journeyTitle.addEventListener('mouseleave', () => {
            journeyTitleLight.style.opacity = '0';
        });
    }

    // Khởi động auto sau 1.5s
    setTimeout(journeyStartAuto, 1500);

    // Trigger nodes show khi section vào viewport
    const journeyObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Animate nodes của slide đang active
                const activeSlide = document.querySelector('.journey-slide.active');
                if (activeSlide) {
                    const nodes = activeSlide.querySelectorAll('.jflow-node');
                    nodes.forEach((n, i) => {
                        n.style.opacity = '0';
                        n.style.transform = 'translateY(8px)';
                        setTimeout(() => {
                            n.style.transition = 'all 0.4s cubic-bezier(0.16,1,0.3,1)';
                            n.style.opacity = '1';
                            n.style.transform = 'translateY(0)';
                        }, 300 + i * 150);
                    });
                }
                journeyObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    const journeySection = document.getElementById('how');
    if (journeySection) journeyObserver.observe(journeySection);
</script>
</body>
</html>