{{-- Modal thêm phòng ban --}}
<div class="orgchart-modal-overlay" id="modal-overlay" style="display:none;">
    <div class="orgchart-modal" id="modal-add-dept">
        <div class="orgchart-modal-header">
            <div class="orgchart-modal-title">@lang('org-chart::app.form.create_title')</div>
            <button class="orgchart-drawer-close" id="modal-close">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="orgchart-modal-body">
            <div class="orgchart-form-group">
                <label class="orgchart-form-label">@lang('org-chart::app.form.name') <span style="color:#ef4444">*</span></label>
                <input type="text" class="orgchart-form-input" id="f-name" placeholder="@lang('org-chart::app.form.name_placeholder')"/>
                <div class="orgchart-form-error" id="err-name"></div>
            </div>
            <div class="orgchart-form-row">
                <div class="orgchart-form-group">
                    <label class="orgchart-form-label">@lang('org-chart::app.form.code')</label>
                    <input type="text" class="orgchart-form-input" id="f-code" placeholder="@lang('org-chart::app.form.code_placeholder')"/>
                    <div class="orgchart-form-error" id="err-code"></div>
                </div>
                <div class="orgchart-form-group">
                    <label class="orgchart-form-label">@lang('org-chart::app.form.color')</label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input type="color" id="f-color" value="#1d4ed8" style="width:38px;height:36px;border-radius:8px;border:1px solid #e2e8f0;cursor:pointer;padding:2px;"/>
                        <span id="f-color-label" style="font-size:12px;color:#94a3b8;">#1d4ed8</span>
                    </div>
                </div>
            </div>
            <div class="orgchart-form-group">
                <label class="orgchart-form-label">@lang('org-chart::app.form.parent')</label>
                <select class="orgchart-form-select" id="f-parent">
                    <option value="">@lang('org-chart::app.form.parent_placeholder')</option>
                </select>
            </div>
            <div class="orgchart-form-group">
                <label class="orgchart-form-label">@lang('org-chart::app.form.description')</label>
                <textarea class="orgchart-form-input" id="f-description" rows="3" placeholder="@lang('org-chart::app.form.description_placeholder')"></textarea>
            </div>
        </div>
        <div class="orgchart-modal-footer">
            <button class="btn-orgchart-secondary" id="modal-cancel">@lang('org-chart::app.form.cancel')</button>
            <button class="btn-orgchart-primary" id="modal-submit">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span id="modal-submit-text">@lang('org-chart::app.form.create_submit')</span>
            </button>
        </div>
    </div>
</div>
