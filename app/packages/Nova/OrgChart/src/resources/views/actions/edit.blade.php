{{-- Modal edit phòng ban --}}
<div class="orgchart-modal-overlay" id="modal-edit-overlay" style="display:none;">
    <div class="orgchart-modal">
        <div class="orgchart-modal-header">
            <div class="orgchart-modal-title">Chỉnh sửa phòng ban</div>
            <button class="orgchart-drawer-close" id="modal-edit-close">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="orgchart-modal-body">
            <input type="hidden" id="ef-id"/>
            <div class="orgchart-form-group">
                <label class="orgchart-form-label">Tên phòng ban <span style="color:#ef4444">*</span></label>
                <input type="text" class="orgchart-form-input" id="ef-name"/>
                <div class="orgchart-form-error" id="ef-err-name"></div>
            </div>
            <div class="orgchart-form-row">
                <div class="orgchart-form-group">
                    <label class="orgchart-form-label">Mã phòng ban</label>
                    <input type="text" class="orgchart-form-input" id="ef-code"/>
                    <div class="orgchart-form-error" id="ef-err-code"></div>
                </div>
                <div class="orgchart-form-group">
                    <label class="orgchart-form-label">Màu sắc</label>
                    <div style="display:flex; gap:8px; align-items:center;">
                        <input type="color" id="ef-color" style="width:38px;height:36px;border-radius:8px;border:1px solid #e2e8f0;cursor:pointer;padding:2px;"/>
                        <span id="ef-color-label" style="font-size:12px;color:#94a3b8;"></span>
                    </div>
                </div>
            </div>
            <div class="orgchart-form-group">
                <label class="orgchart-form-label">Phòng ban cha</label>
                <select class="orgchart-form-select" id="ef-parent">
                    <option value="">— Không có (cấp cao nhất) —</option>
                </select>
            </div>
            <div class="orgchart-form-group">
                <label class="orgchart-form-label">Mô tả</label>
                <textarea class="orgchart-form-input" id="ef-description" rows="3"></textarea>
            </div>
        </div>
        <div class="orgchart-modal-footer">
            <button class="btn-orgchart-secondary" id="modal-edit-cancel">Hủy</button>
            <button class="btn-orgchart-primary" id="modal-edit-submit">
                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                <span id="modal-edit-submit-text">Lưu thay đổi</span>
            </button>
        </div>
    </div>
</div>