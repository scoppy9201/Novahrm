{{-- TAB 2: CÔNG VIỆC --}}
<div id="tab-work" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
    <div class="emp-form-card">
        <div class="emp-form-card-title">Phân công & Tổ chức</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Phòng ban</label>
                <select name="department_id" class="emp-select {{ $errors->has('department_id') ? 'error' : '' }}"
                        id="dept-select">
                    <option value="">— Chọn phòng ban —</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                                {{ old('department_id', $preselectedDepartment?->id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Vị trí</label>
                <select name="position_id" class="emp-select {{ $errors->has('position_id') ? 'error' : '' }}"
                        id="pos-select">
                    <option value="">— Chọn vị trí —</option>
                    @foreach($positions as $pos)
                        <option value="{{ $pos->id }}" {{ old('position_id') == $pos->id ? 'selected' : '' }}>
                            {{ $pos->title }}
                        </option>
                    @endforeach
                </select>
                @error('position_id') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            {{-- Autocomplete Manager --}}
            <div class="emp-form-group emp-col-full">
                <label class="emp-form-label">Quản lý trực tiếp</label>
                <div class="emp-autocomplete">
                    <input type="text" id="manager-search" class="emp-input"
                            placeholder="Tìm tên quản lý..."
                            autocomplete="off"/>
                    <input type="hidden" name="manager_id" id="manager-id-input" value="{{ old('manager_id') }}"/>
                    <div class="emp-autocomplete-dropdown" id="manager-dropdown"></div>
                </div>
                <span class="emp-field-hint">Nhập tên để tìm kiếm quản lý trực tiếp</span>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Loại nhân viên <span class="required">*</span></label>
                <select name="employment_type" class="emp-select {{ $errors->has('employment_type') ? 'error' : '' }}">
                    @foreach($employmentTypes as $key => $label)
                        <option value="{{ $key }}" {{ old('employment_type', 'full_time') === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('employment_type') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Email công ty</label>
                <input type="email" name="work_email" id="field-work-email-2"
                    class="emp-input"
                    value="{{ old('work_email') }}" placeholder="example@gmail.com"/>
                <span class="emp-field-error" id="err-work-email-2" style="display:none"></span>
                <span class="emp-field-hint">Chỉ chấp nhận đuôi @gmail.com</span>
            </div>
        </div>
    </div>

    <div class="emp-form-card">
        <div class="emp-form-card-title">Ngày tháng công việc</div>
        <div class="emp-form-grid emp-grid-2">

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày vào làm</label>
                <input type="date" name="hire_date" class="emp-input {{ $errors->has('hire_date') ? 'error' : '' }}"
                        value="{{ old('hire_date') }}"/>
                @error('hire_date') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Ngày chính thức</label>
                <input type="date" name="official_start_date" class="emp-input"
                        value="{{ old('official_start_date') }}"/>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Bắt đầu thử việc</label>
                <input type="date" name="probation_start_date" class="emp-input"
                        value="{{ old('probation_start_date') }}"/>
            </div>

            <div class="emp-form-group">
                <label class="emp-form-label">Kết thúc thử việc</label>
                <input type="date" name="probation_end_date" class="emp-input {{ $errors->has('probation_end_date') ? 'error' : '' }}"
                        value="{{ old('probation_end_date') }}"/>
                @error('probation_end_date') <span class="emp-field-error">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="emp-form-card">
        <div class="emp-form-card-title">Ghi chú & Tiểu sử</div>
        <div class="emp-form-grid">
            <div class="emp-form-group">
                <label class="emp-form-label">Bio / Giới thiệu</label>
                <textarea name="bio" class="emp-textarea" rows="3"
                            placeholder="Giới thiệu ngắn về nhân viên...">{{ old('bio') }}</textarea>
            </div>
            <div class="emp-form-group">
                <label class="emp-form-label">Ghi chú nội bộ</label>
                <textarea name="notes" class="emp-textarea" rows="3"
                            placeholder="Ghi chú nội bộ (không hiển thị với nhân viên)...">{{ old('notes') }}</textarea>
            </div>
        </div>
    </div>
</div>