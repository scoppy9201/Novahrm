{{-- TAB 3: HỢP ĐỒNG - Sau này sẽ chuyển thành hợp đồng builder cho phép soạn thảo tự động--}}
<div id="tab-contract" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
    <div class="emp-form-card">
        <div class="emp-form-card-title">Thông tin hợp đồng</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Loại hợp đồng</label>
                <select name="contract_type" class="emp-select">
                    <option value="">— Chọn loại HĐ —</option>
                    @foreach($contractTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('contract_type') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Số hợp đồng</label>
                <input type="text" name="contract_number" class="emp-input"
                        value="{{ old('contract_number') }}" placeholder="VD: HĐ-2024-001"
                        style="font-family:'Courier New',monospace"/>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày bắt đầu HĐ</label>
                <input type="date" name="contract_start_date" class="emp-input {{ $errors->has('contract_start_date') ? 'error' : '' }}"
                        value="{{ old('contract_start_date') }}"/>
                @error('contract_start_date') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày kết thúc HĐ</label>
                <input type="date" name="contract_end_date" class="emp-input {{ $errors->has('contract_end_date') ? 'error' : '' }}"
                        value="{{ old('contract_end_date') }}"/>
                @error('contract_end_date') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Số lần gia hạn</label>
                <input type="number" name="contract_renewal_count" class="emp-input"
                        value="{{ old('contract_renewal_count', 0) }}" min="0"/>
            </div>
        </div>
    </div>

    <div class="emp-form-card">
        <div class="emp-form-card-title">Tài liệu đính kèm</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Upload CV</label>
                <input type="file" name="cv_path" class="emp-input"
                        accept=".pdf,.doc,.docx"
                        style="padding:6px 10px"/>
                <span class="emp-field-hint">PDF, DOC, DOCX — tối đa 5MB</span>
                @error('cv_path') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Upload chữ ký</label>
                <input type="file" name="signature_path" class="emp-input"
                        accept="image/*"
                        style="padding:6px 10px"/>
                <span class="emp-field-hint">JPG, PNG — tối đa 2MB</span>
            </div>
        </div>
    </div>
</div>