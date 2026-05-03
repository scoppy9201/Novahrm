<!-- DEMO MODAL -->
<div class="demo-modal-overlay" id="demoModalOverlay">
    <div class="demo-modal">
        <button class="demo-modal-close" id="demoModalClose">&#x2715;</button>

        <!-- LEFT -->
        <div class="demo-modal-left">
            <div class="demo-left-badge">
                <span class="demo-left-badge-dot"></span>
                @lang('nova-core::app.badge.free')
            </div>
            <div class="demo-left-title">
                {!! __('nova-core::app.left.title') !!}
            </div>
            <div class="demo-left-desc">
                @lang('nova-core::app.left.description')
            </div>
            <div class="demo-left-checks">
                <div class="demo-left-check">
                    <div class="demo-left-check-icon">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    @lang('nova-core::app.left.checks.customized')
                </div>
                <div class="demo-left-check">
                    <div class="demo-left-check-icon">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    @lang('nova-core::app.left.checks.consulting')
                </div>
                <div class="demo-left-check">
                    <div class="demo-left-check-icon">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    @lang('nova-core::app.left.checks.support')
                </div>
            </div>
            <div class="demo-left-partners">
                <div class="demo-left-partners-label">
                    @lang('nova-core::app.left.partners.label')
                </div>
                <div class="demo-left-logos">
                    <div class="demo-left-logo">AUTOTECH</div>
                    <div class="demo-left-logo">NEX</div>
                    <div class="demo-left-logo">WinCommerce</div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Form -->
        <div class="demo-modal-right">
            <div class="demo-form-title">@lang('nova-core::app.form.title')</div>
            <div class="demo-form-sub">@lang('nova-core::app.form.subtitle')</div>

            <form id="demoForm">
                @csrf

                {{-- Họ và tên --}}
                <div class="demo-form-group">
                    <label class="demo-form-label">
                        @lang('nova-core::app.form.fields.name.label') <span>*</span>
                    </label>
                    <input id="df_name" class="demo-input" type="text"
                           placeholder="@lang('nova-core::app.form.fields.name.placeholder')">
                </div>

                {{-- Sản phẩm --}}
                <div class="demo-form-group">
                    <label class="demo-form-label">
                        @lang('nova-core::app.form.fields.product.label') <span>*</span>
                    </label>
                    <div class="demo-select-wrap">
                        <select id="df_product" class="demo-select">
                            <option value="" disabled selected>
                                @lang('nova-core::app.form.fields.product.placeholder')
                            </option>
                            <option>@lang('nova-core::app.form.fields.product.options.e_hiring')</option>
                            <option>@lang('nova-core::app.form.fields.product.options.hrm')</option>
                            <option>@lang('nova-core::app.form.fields.product.options.payroll')</option>
                            <option>@lang('nova-core::app.form.fields.product.options.schedule')</option>
                            <option>@lang('nova-core::app.form.fields.product.options.checkin')</option>
                            <option>@lang('nova-core::app.form.fields.product.options.timeoff')</option>
                            <option>@lang('nova-core::app.form.fields.product.options.all')</option>
                        </select>
                    </div>
                </div>

                {{-- Email + Phone --}}
                <div class="demo-form-row">
                    <div class="demo-form-group">
                        <label class="demo-form-label">
                            @lang('nova-core::app.form.fields.email.label') <span>*</span>
                        </label>
                        <input id="df_email" class="demo-input" type="email"
                               placeholder="@lang('nova-core::app.form.fields.email.placeholder')">
                    </div>
                    <div class="demo-form-group">
                        <label class="demo-form-label">
                            @lang('nova-core::app.form.fields.phone.label') <span>*</span>
                        </label>
                        <input id="df_phone" class="demo-input" type="tel"
                               placeholder="@lang('nova-core::app.form.fields.phone.placeholder')">
                    </div>
                </div>

                {{-- Position + Company --}}
                <div class="demo-form-row">
                    <div class="demo-form-group">
                        <label class="demo-form-label">
                            @lang('nova-core::app.form.fields.position.label') <span>*</span>
                        </label>
                        <div class="demo-select-wrap">
                            <select id="df_position" class="demo-select">
                                <option value="" disabled selected>
                                    @lang('nova-core::app.form.fields.position.placeholder')
                                </option>
                                <option>@lang('nova-core::app.form.fields.position.options.ceo')</option>
                                <option>@lang('nova-core::app.form.fields.position.options.hr_manager')</option>
                                <option>@lang('nova-core::app.form.fields.position.options.hr_staff')</option>
                                <option>@lang('nova-core::app.form.fields.position.options.finance')</option>
                                <option>@lang('nova-core::app.form.fields.position.options.it')</option>
                                <option>@lang('nova-core::app.form.fields.position.options.other')</option>
                            </select>
                        </div>
                    </div>
                    <div class="demo-form-group">
                        <label class="demo-form-label">
                            @lang('nova-core::app.form.fields.company.label') <span>*</span>
                        </label>
                        <input id="df_company" class="demo-input" type="text"
                               placeholder="@lang('nova-core::app.form.fields.company.placeholder')">
                    </div>
                </div>

                {{-- City + Size --}}
                <div class="demo-form-row">
                    <div class="demo-form-group">
                        <label class="demo-form-label">
                            @lang('nova-core::app.form.fields.city.label') <span>*</span>
                        </label>
                        <div class="demo-select-wrap">
                            <select id="df_city" class="demo-select">
                                <option value="" disabled selected>
                                    @lang('nova-core::app.form.fields.city.placeholder')
                                </option>
                                <option>@lang('nova-core::app.form.fields.city.options.hn')</option>
                                <option>@lang('nova-core::app.form.fields.city.options.hcm')</option>
                                <option>@lang('nova-core::app.form.fields.city.options.dn')</option>
                                <option>@lang('nova-core::app.form.fields.city.options.ct')</option>
                                <option>@lang('nova-core::app.form.fields.city.options.other')</option>
                            </select>
                        </div>
                    </div>
                    <div class="demo-form-group">
                        <label class="demo-form-label">
                            @lang('nova-core::app.form.fields.size.label') <span>*</span>
                        </label>
                        <div class="demo-select-wrap">
                            <select id="df_size" class="demo-select">
                                <option value="" disabled selected>
                                    @lang('nova-core::app.form.fields.size.placeholder')
                                </option>
                                <option>@lang('nova-core::app.form.fields.size.options.under_50')</option>
                                <option>@lang('nova-core::app.form.fields.size.options.50_200')</option>
                                <option>@lang('nova-core::app.form.fields.size.options.200_500')</option>
                                <option>@lang('nova-core::app.form.fields.size.options.500_1000')</option>
                                <option>@lang('nova-core::app.form.fields.size.options.over_1000')</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" id="demoSubmitBtn" class="demo-submit-btn">
                    @lang('nova-core::app.form.submit')
                </button>

                <div class="demo-form-note">
                    @lang('nova-core::app.form.note')
                    <a href="#">@lang('nova-core::app.form.privacy_policy')</a>
                    @lang('nova-core::app.form.note_suffix')
                </div>
            </form>
        </div>
    </div>
</div>