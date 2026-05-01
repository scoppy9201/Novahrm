@extends('nova-dashboard::layouts')

@section('title', 'Chỉnh sửa — ' . $employee->name . ' — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Employee/src/resources/css/app.css',
    ])
@endsection

@section('content')

<header class="emp-topbar">
    <div class="emp-topbar-row1">
        <div>
            <div class="emp-breadcrumb">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="#">Nova HRM+</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('hr.employees.index') }}">Nhân viên</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('hr.employees.show', $employee) }}">{{ $employee->name }}</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Chỉnh sửa</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
                <div class="emp-page-title">Chỉnh sửa nhân viên</div>
                <span style="font-size:11px;font-weight:700;color:#94a3b8;font-family:'Courier New',monospace;background:#f8fafc;padding:2px 9px;border-radius:5px;border:1px solid #e2e8f0">
                    {{ $employee->employee_code }}
                </span>
                @php
                    $stClass = match($employee->status) {
                        'active'          => 'emp-badge-active',
                        'probation'       => 'emp-badge-probation',
                        'on_leave'        => 'emp-badge-blue',
                        'suspended'       => 'emp-badge-danger',
                        'resigned',
                        'terminated',
                        'retired'         => 'emp-badge-inactive',
                        default           => 'emp-badge-gray',
                    };
                    $stDot = match($employee->status) {
                        'active'    => 'active',
                        'probation' => 'probation',
                        'on_leave'  => 'on_leave',
                        'suspended' => 'suspended',
                        default     => 'inactive',
                    };
                @endphp
                <span class="emp-badge {{ $stClass }}">
                    <span class="emp-status-dot {{ $stDot }}"></span>
                    {{ \Nova\Auth\Models\Employee::STATUSES[$employee->status] ?? $employee->status }}
                </span>
            </div>
            <div class="emp-page-subtitle" style="margin-top:4px">
                {{ $employee->department?->name ?? 'Chưa có phòng ban' }}
                @if($employee->position) · {{ $employee->position->title }} @endif
            </div>
        </div>
        <div class="emp-actions">
            <a href="{{ route('hr.employees.show', $employee) }}" class="btn-emp-secondary">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Huỷ
            </a>
            <button type="submit" form="emp-edit-form" class="btn-emp-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu thay đổi
            </button>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="emp-tabs">
        <a class="emp-tab active" data-tab="tab-personal" href="#tab-personal">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Cá nhân
        </a>
        <a class="emp-tab" data-tab="tab-work" href="#tab-work">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            Công việc
        </a>
        <a class="emp-tab" data-tab="tab-contract" href="#tab-contract">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Hợp đồng
        </a>
        <a class="emp-tab" data-tab="tab-salary" href="#tab-salary">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            Lương & Tài chính
        </a>
        <a class="emp-tab" data-tab="tab-education" href="#tab-education">
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            Học vấn
        </a>
    </div>
</header>

