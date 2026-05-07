<section class="products-section">
    <div class="products-inner">

        <div class="products-header">
            <div class="s-eyebrow">@lang('nova-core::app.products.eyebrow')</div>
            <h2 class="s-title">
                @lang('nova-core::app.products.title_line_1')<br>
                <span class="products-title-blue">@lang('nova-core::app.products.title_highlight')</span>
            </h2>
            <p class="s-sub">@lang('nova-core::app.products.subtitle')</p>
        </div>

        @php
        $products = [
            'e_hiring' => [
                'delay' => '0.05s',
                'gradient' => 'linear-gradient(135deg,#2563EB,#60A5FA)',
                'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/>',
            ],
            'hrm' => [
                'delay' => '0.10s',
                'gradient' => 'linear-gradient(135deg,#4F46E5,#818CF8)',
                'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
            ],
            'referral' => [
                'delay' => '0.15s',
                'gradient' => 'linear-gradient(135deg,#7C3AED,#A78BFA)',
                'icon' => '<path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/>',
            ],
            'payroll' => [
                'delay' => '0.20s',
                'gradient' => 'linear-gradient(135deg,#059669,#34D399)',
                'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
            ],
            'checkin' => [
                'delay' => '0.25s',
                'gradient' => 'linear-gradient(135deg,#D97706,#FBBF24)',
                'icon' => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
            ],
            'schedule' => [
                'delay' => '0.30s',
                'gradient' => 'linear-gradient(135deg,#0284C7,#38BDF8)',
                'icon' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="16" y1="2" x2="16" y2="6"/>',
            ],
            'timeoff' => [
                'delay' => '0.35s',
                'gradient' => 'linear-gradient(135deg,#DC2626,#F87171)',
                'icon' => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
            ],
            'asset' => [
                'delay' => '0.40s',
                'gradient' => 'linear-gradient(135deg,#1D4ED8,#60A5FA)',
                'icon' => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
            ],
            'review' => [
                'delay' => '0.45s',
                'gradient' => 'linear-gradient(135deg,#047857,#10B981)',
                'icon' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            ],
            'goal' => [
                'delay' => '0.50s',
                'gradient' => 'linear-gradient(135deg,#6D28D9,#A78BFA)',
                'icon' => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/>',
            ],
            'run' => [
                'delay' => '0.55s',
                'gradient' => 'linear-gradient(135deg,#B45309,#F59E0B)',
                'icon' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
            ],
            'onboard' => [
                'delay' => '0.60s',
                'gradient' => 'linear-gradient(135deg,#065F46,#34D399)',
                'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>',
            ],
            'case' => [
                'delay' => '0.65s',
                'gradient' => 'linear-gradient(135deg,#1E40AF,#3B82F6)',
                'icon' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
            ],
            'test' => [
                'delay' => '0.70s',
                'gradient' => 'linear-gradient(135deg,#1D4ED8,#60A5FA)',
                'icon' => '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
            ],
            'me' => [
                'delay' => '0.75s',
                'gradient' => 'linear-gradient(135deg,#0369A1,#38BDF8)',
                'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
            ],
            'pit' => [
                'delay' => '0.80s',
                'gradient' => 'linear-gradient(135deg,#991B1B,#F87171)',
                'icon' => '<line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
            ],
            'reward' => [
                'delay' => '0.85s',
                'gradient' => 'linear-gradient(135deg,#065F46,#10B981)',
                'icon' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
            ],
            'vss' => [
                'delay' => '0.90s',
                'gradient' => 'linear-gradient(135deg,#1E3A8A,#3B82F6)',
                'icon' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
            ],
        ];
        @endphp

        <div class="products-grid">
            @foreach ($products as $key => $product)
                <div class="prod-item reveal" style="transition-delay: {{ $product['delay'] }}">
                    <div class="prod-icon" style="background: {{ $product['gradient'] }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            {!! $product['icon'] !!}
                        </svg>
                    </div>
                    <div class="prod-name">@lang('nova-core::app.products.items.' . $key . '.name')</div>
                    <div class="prod-desc">@lang('nova-core::app.products.items.' . $key . '.desc')</div>
                </div>
            @endforeach
        </div>
    </div>
</section>