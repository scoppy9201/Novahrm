<!-- JOURNEY SECTION -->
<section class="journey-section" id="how">
    <div class="journey-bg"></div>

    <div class="reveal">
        <h2 class="journey-title" id="journeyTitle">
            @lang('nova-core::app.journey.title_line1')
            <br><span>@lang('nova-core::app.journey.title_line2')</span> @lang('nova-core::app.journey.title_line3')
            <div class="journey-title-light" id="journeyTitleLight"></div>
        </h2>
    </div>

    <div class="reveal reveal-delay-1">
        <a href="#" class="journey-cta-btn">
            @lang('nova-core::app.journey.cta_btn')
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </div>

    <!-- Tabs -->
    <div class="journey-tabs reveal reveal-delay-2">
        <button class="journey-tab active" onclick="journeyGoTo(0)">
            <div class="journey-tab-num">1</div>
            <span>@lang('nova-core::app.journey.tabs.consulting')</span>
        </button>
        <button class="journey-tab" onclick="journeyGoTo(1)">
            <div class="journey-tab-num">2</div>
            <span>@lang('nova-core::app.journey.tabs.digitizing')</span>
        </button>
        <button class="journey-tab" onclick="journeyGoTo(2)">
            <div class="journey-tab-num">3</div>
            <span>@lang('nova-core::app.journey.tabs.optimizing')</span>
        </button>
        <button class="journey-tab" onclick="journeyGoTo(3)">
            <div class="journey-tab-num">4</div>
            <span>@lang('nova-core::app.journey.tabs.data_driven')</span>
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
                <div class="journey-left-title">@lang('nova-core::app.journey.slides.consulting.title')</div>
                <div class="journey-left-desc">@lang('nova-core::app.journey.slides.consulting.desc')</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0">
                        <div class="jflow-item-num">1</div>
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        @lang('nova-core::app.journey.slides.consulting.steps.1')
                    </div>
                    <div class="jflow-connector">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num">2</div>
                        <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        @lang('nova-core::app.journey.slides.consulting.steps.2')
                    </div>
                    <div class="jflow-connector">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num">3</div>
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        @lang('nova-core::app.journey.slides.consulting.steps.3')
                    </div>
                    <div class="jflow-connector">
                        <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num">4</div>
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        @lang('nova-core::app.journey.slides.consulting.steps.4')
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
                <div class="journey-left-title">@lang('nova-core::app.journey.slides.digitizing.title')</div>
                <div class="journey-left-desc">@lang('nova-core::app.journey.slides.digitizing.desc')</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0" style="border-color:rgba(34,197,94,0.4);background:rgba(5,150,105,0.15)">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">1</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        <span style="color:#e0eeff">@lang('nova-core::app.journey.slides.digitizing.steps.1')</span>
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">2</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        @lang('nova-core::app.journey.slides.digitizing.steps.2')
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">3</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                        @lang('nova-core::app.journey.slides.digitizing.steps.3')
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#059669,#22c55e)">4</div>
                        <svg viewBox="0 0 24 24" style="stroke:#22c55e"><polyline points="20 6 9 17 4 12"/></svg>
                        @lang('nova-core::app.journey.slides.digitizing.steps.4')
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
                <div class="journey-left-title">@lang('nova-core::app.journey.slides.optimizing.title')</div>
                <div class="journey-left-desc">@lang('nova-core::app.journey.slides.optimizing.desc')</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0" style="border-color:rgba(167,139,250,0.4);background:rgba(124,58,237,0.15)">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">1</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        <span style="color:#e0eeff">@lang('nova-core::app.journey.slides.optimizing.steps.1')</span>
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">2</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                        @lang('nova-core::app.journey.slides.optimizing.steps.2')
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">3</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        @lang('nova-core::app.journey.slides.optimizing.steps.3')
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">4</div>
                        <svg viewBox="0 0 24 24" style="stroke:#a78bfa"><polyline points="20 6 9 17 4 12"/></svg>
                        @lang('nova-core::app.journey.slides.optimizing.steps.4')
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
                <div class="journey-left-title">@lang('nova-core::app.journey.slides.data_driven.title')</div>
                <div class="journey-left-desc">@lang('nova-core::app.journey.slides.data_driven.desc')</div>
            </div>
            <div class="journey-right">
                <div class="jflow-list">
                    <div class="jflow-item highlight" data-delay="0" style="border-color:rgba(251,146,60,0.4);background:rgba(194,65,12,0.15)">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">1</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                        <span style="color:#e0eeff">@lang('nova-core::app.journey.slides.data_driven.steps.1')</span>
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="150">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">2</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        @lang('nova-core::app.journey.slides.data_driven.steps.2')
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="300">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">3</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @lang('nova-core::app.journey.slides.data_driven.steps.3')
                    </div>
                    <div class="jflow-connector"><svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="6 9 12 15 18 9"/></svg></div>
                    <div class="jflow-item" data-delay="450">
                        <div class="jflow-item-num" style="background:linear-gradient(135deg,#c2410c,#fb923c)">4</div>
                        <svg viewBox="0 0 24 24" style="stroke:#fb923c"><polyline points="20 6 9 17 4 12"/></svg>
                        @lang('nova-core::app.journey.slides.data_driven.steps.4')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>