{{-- Flash --}}
@if(session('success'))
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-success" data-auto-close>
        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if($errors->any())
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-danger">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div style="font-weight:700;margin-bottom:4px">Vui lòng kiểm tra lại:</div>
            <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:2px">
                @foreach($errors->all() as $err)
                    <li>• {{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form id="emp-edit-form" method="POST"
      action="{{ route('hr.employees.update', $employee) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="emp-form-body">
        <div class="emp-form-main">
            {{-- ─TAB 1: THÔNG TIN CÁ NHÂN --}}
            <div id="tab-personal" class="emp-tab-panel" style="display:flex;flex-direction:column;gap:14px">

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Họ tên & Giới tính</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Họ <span class="required">*</span></label>
                            <input type="text" name="first_name" class="emp-input {{ $errors->has('first_name') ? 'error' : '' }}"
                                   value="{{ old('first_name', $employee->first_name) }}" placeholder="VD: Nguyễn" required/>
                            @error('first_name') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Tên <span class="required">*</span></label>
                            <input type="text" name="last_name" class="emp-input {{ $errors->has('last_name') ? 'error' : '' }}"
                                   value="{{ old('last_name', $employee->last_name) }}" placeholder="VD: Văn An" required/>
                            @error('last_name') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Giới tính</label>
                            <select name="gender" class="emp-select">
                                <option value="">— Chọn —</option>
                                @foreach($genders as $key => $label)
                                    <option value="{{ $key }}" {{ old('gender', $employee->gender) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày sinh</label>
                            <input type="date" name="date_of_birth" class="emp-input"
                                   value="{{ old('date_of_birth', $employee->date_of_birth?->format('Y-m-d')) }}"
                                   max="{{ now()->subYears(18)->format('Y-m-d') }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Nơi sinh</label>
                            <input type="text" name="place_of_birth" class="emp-input"
                                   value="{{ old('place_of_birth', $employee->place_of_birth) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Quốc tịch</label>
                            <input type="text" name="nationality" class="emp-input"
                                   value="{{ old('nationality', $employee->nationality ?? 'Việt Nam') }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Dân tộc</label>
                            <input type="text" name="ethnicity" class="emp-input"
                                   value="{{ old('ethnicity', $employee->ethnicity) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Tôn giáo</label>
                            <input type="text" name="religion" class="emp-input"
                                   value="{{ old('religion', $employee->religion) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">CCCD / Hộ chiếu</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số CCCD/CMND</label>
                            <input type="text" name="national_id" class="emp-input {{ $errors->has('national_id') ? 'error' : '' }}"
                                   value="{{ old('national_id', $employee->national_id) }}"
                                   style="font-family:'Courier New',monospace"/>
                            @error('national_id') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày cấp</label>
                            <input type="date" name="national_id_issued_date" class="emp-input"
                                   value="{{ old('national_id_issued_date', $employee->national_id_issued_date?->format('Y-m-d')) }}"/>
                        </div>

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Nơi cấp</label>
                            <input type="text" name="national_id_issued_place" class="emp-input"
                                   value="{{ old('national_id_issued_place', $employee->national_id_issued_place) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số hộ chiếu</label>
                            <input type="text" name="passport_number" class="emp-input"
                                   value="{{ old('passport_number', $employee->passport_number) }}"
                                   style="font-family:'Courier New',monospace"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày hết hạn hộ chiếu</label>
                            <input type="date" name="passport_expiry_date" class="emp-input"
                                   value="{{ old('passport_expiry_date', $employee->passport_expiry_date?->format('Y-m-d')) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Thông tin liên hệ</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Email cá nhân</label>
                            <input type="email" name="email" class="emp-input {{ $errors->has('email') ? 'error' : '' }}"
                                   value="{{ old('email', $employee->email) }}"/>
                            @error('email') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Email công ty</label>
                            <input type="email" name="work_email" class="emp-input {{ $errors->has('work_email') ? 'error' : '' }}"
                                   value="{{ old('work_email', $employee->work_email) }}"/>
                            @error('work_email') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số điện thoại</label>
                            <input type="text" name="phone" class="emp-input"
                                   value="{{ old('phone', $employee->phone) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">SĐT phụ</label>
                            <input type="text" name="phone_alt" class="emp-input"
                                   value="{{ old('phone_alt', $employee->phone_alt) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Địa chỉ</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Địa chỉ thường trú</label>
                            <input type="text" name="permanent_address" class="emp-input"
                                   value="{{ old('permanent_address', $employee->permanent_address) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Phường/Xã</label>
                            <input type="text" name="permanent_ward" class="emp-input"
                                   value="{{ old('permanent_ward', $employee->permanent_ward) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Quận/Huyện</label>
                            <input type="text" name="permanent_district" class="emp-input"
                                   value="{{ old('permanent_district', $employee->permanent_district) }}"/>
                        </div>

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Tỉnh/Thành phố</label>
                            <input type="text" name="permanent_province" class="emp-input"
                                   value="{{ old('permanent_province', $employee->permanent_province) }}"/>
                        </div>

                        <div class="emp-form-group emp-col-full" style="border-top:1px solid #f1f5f9;padding-top:12px;margin-top:4px">
                            <label class="emp-form-label" style="margin-bottom:8px">Địa chỉ hiện tại</label>
                        </div>

                        <div class="emp-form-group emp-col-full">
                            <input type="text" name="current_address" class="emp-input"
                                   value="{{ old('current_address', $employee->current_address) }}"
                                   placeholder="Số nhà, đường..."/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Phường/Xã</label>
                            <input type="text" name="current_ward" class="emp-input"
                                   value="{{ old('current_ward', $employee->current_ward) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Quận/Huyện</label>
                            <input type="text" name="current_district" class="emp-input"
                                   value="{{ old('current_district', $employee->current_district) }}"/>
                        </div>

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Tỉnh/Thành phố</label>
                            <input type="text" name="current_province" class="emp-input"
                                   value="{{ old('current_province', $employee->current_province) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Liên hệ khẩn cấp</div>
                    <div class="emp-form-grid emp-grid-3">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Họ tên</label>
                            <input type="text" name="emergency_contact_name" class="emp-input"
                                   value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số điện thoại</label>
                            <input type="text" name="emergency_contact_phone" class="emp-input"
                                   value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Quan hệ</label>
                            <input type="text" name="emergency_contact_relation" class="emp-input"
                                   value="{{ old('emergency_contact_relation', $employee->emergency_contact_relation) }}"
                                   placeholder="VD: Bố, Mẹ, Vợ..."/>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: CÔNG VIỆC --}}
            <div id="tab-work" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Phân công & Tổ chức</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Phòng ban</label>
                            <select name="department_id" class="emp-select">
                                <option value="">— Chọn phòng ban —</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Vị trí</label>
                            <select name="position_id" class="emp-select">
                                <option value="">— Chọn vị trí —</option>
                                @foreach($positions as $pos)
                                    <option value="{{ $pos->id }}" {{ old('position_id', $employee->position_id) == $pos->id ? 'selected' : '' }}>
                                        {{ $pos->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Autocomplete Manager --}}
                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Quản lý trực tiếp</label>
                            <div class="emp-autocomplete">
                                <input type="text" id="manager-search" class="emp-input"
                                       value="{{ $employee->manager?->name }}"
                                       placeholder="Tìm tên quản lý..." autocomplete="off"/>
                                <input type="hidden" name="manager_id" id="manager-id-input"
                                       value="{{ old('manager_id', $employee->manager_id) }}"/>
                                <div class="emp-autocomplete-dropdown" id="manager-dropdown"></div>
                            </div>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Loại nhân viên <span class="required">*</span></label>
                            <select name="employment_type" class="emp-select">
                                @foreach($employmentTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('employment_type', $employee->employment_type) === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Email công ty</label>
                            <input type="email" name="work_email" class="emp-input"
                                   value="{{ old('work_email', $employee->work_email) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Ngày tháng công việc</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày vào làm</label>
                            <input type="date" name="hire_date" class="emp-input"
                                   value="{{ old('hire_date', $employee->hire_date?->format('Y-m-d')) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày chính thức</label>
                            <input type="date" name="official_start_date" class="emp-input"
                                   value="{{ old('official_start_date', $employee->official_start_date?->format('Y-m-d')) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Bắt đầu thử việc</label>
                            <input type="date" name="probation_start_date" class="emp-input"
                                   value="{{ old('probation_start_date', $employee->probation_start_date?->format('Y-m-d')) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Kết thúc thử việc</label>
                            <input type="date" name="probation_end_date" class="emp-input"
                                   value="{{ old('probation_end_date', $employee->probation_end_date?->format('Y-m-d')) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Ghi chú & Tiểu sử</div>
                    <div class="emp-form-grid">
                        <div class="emp-form-group">
                            <label class="emp-form-label">Bio / Giới thiệu</label>
                            <textarea name="bio" class="emp-textarea" rows="3">{{ old('bio', $employee->bio) }}</textarea>
                        </div>
                        <div class="emp-form-group">
                            <label class="emp-form-label">Ghi chú nội bộ</label>
                            <textarea name="notes" class="emp-textarea" rows="3">{{ old('notes', $employee->notes) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 3: HỢP ĐỒNG --}}
            <div id="tab-contract" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Thông tin hợp đồng</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Loại hợp đồng</label>
                            <select name="contract_type" class="emp-select">
                                <option value="">— Chọn loại HĐ —</option>
                                @foreach($contractTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('contract_type', $employee->contract_type) === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số hợp đồng</label>
                            <input type="text" name="contract_number" class="emp-input"
                                   value="{{ old('contract_number', $employee->contract_number) }}"
                                   style="font-family:'Courier New',monospace"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày bắt đầu HĐ</label>
                            <input type="date" name="contract_start_date" class="emp-input"
                                   value="{{ old('contract_start_date', $employee->contract_start_date?->format('Y-m-d')) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày kết thúc HĐ</label>
                            <input type="date" name="contract_end_date" class="emp-input"
                                   value="{{ old('contract_end_date', $employee->contract_end_date?->format('Y-m-d')) }}"/>
                            @if($employee->is_contract_expiring)
                                <span class="emp-field-error">
                                    ⚠ Hợp đồng hết hạn {{ $employee->contract_end_date->diffForHumans() }}
                                </span>
                            @endif
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số lần gia hạn</label>
                            <input type="number" name="contract_renewal_count" class="emp-input"
                                   value="{{ old('contract_renewal_count', $employee->contract_renewal_count ?? 0) }}" min="0"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Tài liệu đính kèm</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">CV</label>
                            @if($employee->cv_path)
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px">
                                    <span class="emp-badge emp-badge-blue">
                                        <svg viewBox="0 0 24 24" style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
                                        CV đã có
                                    </span>
                                    <a href="{{ asset('storage/'.$employee->cv_path) }}" target="_blank"
                                       style="font-size:11px;color:#1d4ed8;font-weight:600">Xem →</a>
                                </div>
                            @endif
                            <input type="file" name="cv_path" class="emp-input"
                                   accept=".pdf,.doc,.docx" style="padding:6px 10px"/>
                            <span class="emp-field-hint">Để trống nếu không muốn thay đổi</span>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Chữ ký</label>
                            @if($employee->signature_path)
                                <div style="margin-bottom:8px">
                                    <img src="{{ asset('storage/'.$employee->signature_path) }}"
                                         style="height:40px;border:1px solid #e2e8f0;border-radius:6px;padding:4px"/>
                                </div>
                            @endif
                            <input type="file" name="signature_path" class="emp-input"
                                   accept="image/*" style="padding:6px 10px"/>
                            <span class="emp-field-hint">Để trống nếu không muốn thay đổi</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 4: LƯƠNG & TÀI CHÍNH --}}
            <div id="tab-salary" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Lương cơ bản</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Lương cơ bản</label>
                            <div style="position:relative">
                                <input type="number" name="basic_salary" class="emp-input"
                                       value="{{ old('basic_salary', $employee->basic_salary) }}"
                                       min="0" step="500000" style="padding-right:46px" id="salary-input"/>
                                <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:#94a3b8">VNĐ</span>
                            </div>
                            <span class="emp-field-hint" id="salary-preview">
                                @if($employee->basic_salary)
                                    {{ number_format($employee->basic_salary) }} ₫
                                @else
                                    —
                                @endif
                            </span>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Hình thức lương</label>
                            <select name="salary_type" class="emp-select">
                                <option value="monthly" {{ old('salary_type', $employee->salary_type) === 'monthly' ? 'selected' : '' }}>Lương tháng</option>
                                <option value="daily"   {{ old('salary_type', $employee->salary_type) === 'daily'   ? 'selected' : '' }}>Lương ngày</option>
                                <option value="hourly"  {{ old('salary_type', $employee->salary_type) === 'hourly'  ? 'selected' : '' }}>Lương giờ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Ngân hàng</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Tên ngân hàng</label>
                            <input type="text" name="bank_name" class="emp-input"
                                   value="{{ old('bank_name', $employee->bank_name) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số tài khoản</label>
                            <input type="text" name="bank_account" class="emp-input"
                                   value="{{ old('bank_account', $employee->bank_account) }}"
                                   style="font-family:'Courier New',monospace"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Chi nhánh</label>
                            <input type="text" name="bank_branch" class="emp-input"
                                   value="{{ old('bank_branch', $employee->bank_branch) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Tên chủ tài khoản</label>
                            <input type="text" name="bank_account_name" class="emp-input"
                                   value="{{ old('bank_account_name', $employee->bank_account_name) }}"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Bảo hiểm & Thuế</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Mã số thuế cá nhân</label>
                            <input type="text" name="tax_code" class="emp-input {{ $errors->has('tax_code') ? 'error' : '' }}"
                                   value="{{ old('tax_code', $employee->tax_code) }}"
                                   style="font-family:'Courier New',monospace"/>
                            @error('tax_code') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Mã BHXH</label>
                            <input type="text" name="social_insurance_code" class="emp-input {{ $errors->has('social_insurance_code') ? 'error' : '' }}"
                                   value="{{ old('social_insurance_code', $employee->social_insurance_code) }}"
                                   style="font-family:'Courier New',monospace"/>
                            @error('social_insurance_code') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Mã BHYT</label>
                            <input type="text" name="health_insurance_code" class="emp-input"
                                   value="{{ old('health_insurance_code', $employee->health_insurance_code) }}"
                                   style="font-family:'Courier New',monospace"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Nơi KCB ban đầu</label>
                            <input type="text" name="health_insurance_place" class="emp-input"
                                   value="{{ old('health_insurance_place', $employee->health_insurance_place) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày tham gia BHXH</label>
                            <input type="date" name="social_insurance_start_date" class="emp-input"
                                   value="{{ old('social_insurance_start_date', $employee->social_insurance_start_date?->format('Y-m-d')) }}"/>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 5: HỌC VẤN --}}
            <div id="tab-education" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Trình độ học vấn</div>
                    <div class="emp-form-grid emp-grid-3">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Trình độ</label>
                            <select name="education_level" class="emp-select">
                                <option value="">— Chọn trình độ —</option>
                                @foreach($educationLevels as $key => $label)
                                    <option value="{{ $key }}" {{ old('education_level', $employee->education_level) === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Chuyên ngành</label>
                            <input type="text" name="education_major" class="emp-input"
                                   value="{{ old('education_major', $employee->education_major) }}"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Trường</label>
                            <input type="text" name="education_school" class="emp-input"
                                   value="{{ old('education_school', $employee->education_school) }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="emp-form-side">
            {{-- Avatar --}}
            <div class="emp-info-card">
                <div class="emp-info-card-head">
                    <div class="emp-info-card-title">Ảnh đại diện</div>
                </div>
                <div class="emp-avatar-upload">
                    <div class="emp-av-wrap">
                        <div class="emp-av-circle" id="av-preview">
                            @if($employee->avatar)
                                <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}"/>
                            @else
                                {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                            @endif
                        </div>
                        <label class="emp-av-edit" for="avatar-input" title="Đổi ảnh">
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </label>
                        <input type="file" id="avatar-input" name="avatar" accept="image/*"
                               form="emp-edit-form" style="display:none"/>
                    </div>
                    <div class="emp-av-name">{{ $employee->name }}</div>
                    <div class="emp-av-code">{{ $employee->employee_code }}</div>
                    <div style="font-size:11px;color:#94a3b8;text-align:center;font-weight:500">
                        JPG, PNG, WEBP · Tối đa 2MB
                    </div>
                    @if($employee->avatar)
                        <form method="POST" action="{{ route('hr.employees.avatar.delete', $employee) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-emp-danger" style="font-size:10.5px;padding:4px 10px"
                                    onclick="return confirm('Xoá ảnh đại diện?')">
                                Xoá ảnh
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            {{-- Trạng thái --}}
            <div class="emp-form-card">
                <div class="emp-form-card-title">Trạng thái</div>
                <div class="emp-form-group" style="margin-bottom:12px">
                    <label class="emp-form-label">Trạng thái nhân viên</label>
                    <select name="status" form="emp-edit-form" class="emp-select">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $employee->status) === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="emp-form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;font-weight:600;color:#475569">
                        <input type="checkbox" name="is_active" value="1"
                               form="emp-edit-form"
                               {{ old('is_active', $employee->is_active) ? 'checked' : '' }}
                               style="accent-color:#1d4ed8;cursor:pointer;width:15px;height:15px"/>
                        Đang hoạt động
                    </label>
                </div>
            </div>

            {{-- Thông tin hệ thống --}}
            <div class="emp-form-card">
                <div class="emp-form-card-title">Hệ thống</div>
                <div style="padding:4px 0">
                    <div class="emp-info-row" style="padding:8px 0">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <div>
                            <div class="emp-info-label">Mã nhân viên</div>
                            <div class="emp-info-val" style="font-family:'Courier New',monospace">{{ $employee->employee_code }}</div>
                        </div>
                    </div>
                    <div class="emp-info-row" style="padding:8px 0">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="emp-info-label">Ngày tạo</div>
                            <div class="emp-info-val">{{ $employee->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="emp-info-row" style="padding:8px 0">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <div>
                            <div class="emp-info-label">Cập nhật lần cuối</div>
                            <div class="emp-info-val">{{ $employee->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    @if($employee->hire_date)
                    <div class="emp-info-row" style="padding:8px 0">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        <div>
                            <div class="emp-info-label">Thâm niên</div>
                            <div class="emp-info-val">{{ $employee->tenure }}</div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Vùng nguy hiểm --}}
            <div class="emp-danger-card">
                <div class="emp-danger-title">Vùng nguy hiểm</div>

                {{-- Terminate --}}
                @if($employee->is_active)
                <div class="emp-danger-row">
                    <div>
                        <div class="emp-danger-row-label">Cho nghỉ việc</div>
                        <div class="emp-danger-row-desc">Ghi nhận nhân viên nghỉ việc với lý do</div>
                    </div>
                    <button type="button" class="btn-emp-amber" id="btn-terminate"
                            style="font-size:11px;padding:5px 12px">
                        Nghỉ việc
                    </button>
                </div>
                @else
                {{-- Reinstate --}}
                <div class="emp-danger-row">
                    <div>
                        <div class="emp-danger-row-label">Khôi phục làm việc</div>
                        <div class="emp-danger-row-desc">Nhân viên quay lại làm việc</div>
                    </div>
                    <form method="POST" action="{{ route('hr.employees.reinstate', $employee) }}">
                        @csrf
                        <button type="submit" class="btn-emp-secondary" style="font-size:11px;padding:5px 12px">
                            Khôi phục
                        </button>
                    </form>
                </div>
                @endif

                {{-- Delete --}}
                <div class="emp-danger-row">
                    <div>
                        <div class="emp-danger-row-label">Xoá nhân viên</div>
                        <div class="emp-danger-row-desc">Chuyển vào thùng rác, có thể khôi phục</div>
                    </div>
                    <form method="POST" action="{{ route('hr.employees.destroy', $employee) }}"
                          id="delete-form">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-emp-danger" style="font-size:11px;padding:5px 12px"
                                onclick="return confirm('Xoá nhân viên {{ addslashes($employee->name) }}?')">
                            Xoá
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="emp-modal-overlay" id="terminate-modal">
    <div class="emp-modal">
        <div class="emp-modal-header">
            <div class="emp-modal-title">Xác nhận nghỉ việc — {{ $employee->name }}</div>
            <button type="button" class="emp-modal-close" id="close-terminate">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('hr.employees.terminate', $employee) }}">
            @csrf
            <div class="emp-modal-body">

                <div class="emp-alert emp-alert-warning" style="margin-bottom:4px">
                    <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Hành động này sẽ đánh dấu nhân viên là đã nghỉ việc.
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Loại nghỉ việc <span class="required">*</span></label>
                    <select name="status" class="emp-select" required>
                        <option value="resigned">Tự nghỉ việc</option>
                        <option value="terminated">Bị sa thải</option>
                        <option value="retired">Nghỉ hưu</option>
                        <option value="deceased">Qua đời</option>
                    </select>
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Loại hình chấm dứt <span class="required">*</span></label>
                    <select name="termination_type" class="emp-select" required>
                        @foreach(\Nova\Auth\Models\Employee::TERMINATION_TYPES as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Ngày nghỉ việc <span class="required">*</span></label>
                    <input type="date" name="termination_date" class="emp-input"
                           value="{{ now()->format('Y-m-d') }}" required/>
                </div>

                <div class="emp-form-group">
                    <label class="emp-form-label">Lý do</label>
                    <textarea name="termination_reason" class="emp-textarea" rows="3"
                              placeholder="Mô tả lý do nghỉ việc..."></textarea>
                </div>

            </div>

            <div class="emp-modal-footer">
                <button type="button" class="btn-emp-secondary" id="cancel-terminate">Huỷ</button>
                <button type="submit" class="btn-emp-danger">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Xác nhận nghỉ việc
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    @vite(['app/packages/Nova/Employee/src/resources/js/app.js'])
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Tab switching 
        const tabs   = document.querySelectorAll('.emp-tab[data-tab]');
        const panels = document.querySelectorAll('.emp-tab-panel');

        function switchTab(tabId) {
            tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tabId));
            panels.forEach(p => {
                p.style.display = p.id === tabId ? 'flex' : 'none';
                if (p.id === tabId) p.style.flexDirection = 'column';
            });
        }

        tabs.forEach(tab => tab.addEventListener('click', e => {
            e.preventDefault();
            switchTab(tab.dataset.tab);
        }));

        switchTab('tab-personal');

        // Avatar preview 
        document.getElementById('avatar-input')?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('av-preview').innerHTML =
                    `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%"/>`;
            };
            reader.readAsDataURL(file);
        });

        // Salary preview 
        document.getElementById('salary-input')?.addEventListener('input', function () {
            const val = parseInt(this.value);
            document.getElementById('salary-preview').textContent =
                val && !isNaN(val) ? val.toLocaleString('vi-VN') + ' ₫' : '—';
        });

        // Autocomplete manager 
        const managerSearch   = document.getElementById('manager-search');
        const managerIdInput  = document.getElementById('manager-id-input');
        const managerDropdown = document.getElementById('manager-dropdown');
        let managerTimer;

        managerSearch?.addEventListener('input', function () {
            const q = this.value.trim();
            if (q.length < 2) { managerDropdown.classList.remove('open'); return; }
            clearTimeout(managerTimer);
            managerTimer = setTimeout(async () => {
                try {
                    const res  = await fetch(`{{ route('hr.employees.search') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    managerDropdown.innerHTML = data.length
                        ? data.map(e => `
                            <div class="emp-autocomplete-item" data-id="${e.id}" data-name="${e.name}">
                                <img src="${e.avatar}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0" onerror="this.style.display='none'"/>
                                <div>
                                    <div class="emp-autocomplete-item-name">${e.name}</div>
                                    <div class="emp-autocomplete-item-sub">${e.position || ''} ${e.department ? '· '+e.department : ''}</div>
                                </div>
                            </div>`).join('')
                        : `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy</div>`;

                    managerDropdown.classList.add('open');
                    managerDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
                        item.addEventListener('click', () => {
                            managerSearch.value  = item.dataset.name;
                            managerIdInput.value = item.dataset.id;
                            managerDropdown.classList.remove('open');
                        });
                    });
                } catch(e) { console.error(e); }
            }, 300);
        });

        document.addEventListener('click', e => {
            if (!e.target.closest('.emp-autocomplete')) managerDropdown.classList.remove('open');
        });

        // Terminate modal 
        const modal          = document.getElementById('terminate-modal');
        const btnTerminate   = document.getElementById('btn-terminate');
        const btnClose       = document.getElementById('close-terminate');
        const btnCancel      = document.getElementById('cancel-terminate');

        btnTerminate?.addEventListener('click', () => modal.classList.add('open'));
        btnClose?.addEventListener('click',     () => modal.classList.remove('open'));
        btnCancel?.addEventListener('click',    () => modal.classList.remove('open'));

        modal?.addEventListener('click', e => {
            if (e.target === modal) modal.classList.remove('open');
        });

        // Flash auto close 
        document.querySelectorAll('[data-auto-close]').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity 0.4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4000);
        });

    });
    </script>
@endsection