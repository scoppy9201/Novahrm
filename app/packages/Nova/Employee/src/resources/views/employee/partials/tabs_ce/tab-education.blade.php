{{-- TAB 5: HỌC VẤN --}}
<div id="tab-education" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
    <div class="emp-form-card">
        <div class="emp-form-card-title">Trình độ học vấn</div>
            <div class="emp-form-grid emp-grid-3">
            {{-- TRÌNH ĐỘ --}}
            <div class="emp-form-group">
                <label class="emp-form-label">
                    Trình độ
                    <span id="level-badge" style="display:none;font-size:9.5px;font-weight:700;background:#dcfce7;color:#16a34a;padding:1px 7px;border-radius:4px;margin-left:6px">✓ Đã chọn</span>
                </label>
                <input type="hidden" name="education_level" id="level-val" value="{{ old('education_level') }}"/>
                <div class="emp-autocomplete">
                    <input type="text" id="level-search" class="emp-input emp-select"
                        placeholder="— Chọn trình độ —"
                        autocomplete="off" readonly
                        style="cursor:pointer"
                        onclick="toggleLevelDropdown()"/>
                    <div class="emp-autocomplete-dropdown" id="level-dropdown"></div>
                </div>
                <div id="level-selected-preview" style="display:none;margin-top:6px">
                    <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px">
                        <div style="flex:1;min-width:0">
                            <div id="level-selected-name" style="font-size:13px;font-weight:700;color:#1e293b"></div>
                        </div>
                        <button type="button" onclick="clearLevel()"
                                style="flex-shrink:0;padding:4px 10px;font-size:11px;font-weight:600;background:#f1f5f9;color:#64748b;border:0.5px solid #cbd5e1;border-radius:5px;cursor:pointer">
                            Đổi
                        </button>
                    </div>
                </div>
            </div>

            {{-- CHUYÊN NGÀNH --}}
            <div class="emp-form-group">
                <label class="emp-form-label">
                    Chuyên ngành
                    <span id="major-badge" style="display:none;font-size:9.5px;font-weight:700;background:#dcfce7;color:#16a34a;padding:1px 7px;border-radius:4px;margin-left:6px">✓ Đã chọn</span>
                </label>
                <input type="hidden" name="education_major" id="major-val" value="{{ old('education_major') }}"/>
                <div class="emp-autocomplete">
                    <input type="text" id="major-search" class="emp-input"
                        placeholder="Tìm chuyên ngành... VD: Kế toán, CNTT"
                        autocomplete="off"/>
                    <div class="emp-autocomplete-dropdown" id="major-dropdown"></div>
                </div>
                <div id="major-selected-preview" style="display:none;margin-top:6px">
                    <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px">
                        <div style="flex:1;min-width:0">
                            <div id="major-selected-name" style="font-size:13px;font-weight:700;color:#1e293b"></div>
                            <div id="major-selected-cat"  style="font-size:11px;color:#64748b"></div>
                            <div id="major-selected-code" style="font-size:10px;color:#94a3b8;font-family:'Courier New',monospace"></div>
                        </div>
                        <button type="button" onclick="clearMajor()"
                                style="flex-shrink:0;padding:4px 10px;font-size:11px;font-weight:600;background:#f1f5f9;color:#64748b;border:0.5px solid #cbd5e1;border-radius:5px;cursor:pointer">
                            Đổi
                        </button>
                    </div>
                </div>
                <span class="emp-field-hint">Nhập tên để tìm trong danh sách ngành đào tạo</span>
            </div>

            {{-- TRƯỜNG --}}
            <div class="emp-form-group">
                <label class="emp-form-label">
                    Trường
                    <span id="univ-badge" style="display:none;font-size:9.5px;font-weight:700;background:#dcfce7;color:#16a34a;padding:1px 7px;border-radius:4px;margin-left:6px">✓ Đã chọn</span>
                </label>
                <input type="hidden" name="education_school" id="univ-val" value="{{ old('education_school') }}"/>
                <div class="emp-autocomplete">
                    <input type="text" id="univ-search" class="emp-input"
                        placeholder="Tìm trường... VD: Bách Khoa, FPT"
                        autocomplete="off"/>
                    <div class="emp-autocomplete-dropdown" id="univ-dropdown"></div>
                </div>
                <div id="univ-selected-preview" style="display:none;margin-top:6px">
                    <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px">
                        <div style="flex:1;min-width:0">
                            <div id="univ-selected-name" style="font-size:13px;font-weight:700;color:#1e293b"></div>
                            <div id="univ-selected-meta" style="font-size:11px;color:#64748b"></div>
                        </div>
                        <button type="button" onclick="clearUniv()"
                                style="flex-shrink:0;padding:4px 10px;font-size:11px;font-weight:600;background:#f1f5f9;color:#64748b;border:0.5px solid #cbd5e1;border-radius:5px;cursor:pointer">
                            Đổi
                        </button>
                    </div>
                </div>
                <span class="emp-field-hint">Nhập tên trường ĐH, CĐ, THCN...</span>
            </div>
        </div>
    </div>
</div>