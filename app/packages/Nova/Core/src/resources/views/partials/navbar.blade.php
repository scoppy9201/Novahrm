@php
use Illuminate\Support\Facades\Route;

$hrmPlusIcons = [
    'e_hiring' => ['gradient' => 'linear-gradient(135deg,#2563EB,#60A5FA)', 'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>'],
    'hrm'      => ['gradient' => 'linear-gradient(135deg,#4F46E5,#818CF8)', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
    'payroll'  => ['gradient' => 'linear-gradient(135deg,#059669,#34D399)',  'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
    'schedule' => ['gradient' => 'linear-gradient(135deg,#0284C7,#38BDF8)', 'icon' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/>'],
    'checkin'  => ['gradient' => 'linear-gradient(135deg,#D97706,#FBBF24)', 'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>'],
    'timeoff'  => ['gradient' => 'linear-gradient(135deg,#DC2626,#F87171)', 'icon' => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>'],
];

$devIcons = [
    'referral' => ['gradient' => 'linear-gradient(135deg,#7C3AED,#A78BFA)', 'icon' => '<path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/>'],
    'onboard'  => ['gradient' => 'linear-gradient(135deg,#065F46,#34D399)', 'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>'],
    'goal'     => ['gradient' => 'linear-gradient(135deg,#6D28D9,#A78BFA)', 'icon' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>'],
    'review'   => ['gradient' => 'linear-gradient(135deg,#047857,#10B981)', 'icon' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'],
    'reward'   => ['gradient' => 'linear-gradient(135deg,#065F46,#10B981)', 'icon' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>'],
    'test'     => ['gradient' => 'linear-gradient(135deg,#1D4ED8,#60A5FA)', 'icon' => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>'],
];

$opsIcons = [
    'asset'    => ['gradient' => 'linear-gradient(135deg,#1D4ED8,#60A5FA)', 'icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>'],
    'pit'      => ['gradient' => 'linear-gradient(135deg,#991B1B,#F87171)', 'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
    'vss'      => ['gradient' => 'linear-gradient(135deg,#1E3A8A,#3B82F6)', 'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
    'case'     => ['gradient' => 'linear-gradient(135deg,#1E40AF,#3B82F6)', 'icon' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>'],
    'me'       => ['gradient' => 'linear-gradient(135deg,#0369A1,#38BDF8)', 'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>'],
    'run'      => ['gradient' => 'linear-gradient(135deg,#B45309,#F59E0B)', 'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>'],
];

$solutionIcons = [
    'sme'        => ['gradient' => 'linear-gradient(135deg,#1D4ED8,#60A5FA)', 'icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>'],
    'enterprise' => ['gradient' => 'linear-gradient(135deg,#7C3AED,#A78BFA)', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>'],
    'pricing'    => ['gradient' => 'linear-gradient(135deg,#059669,#34D399)', 'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>'],
];

$industryIcons = [
    'manufacturing' => ['gradient' => 'linear-gradient(135deg,#1D4ED8,#60A5FA)', 'icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/>'],
    'pharma'        => ['gradient' => 'linear-gradient(135deg,#059669,#34D399)', 'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>'],
    'construction'  => ['gradient' => 'linear-gradient(135deg,#D97706,#FBBF24)', 'icon' => '<polygon points="12 2 22 8.5 22 15.5 12 22 2 15.5 2 8.5 12 2"/>'],
    'fnb'           => ['gradient' => 'linear-gradient(135deg,#DC2626,#F87171)', 'icon' => '<path d="M3 11l19-9-9 19-2-8-8-2z"/>'],
    'education'     => ['gradient' => 'linear-gradient(135deg,#7C3AED,#A78BFA)', 'icon' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>'],
    'healthcare'    => ['gradient' => 'linear-gradient(135deg,#0369A1,#38BDF8)', 'icon' => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>'],
    'furniture'     => ['gradient' => 'linear-gradient(135deg,#B45309,#F59E0B)', 'icon' => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/>'],
    'other'         => ['gradient' => 'linear-gradient(135deg,#4F46E5,#818CF8)', 'icon' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>'],
];
@endphp

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="/" class="logo">
        <div class="logo-icon">
            <svg viewBox="0 0 16 16"><path d="M8 1L14 4V8C14 11.3 11.3 13.8 8 15C4.7 13.8 2 11.3 2 8V4L8 1Z"/></svg>
        </div>
        Nova<span>HRM</span>
    </a>

    <div class="nav-center">
        <button class="nav-item nav-toggle" data-menu="menu-sanpham">
            @lang('nova-core::app.navbar.products')
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <button class="nav-item nav-toggle" data-menu="menu-giaiphap">
            @lang('nova-core::app.navbar.solutions')
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <button class="nav-item nav-toggle" data-menu="menu-linhvuc">
            @lang('nova-core::app.navbar.industries')
            <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <a href="#" class="nav-item">@lang('nova-core::app.navbar.news')</a>
        <a href="#" class="nav-item">@lang('nova-core::app.navbar.customers')</a>
        <a href="#" class="nav-item">@lang('nova-core::app.navbar.about')</a>
    </div>

    <div class="nav-right">
        <a href="{{ route('login') }}" class="btn-login">@lang('nova-core::app.navbar.login')</a>
        <a href="#" class="btn-demo" id="btnOpenDemo">@lang('nova-core::app.navbar.register_demo')</a>
    </div>
</nav>

<div class="mega-overlay" id="megaOverlay"></div>

<!-- MEGA MENU: Sản phẩm -->
<div class="mega-menu" id="menu-sanpham">
    <div class="mega-inner">

        {{-- HRM+ --}}
        <div class="mega-col">
            <div class="mega-group-title">@lang('nova-core::app.mega.products.group_hrm')</div>
            <div class="mega-links">
                @foreach ($hrmPlusIcons as $key => $meta)
                    <a href="#" class="mega-link">
                        <div class="mega-link-icon" style="background:{{ $meta['gradient'] }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $meta['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="mega-link-name">@lang('nova-core::app.mega.products.hrm_plus.' . $key . '.name')</div>
                            <div class="mega-link-desc">@lang('nova-core::app.mega.products.hrm_plus.' . $key . '.desc')</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Dev --}}
        <div class="mega-col">
            <div class="mega-group-title">@lang('nova-core::app.mega.products.group_dev')</div>
            <div class="mega-links">
                @foreach ($devIcons as $key => $meta)
                    <a href="#" class="mega-link">
                        <div class="mega-link-icon" style="background:{{ $meta['gradient'] }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $meta['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="mega-link-name">@lang('nova-core::app.mega.products.dev.' . $key . '.name')</div>
                            <div class="mega-link-desc">@lang('nova-core::app.mega.products.dev.' . $key . '.desc')</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Ops --}}
        <div class="mega-col">
            <div class="mega-group-title">@lang('nova-core::app.mega.products.group_ops')</div>
            <div class="mega-links">
                @foreach ($opsIcons as $key => $meta)
                    <a href="#" class="mega-link">
                        <div class="mega-link-icon" style="background:{{ $meta['gradient'] }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $meta['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="mega-link-name">@lang('nova-core::app.mega.products.ops.' . $key . '.name')</div>
                            <div class="mega-link-desc">@lang('nova-core::app.mega.products.ops.' . $key . '.desc')</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- CTA --}}
        <div class="mega-cta-card">
            <div class="mega-cta-glow"></div>
            <div class="mega-cta-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="mega-cta-title">
                @lang('nova-core::app.mega.products.cta.title')<br>
                <span>@lang('nova-core::app.mega.products.cta.highlight')</span>
            </div>
            <div class="mega-cta-desc">@lang('nova-core::app.mega.products.cta.desc')</div>
            <a href="#" class="mega-cta-btn">
                @lang('nova-core::app.mega.products.cta.btn')
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- MEGA MENU: Giải pháp & Giá -->
<div class="mega-menu" id="menu-giaiphap">
    <div class="mega-inner">
        <div class="mega-col">
            <div class="mega-group-title">@lang('nova-core::app.mega.solutions.group_scale')</div>
            <div class="mega-links">
                @foreach ($solutionIcons as $key => $meta)
                    <a href="#" class="mega-link">
                        <div class="mega-link-icon" style="background:{{ $meta['gradient'] }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $meta['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="mega-link-name">@lang('nova-core::app.mega.solutions.items.' . $key . '.name')</div>
                            <div class="mega-link-desc">@lang('nova-core::app.mega.solutions.items.' . $key . '.desc')</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mega-cta-card" style="margin-left:auto">
            <div class="mega-cta-glow"></div>
            <div class="mega-cta-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="mega-cta-title">
                @lang('nova-core::app.mega.solutions.cta.title')<br>
                <span>@lang('nova-core::app.mega.solutions.cta.highlight')</span>
            </div>
            <div class="mega-cta-desc">@lang('nova-core::app.mega.solutions.cta.desc')</div>
            <a href="#" class="mega-cta-btn">
                @lang('nova-core::app.mega.solutions.cta.btn')
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>

<!-- MEGA MENU: Lĩnh vực -->
<div class="mega-menu" id="menu-linhvuc">
    <div class="mega-inner">
        <div class="mega-col">
            <div class="mega-group-title">@lang('nova-core::app.mega.industries.group_label')</div>
            <div class="mega-links">
                @foreach ($industryIcons as $key => $meta)
                    <a href="#" class="mega-link">
                        <div class="mega-link-icon" style="background:{{ $meta['gradient'] }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                {!! $meta['icon'] !!}
                            </svg>
                        </div>
                        <div>
                            <div class="mega-link-name">@lang('nova-core::app.mega.industries.items.' . $key . '.name')</div>
                            <div class="mega-link-desc">@lang('nova-core::app.mega.industries.items.' . $key . '.desc')</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mega-cta-card" style="margin-left:auto">
            <div class="mega-cta-glow"></div>
            <div class="mega-cta-icon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="mega-cta-title">
                @lang('nova-core::app.mega.industries.cta.title')<br>
                <span>@lang('nova-core::app.mega.industries.cta.highlight')</span>
            </div>
            <div class="mega-cta-desc">@lang('nova-core::app.mega.industries.cta.desc')</div>
            <a href="#" class="mega-cta-btn">
                @lang('nova-core::app.mega.industries.cta.btn')
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>