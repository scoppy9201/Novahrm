{{-- TAB 4: LƯƠNG & TÀI CHÍNH --}}
<div id="tab-salary" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">

    {{-- LƯƠNG CƠ BẢN --}}
    <div class="emp-form-card">
        <div class="emp-form-card-title">Lương cơ bản</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Lương cơ bản</label>
                <div style="position:relative">
                    <input type="number" name="basic_salary" id="salary-input"
                           class="emp-input {{ $errors->has('basic_salary') ? 'error' : '' }}"
                           value="{{ old('basic_salary', $employee->basic_salary ?? 0) }}"
                           min="0" step="500000" placeholder="0"
                           style="padding-right:46px"/>
                    <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:#94a3b8">VNĐ</span>
                </div>
                <span class="emp-field-hint" id="salary-preview">
                    @if($employee->basic_salary ?? false)
                        {{ number_format($employee->basic_salary) }} ₫
                    @else
                        —
                    @endif
                </span>
                @error('basic_salary') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Hình thức lương</label>
                <select name="salary_type" class="emp-select">
                    <option value="monthly" {{ old('salary_type', $employee->salary_type ?? 'monthly') === 'monthly' ? 'selected' : '' }}>Lương tháng</option>
                    <option value="daily"   {{ old('salary_type', $employee->salary_type ?? '') === 'daily'   ? 'selected' : '' }}>Lương ngày</option>
                    <option value="hourly"  {{ old('salary_type', $employee->salary_type ?? '') === 'hourly'  ? 'selected' : '' }}>Lương giờ</option>
                </select>
            </div>
        </div>
    </div>

    {{-- NGÂN HÀNG --}}
    <div class="emp-form-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <div class="emp-form-card-title" style="margin-bottom:0">Ngân hàng</div>
            <div id="bank-lookup-badge" style="display:none;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px"></div>
        </div>

        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group emp-col-full">
                <label class="emp-form-label">Ngân hàng <span style="font-size:10px;color:#94a3b8;font-weight:500">(chọn để tra cứu)</span></label>
                <div class="emp-autocomplete">
                    <input type="text" id="bank-search-input" class="emp-input"
                           placeholder="Tìm ngân hàng... VD: Vietcombank, MB, Techcombank"
                           autocomplete="off"/>
                    <input type="hidden" name="bank_name" id="bank-name-val" value="{{ old('bank_name', $employee->bank_name ?? '') }}"/>
                    <input type="hidden" id="bank-bin-val"/>
                    <input type="hidden" id="bank-logo-val"/>
                    <div class="emp-autocomplete-dropdown" id="bank-dropdown"></div>
                </div>
            </div>

            <div id="bank-selected-preview" style="display:none;grid-column:1/-1">
                <div style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:#f8fafc;border:0.5px solid #e2e8f0;border-radius:8px">
                    <img id="bank-logo-img" src="" alt="" style="width:36px;height:36px;object-fit:contain;border-radius:6px;border:0.5px solid #e2e8f0;background:#fff;padding:3px"/>
                    <div>
                        <div id="bank-selected-name" style="font-size:13px;font-weight:700;color:#1e293b"></div>
                        <div id="bank-selected-code" style="font-size:11px;color:#64748b"></div>
                    </div>
                    <button type="button" onclick="clearBankSelection()"
                            style="margin-left:auto;padding:4px 10px;font-size:11px;font-weight:600;background:#f1f5f9;color:#64748b;border:0.5px solid #cbd5e1;border-radius:5px;cursor:pointer">
                        Đổi
                    </button>
                </div>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Số tài khoản</label>
                <div style="display:flex;gap:8px">
                    <input type="text" name="bank_account" id="field-bank-account" class="emp-input"
                           value="{{ old('bank_account', $employee->bank_account ?? '') }}"
                           placeholder="VD: 1234567890"
                           style="font-family:'Courier New',monospace;flex:1"
                           inputmode="numeric"/>
                    <button type="button" id="btn-lookup-bank" onclick="lookupBankAccount()" disabled
                            style="flex-shrink:0;padding:0 14px;font-size:12px;font-weight:600;background:#1d4ed8;color:#fff;border:none;border-radius:7px;cursor:pointer;opacity:0.4;transition:all .15s;white-space:nowrap;display:flex;align-items:center;gap:6px">
                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Tra cứu
                    </button>
                </div>
                <span class="emp-field-hint" id="bank-account-hint">Chọn ngân hàng trước, sau đó nhập số tài khoản và nhấn Tra cứu</span>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Chi nhánh</label>
                <input type="text" name="bank_branch" class="emp-input"
                       value="{{ old('bank_branch', $employee->bank_branch ?? '') }}"
                       placeholder="VD: Hà Nội"/>
            </div>

            <div class="emp-form-group emp-col-full">
                <label class="emp-form-label">
                    Tên chủ tài khoản
                    <span id="bank-account-name-badge"
                          style="display:none;font-size:9.5px;font-weight:700;background:#dcfce7;color:#16a34a;padding:1px 7px;border-radius:4px;margin-left:6px">
                        ✓ Đã xác minh
                    </span>
                </label>
                <input type="text" name="bank_account_name" id="field-bank-account-name" class="emp-input"
                       value="{{ old('bank_account_name', $employee->bank_account_name ?? '') }}"
                       placeholder="Tự động điền sau khi tra cứu"
                       style="font-weight:600;text-transform:uppercase"/>
            </div>
        </div>
    </div>

    {{-- BẢO HIỂM & THUẾ --}}
    <div class="emp-form-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <div class="emp-form-card-title" style="margin-bottom:0">Bảo hiểm & Thuế</div>
            <div id="tax-lookup-badge" style="display:none;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px"></div>
        </div>

        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group emp-col-full">
                <label class="emp-form-label">Mã số thuế cá nhân</label>
                <div style="display:flex;gap:8px">
                    <input type="text" name="tax_code" id="field-tax-code"
                           class="emp-input {{ $errors->has('tax_code') ? 'error' : '' }}"
                           value="{{ old('tax_code', $employee->tax_code ?? '') }}"
                           placeholder="VD: 0123456789"
                           style="font-family:'Courier New',monospace;flex:1"
                           maxlength="14" inputmode="numeric"/>
                    <button type="button" id="btn-lookup-tax" onclick="lookupTaxCode()" disabled
                            style="flex-shrink:0;padding:0 14px;font-size:12px;font-weight:600;background:#1d4ed8;color:#fff;border:none;border-radius:7px;cursor:pointer;opacity:0.4;transition:all .15s;white-space:nowrap;display:flex;align-items:center;gap:6px">
                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        Tra cứu MST
                    </button>
                </div>
                <span class="emp-field-hint" id="tax-code-hint">Nhập MST rồi nhấn Tra cứu để tự động điền thông tin</span>
                @error('tax_code') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div id="tax-result-box" style="display:none;grid-column:1/-1">
                <div style="background:#f0fdf4;border:0.5px solid #86efac;border-radius:10px;padding:14px 16px">
                    <div style="font-size:11px;font-weight:700;color:#16a34a;margin-bottom:10px;display:flex;align-items:center;gap:6px">
                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Tìm thấy thông tin MST
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px 20px;font-size:12px">
                        <div><span style="color:#64748b;font-weight:600">Họ tên / Tên:</span> <span id="tax-res-name" style="font-weight:700;color:#1e293b"></span></div>
                        <div><span style="color:#64748b;font-weight:600">Loại:</span> <span id="tax-res-type" style="color:#1e293b"></span></div>
                        <div style="grid-column:1/-1"><span style="color:#64748b;font-weight:600">Địa chỉ:</span> <span id="tax-res-address" style="color:#1e293b"></span></div>
                        <div><span style="color:#64748b;font-weight:600">Cơ quan thuế:</span> <span id="tax-res-dept" style="color:#1e293b"></span></div>
                        <div><span style="color:#64748b;font-weight:600">Trạng thái:</span> <span id="tax-res-status" style="font-weight:600"></span></div>
                    </div>
                    <div id="tax-multi-wrap" style="display:none;margin-top:12px;border-top:0.5px solid #bbf7d0;padding-top:10px">
                        <div style="font-size:11px;font-weight:700;color:#15803d;margin-bottom:6px">Tìm thấy nhiều kết quả — chọn đúng:</div>
                        <div id="tax-multi-list" style="display:flex;flex-direction:column;gap:6px"></div>
                    </div>
                </div>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Mã BHXH</label>
                <input type="text" name="social_insurance_code"
                       class="emp-input {{ $errors->has('social_insurance_code') ? 'error' : '' }}"
                       value="{{ old('social_insurance_code', $employee->social_insurance_code ?? '') }}"
                       placeholder="VD: 1234567890"
                       style="font-family:'Courier New',monospace"/>
                @error('social_insurance_code') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Mã BHYT</label>
                <input type="text" name="health_insurance_code" class="emp-input"
                       value="{{ old('health_insurance_code', $employee->health_insurance_code ?? '') }}"
                       placeholder="VD: HS4012..."
                       style="font-family:'Courier New',monospace"/>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Nơi KCB ban đầu</label>
                <input type="text" name="health_insurance_place" class="emp-input"
                       value="{{ old('health_insurance_place', $employee->health_insurance_place ?? '') }}"
                       placeholder="VD: BV Bạch Mai"/>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày tham gia BHXH</label>
                <input type="date" name="social_insurance_start_date" class="emp-input"
                       value="{{ old('social_insurance_start_date', $employee->social_insurance_start_date?->format('Y-m-d') ?? '') }}"/>
            </div>
        </div>
    </div>
</div>