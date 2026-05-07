<!-- CLIENTS STRIP -->
<div class="clients-strip">
    <div class="clients-label"><span>11,000+</span> @lang('nova-core::app.clients.label')</div>
    <div class="marquee-wrapper">
        <div class="marquee-track">
            @php
                $logos = [
                    ['abbr' => 'VP',  'name' => 'VPBank',       'bg' => '#1a3a6b', 'color' => '#60A5FA', 'size' => 13],
                    ['abbr' => 'JB',  'name' => 'Jollibee',     'bg' => '#7b1a1a', 'color' => '#fca5a5', 'size' => 11],
                    ['abbr' => 'NG',  'name' => 'Nagaco',        'bg' => '#1a4a2a', 'color' => '#86efac', 'size' => 11],
                    ['abbr' => 'AC',  'name' => 'ACB',           'bg' => '#1e3a5f', 'color' => '#93c5fd', 'size' => 14],
                    ['abbr' => 'VJ',  'name' => 'VietJet Air',   'bg' => '#4a1a6b', 'color' => '#c4b5fd', 'size' => 11],
                    ['abbr' => 'TH',  'name' => 'ThaiHa Books',  'bg' => '#3a2a0a', 'color' => '#fcd34d', 'size' => 11],
                    ['abbr' => 'MB',  'name' => 'MBBank',        'bg' => '#0a2a4a', 'color' => '#7dd3fc', 'size' => 11],
                    ['abbr' => 'VT',  'name' => 'Viettel',       'bg' => '#2a1a4a', 'color' => '#d8b4fe', 'size' => 11],
                    ['abbr' => 'VN',  'name' => 'Vingroup',      'bg' => '#1a3a1a', 'color' => '#6ee7b7', 'size' => 11],
                    ['abbr' => 'FPT', 'name' => 'FPT Corp',      'bg' => '#3a1a0a', 'color' => '#fdba74', 'size' => 11],
                ];
            @endphp

            {{-- Set 1 & 2 — duplicate để loop liền mạch --}}
            @foreach ([1, 2] as $set)
                @foreach ($logos as $logo)
                    <div class="marquee-logo">
                        <svg width="22" height="22" viewBox="0 0 40 40">
                            <rect width="40" height="40" rx="8" fill="{{ $logo['bg'] }}"/>
                            <text x="50%" y="56%" dominant-baseline="middle" text-anchor="middle"
                                  fill="{{ $logo['color'] }}" font-size="{{ $logo['size'] }}" font-weight="800">
                                {{ $logo['abbr'] }}
                            </text>
                        </svg>
                        {{ $logo['name'] }}
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
</div>