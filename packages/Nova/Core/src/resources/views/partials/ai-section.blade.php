<!-- AI SECTION -->
<section class="ai-section">
    <div class="ai-section-bg"></div>

    <div class="reveal">
        <h2 class="ai-hero-title" id="aiHeroTitle">
            {!! __('nova-core::app.ai.title') !!}
            <div class="ai-title-cursor-light" id="aiTitleLight"></div>
        </h2>
    </div>

    <div class="reveal reveal-delay-1">
        <div class="ai-badge">@lang('nova-core::app.ai.badge')</div>
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
                <div class="ai-chat-greeting">{!! __('nova-core::app.ai.greeting') !!}</div>
            </div>

            @foreach(__('nova-core::app.ai.chat_items') as $i => $item)
            <button class="ai-chat-item {{ $i === 0 ? 'active' : '' }}" onclick="aiSelect(this, {{ $i }})">
                <div class="ai-chat-item-icon">
                    {!! $item['icon'] !!}
                </div>
                <span class="ai-chat-item-text">{{ $item['text'] }}</span>
            </button>
            @endforeach
        </div>

        <!-- GIỮA: Gem + SVG Lines + Result Card -->
        <div class="ai-center-col">
            <!-- SVG Lines (giữ nguyên, không có text) -->
            <svg class="ai-lines-svg" viewBox="0 0 500 500" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="lineGrad0" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#60A5FA" stop-opacity="0.9"/><stop offset="100%" stop-color="#60A5FA" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad1" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#818cf8" stop-opacity="0.8"/><stop offset="100%" stop-color="#818cf8" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad2" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#34d399" stop-opacity="0.8"/><stop offset="100%" stop-color="#34d399" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad3" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#60A5FA" stop-opacity="0.7"/><stop offset="100%" stop-color="#60A5FA" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad4" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#f472b6" stop-opacity="0.7"/><stop offset="100%" stop-color="#f472b6" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad5" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#fb923c" stop-opacity="0.7"/><stop offset="100%" stop-color="#fb923c" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad6" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#a78bfa" stop-opacity="0.7"/><stop offset="100%" stop-color="#a78bfa" stop-opacity="0.05"/></linearGradient>
                    <linearGradient id="lineGrad7" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" stop-color="#22d3ee" stop-opacity="0.7"/><stop offset="100%" stop-color="#22d3ee" stop-opacity="0.05"/></linearGradient>
                    <filter id="lineGlow"><feGaussianBlur stdDeviation="2" result="blur"/><feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
                </defs>
                <path class="ai-line-curve" id="line0" d="M 250 250 C 320 240, 400 140, 500 60"  stroke="url(#lineGrad0)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line1" d="M 250 250 C 330 235, 420 175, 500 110" stroke="url(#lineGrad1)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line2" d="M 250 250 C 340 245, 430 215, 500 185" stroke="url(#lineGrad2)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line3" d="M 250 250 C 350 250, 440 255, 500 260" stroke="url(#lineGrad3)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line4" d="M 250 250 C 340 258, 430 295, 500 330" stroke="url(#lineGrad4)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line5" d="M 250 250 C 330 268, 415 340, 500 390" stroke="url(#lineGrad5)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line6" d="M 250 250 C 320 275, 410 380, 500 430" stroke="url(#lineGrad6)" filter="url(#lineGlow)"/>
                <path class="ai-line-curve" id="line7" d="M 250 250 C 310 290, 400 430, 500 480" stroke="url(#lineGrad7)" filter="url(#lineGlow)"/>
                <circle class="ai-flow-dot" r="3" fill="#60A5FA"><animateMotion dur="2s"   repeatCount="indefinite" begin="0s"><mpath href="#line0"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#818cf8"><animateMotion dur="2.3s" repeatCount="indefinite" begin="-0.3s"><mpath href="#line1"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#34d399"><animateMotion dur="2.1s" repeatCount="indefinite" begin="-0.6s"><mpath href="#line2"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#60A5FA"><animateMotion dur="1.9s" repeatCount="indefinite" begin="-0.9s"><mpath href="#line3"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#f472b6"><animateMotion dur="2.4s" repeatCount="indefinite" begin="-1.2s"><mpath href="#line4"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#fb923c"><animateMotion dur="2.2s" repeatCount="indefinite" begin="-1.5s"><mpath href="#line5"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#a78bfa"><animateMotion dur="2.5s" repeatCount="indefinite" begin="-1.8s"><mpath href="#line6"/></animateMotion></circle>
                <circle class="ai-flow-dot" r="3" fill="#22d3ee"><animateMotion dur="2s"   repeatCount="indefinite" begin="-2.1s"><mpath href="#line7"/></animateMotion></circle>
            </svg>

            <!-- Gem trung tâm -->
            <div class="ai-gem-wrap">
                <div class="ai-gem">
                    <svg viewBox="0 0 24 24" fill="white">
                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                    </svg>
                </div>
            </div>

            <!-- Result Card -->
            <div class="ai-result-card visible" id="aiResultCard">
                <div class="ai-result-title" id="aiResultTitle">@lang('nova-core::app.ai.results.0.title')</div>
                <div class="ai-result-summary" id="aiResultSummary">
                    {!! __('nova-core::app.ai.results.0.summary') !!}
                </div>
                <div class="ai-result-list" id="aiResultList">
                    @foreach(__('nova-core::app.ai.results.0.rows') as $row)
                    <div class="ai-result-row">
                        <div class="ai-result-dot" style="background:{{ $row['color'] }}"></div>
                        <span>{!! $row['text'] !!}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- PHẢI: Bot Icons (SVG thuần, không có text) -->
        <div class="ai-bots-col">
            <div class="ai-bot" style="animation-delay:0s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.6)"/><circle cx="20" cy="16" r="6" stroke="#60A5FA" stroke-width="1.5"/><path d="M10 32c0-5.5 4.5-10 10-10s10 4.5 10 10" stroke="#60A5FA" stroke-width="1.5" stroke-linecap="round"/></svg>
                <div class="ai-bot-badge" style="background:#22c55e">✓</div>
            </div>
            <div class="ai-bot" style="animation-delay:-0.4s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(127,29,29,0.6)"/><rect x="12" y="12" width="16" height="16" rx="3" stroke="#f87171" stroke-width="1.5"/><line x1="16" y1="18" x2="24" y2="18" stroke="#f87171" stroke-width="1.5"/><line x1="16" y1="22" x2="21" y2="22" stroke="#f87171" stroke-width="1.5"/></svg>
                <div class="ai-bot-badge" style="background:#ef4444">!</div>
            </div>
            <div class="ai-bot" style="animation-delay:-0.8s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(6,78,59,0.6)"/><polyline points="10,22 17,15 22,20 30,12" stroke="#22c55e" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <div class="ai-bot-badge" style="background:#3b82f6">↑</div>
            </div>
            <div class="ai-bot" style="animation-delay:-1.2s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.5)"/><circle cx="20" cy="20" r="7" stroke="#60A5FA" stroke-width="1.5"/><polyline points="20,14 20,20 24,22" stroke="#60A5FA" stroke-width="1.5" stroke-linecap="round"/></svg>
                <div class="ai-bot-badge" style="background:#8b5cf6">⏱</div>
            </div>
            <div class="ai-bot" style="animation-delay:-1.6s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.5)"/><path d="M20 10 L28 25 L12 25 Z" stroke="#60A5FA" stroke-width="1.5" stroke-linejoin="round"/></svg>
                <div class="ai-bot-badge" style="background:#f59e0b">★</div>
            </div>
            <div class="ai-bot" style="animation-delay:-2s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(88,28,135,0.5)"/><rect x="11" y="15" width="18" height="12" rx="2" stroke="#a78bfa" stroke-width="1.5"/><line x1="15" y1="15" x2="15" y2="11" stroke="#a78bfa" stroke-width="1.5"/><line x1="25" y1="15" x2="25" y2="11" stroke="#a78bfa" stroke-width="1.5"/></svg>
                <div class="ai-bot-badge" style="background:#22c55e">W</div>
            </div>
            <div class="ai-bot" style="animation-delay:-2.4s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(5,46,22,0.6)"/><circle cx="20" cy="20" r="7" stroke="#22c55e" stroke-width="1.5"/><line x1="20" y1="13" x2="20" y2="27" stroke="#22c55e" stroke-width="1.5"/><line x1="13" y1="20" x2="27" y2="20" stroke="#22c55e" stroke-width="1.5"/></svg>
                <div class="ai-bot-badge" style="background:#60A5FA">+</div>
            </div>
            <div class="ai-bot" style="animation-delay:-2.8s">
                <svg viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="20" fill="rgba(30,58,138,0.5)"/><circle cx="16" cy="16" r="4" stroke="#60A5FA" stroke-width="1.5"/><circle cx="26" cy="24" r="4" stroke="#93c5fd" stroke-width="1.5"/><line x1="19" y1="19" x2="23" y2="21" stroke="#60A5FA" stroke-width="1" stroke-dasharray="2 2"/></svg>
                <div class="ai-bot-badge" style="background:#ef4444">⚙</div>
            </div>
        </div>
    </div>
</section>