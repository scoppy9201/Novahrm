<!-- INDUSTRIES SECTION -->
<section class="industries-section">
    <div class="industries-eyebrow reveal">@lang('nova-core::app.industries.eyebrow')</div>
    <div class="industries-title reveal reveal-delay-1">
        <span class="industries-badge-60">60+</span>
        @lang('nova-core::app.industries.title')
    </div>

    <!-- Tabs -->
    <div class="ind-tabs reveal reveal-delay-2">
        @php
            $indTabIcons = [
                'manufacturing' => '<circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/>',
                'pharma'        => '<path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
                'construction'  => '<rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/>',
                'fnb'           => '<path d="M3 11l19-9-9 19-2-8-8-2z"/>',
                'education'     => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
                'healthcare'    => '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>',
                'furniture'     => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>',
                'other'         => '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
            ];
        @endphp

        @foreach ($indTabIcons as $key => $icon)
            <button class="ind-tab {{ $loop->first ? 'active' : '' }}" onclick="indGoTo({{ $loop->index }})">
                <svg viewBox="0 0 24 24">{!! $icon !!}</svg>
                @lang('nova-core::app.industries.tabs.' . $key)
            </button>
        @endforeach
    </div>

    <!-- Panels -->
    @php $industries = array_keys($indTabIcons); @endphp

    @foreach ($industries as $i => $key)
    <div class="ind-panel {{ $i === 0 ? 'active' : '' }} reveal reveal-delay-3" id="ind-{{ $i }}">
        <div class="ind-left">
            <div class="ind-mockup">
                <div class="ind-mockup-header">@lang('nova-core::app.industries.panels.' . $key . '.mockup.header')</div>
                @for ($r = 1; $r <= 4; $r++)
                <div class="ind-mockup-row">
                    <span>@lang('nova-core::app.industries.panels.' . $key . '.mockup.rows.' . $r . '.label')</span>
                    <span class="ind-mockup-tag @lang('nova-core::app.industries.panels.' . $key . '.mockup.rows.' . $r . '.badge')">
                        @lang('nova-core::app.industries.panels.' . $key . '.mockup.rows.' . $r . '.value')
                    </span>
                </div>
                @endfor
            </div>
        </div>
        <div class="ind-right">
            <div class="ind-right-title">@lang('nova-core::app.industries.panels.' . $key . '.title')</div>
            <div class="ind-features">
                @for ($f = 1; $f <= 3; $f++)
                <div class="ind-feature">
                    <div class="ind-feature-diamond">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <span>@lang('nova-core::app.industries.panels.' . $key . '.features.' . $f)</span>
                </div>
                @endfor
            </div>
            <div class="ind-clients-label">@lang('nova-core::app.industries.panels.' . $key . '.clients_label')</div>
            <div class="ind-client-logos">
                @foreach (__('nova-core::app.industries.panels.' . $key . '.clients') as $client)
                    <div class="ind-client-logo">{{ $client }}</div>
                @endforeach
            </div>
            <a href="#" class="ind-cta-link">
                @lang('nova-core::app.industries.panels.' . $key . '.cta')
                <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
    @endforeach
</section>