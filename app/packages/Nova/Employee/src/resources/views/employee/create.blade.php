@extends('nova-dashboard::layouts')

@section('title', 'Thêm nhân viên — NovaHRM')

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
                <svg viewBox="0 0 24 24"><polyline points="7 8 12 13 17 8"/></svg>
                <a href="#">Nova HRM+</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <a href="{{ route('hr.employees.index') }}">Nhân viên</a>
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                <span>Thêm mới</span>
            </div>
            <div class="emp-page-title">Thêm nhân viên mới</div>
            <div class="emp-page-subtitle">Điền đầy đủ thông tin để tạo hồ sơ nhân viên</div>
        </div>
        <div class="emp-actions">
            <a href="{{ route('hr.employees.index') }}" class="btn-emp-secondary">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Huỷ
            </a>
            <button type="submit" form="emp-create-form" class="btn-emp-primary">
                <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Lưu nhân viên
            </button>
        </div>
    </div>

    {{-- Tab navigation --}}
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

{{-- Flash errors --}}
{{-- Flash error từ controller --}}
@if(session('error'))
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-danger" data-auto-close>
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div style="font-weight:700;margin-bottom:2px">Không thể lưu nhân viên</div>
            <div style="font-size:12px">{{ session('error') }}</div>
        </div>
    </div>
</div>
@endif

{{-- Flash success --}}
@if(session('success'))
<div style="padding:14px 24px 0">
    <div class="emp-alert" style="background:#f0fdf4;border:0.5px solid #86efac;color:#15803d;display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:8px">
        <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;flex-shrink:0;margin-top:1px"><polyline points="20 6 9 17 4 12"/></svg>
        <div style="font-size:13px;font-weight:600">{{ session('success') }}</div>
    </div>
</div>
@endif

{{-- Validation errors từ Laravel Request --}}
@if($errors->any())
<div style="padding:14px 24px 0">
    <div class="emp-alert emp-alert-danger" data-auto-close>
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

<form id="emp-create-form" method="POST"
      action="{{ route('hr.employees.store') }}"
      enctype="multipart/form-data">
    @csrf

    <div class="emp-form-body">
        <div class="emp-form-main">
            {{--TAB 1: THÔNG TIN CÁ NHÂN --}}
            <div id="tab-personal" class="emp-tab-panel" style="display:flex;flex-direction:column;gap:14px">
                {{-- Họ tên --}}
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Họ tên & Giới tính</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Họ <span class="required">*</span></label>
                            <input type="text" name="first_name" class="emp-input {{ $errors->has('first_name') ? 'error' : '' }}"
                                   value="{{ old('first_name') }}" placeholder="VD: Nguyễn" required/>
                            @error('first_name') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Tên <span class="required">*</span></label>
                            <input type="text" name="last_name" class="emp-input {{ $errors->has('last_name') ? 'error' : '' }}"
                                   value="{{ old('last_name') }}" placeholder="VD: Văn An" required/>
                            @error('last_name') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Giới tính</label>
                            <select name="gender" class="emp-select">
                                <option value="">— Chọn —</option>
                                @foreach($genders as $key => $label)
                                    <option value="{{ $key }}" {{ old('gender') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày sinh</label>
                            <input type="date" name="date_of_birth" class="emp-input {{ $errors->has('date_of_birth') ? 'error' : '' }}"
                                   value="{{ old('date_of_birth') }}"
                                   max="{{ now()->subYears(18)->format('Y-m-d') }}"/>
                            @error('date_of_birth') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Nơi sinh</label>
                            <input type="text" name="place_of_birth" class="emp-input"
                                   value="{{ old('place_of_birth') }}" placeholder="VD: Hà Nội"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Quốc tịch</label>
                            <select name="nationality" class="emp-select">
                                <option value="">— Chọn quốc tịch —</option>
                                @foreach($countries as $name)
                                    <option value="{{ $name }}"
                                        {{ old('nationality', 'Việt Nam') === $name ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Dân tộc</label>
                            <input type="text" name="ethnicity" class="emp-input"
                                   value="{{ old('ethnicity') }}" placeholder="VD: Kinh"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Tôn giáo</label>
                            <input type="text" name="religion" class="emp-input"
                                   value="{{ old('religion') }}" placeholder="VD: Không"/>
                        </div>
                    </div>
                </div>

                {{-- CCCD / Hộ chiếu --}}
                <div class="emp-form-card">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:8px">
                        <div class="emp-form-card-title" style="margin-bottom:0">CCCD / Hộ chiếu</div>
                        <div style="display:flex;border:0.5px solid #cbd5e1;border-radius:6px;overflow:hidden">
                            <button type="button" id="cccd-btn-manual" onclick="switchCccdMode('manual')"
                                    style="display:flex;align-items:center;gap:6px;padding:5px 13px;font-size:11px;font-weight:600;border:none;cursor:pointer;background:#1d4ed8;color:#fff;transition:all .15s">
                                <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Nhập thủ công
                            </button>
                            <button type="button" id="cccd-btn-scan" onclick="switchCccdMode('scan')"
                                    style="display:flex;align-items:center;gap:6px;padding:5px 13px;font-size:11px;font-weight:600;border:none;cursor:pointer;background:transparent;color:#64748b;transition:all .15s">
                                <svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h1v1h-1z"/><path d="M17 14h1v1h-1z"/><path d="M14 17h1v1h-1z"/><path d="M17 17h4v4h-4z"/></svg>
                                Quét QR CCCD
                            </button>
                        </div>
                    </div>

                    {{-- PANEL QUÉT QR --}}
                    <div id="cccd-scan-panel" style="display:none;margin-bottom:16px">
                        <div style="background:#f8fafc;border:1.5px dashed #cbd5e1;border-radius:10px;padding:16px;text-align:center">

                            {{-- Camera view --}}
                            <div id="cccd-camera-wrap" style="display:none;margin-bottom:12px;position:relative">
                                <video id="cccd-video" autoplay playsinline muted
                                    style="width:100%;max-width:360px;border-radius:8px;background:#000;display:block;margin:0 auto"></video>
                                {{-- Khung ngắm --}}
                                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:180px;height:180px;pointer-events:none">
                                    <div style="position:absolute;top:0;left:0;width:24px;height:24px;border-top:3px solid #1d4ed8;border-left:3px solid #1d4ed8;border-radius:3px 0 0 0"></div>
                                    <div style="position:absolute;top:0;right:0;width:24px;height:24px;border-top:3px solid #1d4ed8;border-right:3px solid #1d4ed8;border-radius:0 3px 0 0"></div>
                                    <div style="position:absolute;bottom:0;left:0;width:24px;height:24px;border-bottom:3px solid #1d4ed8;border-left:3px solid #1d4ed8;border-radius:0 0 0 3px"></div>
                                    <div style="position:absolute;bottom:0;right:0;width:24px;height:24px;border-bottom:3px solid #1d4ed8;border-right:3px solid #1d4ed8;border-radius:0 0 3px 0"></div>
                                </div>
                                <canvas id="cccd-canvas" style="display:none"></canvas>
                            </div>

                            {{-- Trạng thái --}}
                            <div id="cccd-scan-status" style="font-size:12px;color:#64748b;margin-bottom:12px;line-height:1.5">
                                Hướng camera vào mã QR trên CCCD để tự động điền thông tin
                            </div>

                            {{-- Nút điều khiển --}}
                            <div style="display:flex;gap:8px;justify-content:center;flex-wrap:wrap">
                                <button type="button" id="cccd-start-btn" onclick="startCccdScan()"
                                        style="display:flex;align-items:center;gap:6px;padding:7px 16px;font-size:12px;font-weight:600;background:#1d4ed8;color:#fff;border:none;border-radius:6px;cursor:pointer">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3" fill="currentColor"/></svg>
                                    Mở camera
                                </button>
                                <button type="button" id="cccd-stop-btn" onclick="stopCccdScan()" style="display:none;padding:7px 16px;font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;border:0.5px solid #cbd5e1;border-radius:6px;cursor:pointer">
                                    Dừng
                                </button>
                                <button type="button" id="cccd-torch-btn" onclick="toggleTorch()"
                                        style="display:none;padding:7px 16px;font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;border:0.5px solid #cbd5e1;border-radius:6px;cursor:pointer">
                                    🔦 Bật đèn
                                </button>
                                <label style="display:flex;align-items:center;gap:6px;padding:7px 16px;font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;border:0.5px solid #cbd5e1;border-radius:6px;cursor:pointer">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Upload ảnh QR
                                    <input type="file" accept="image/*" style="display:none" onchange="scanCccdFromFile(this)"/>
                                </label>
                            </div>

                            {{-- Kết quả --}}
                            <div id="cccd-result-box" style="display:none;margin-top:14px;background:#f0fdf4;border:0.5px solid #86efac;border-radius:8px;padding:12px;text-align:left">
                                <div style="font-size:11px;font-weight:700;color:#16a34a;margin-bottom:8px;display:flex;align-items:center;gap:6px">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Quét thành công — đã điền vào form
                                </div>
                                <div id="cccd-result-text" style="font-size:11px;color:#15803d;font-family:'Courier New',monospace;line-height:1.8"></div>
                            </div>
                        </div>
                    </div>

                    {{-- PANEL NHẬP THỦ CÔNG --}}
                    <div id="cccd-manual-panel">
                        <div class="emp-form-grid emp-grid-2">
                            <div class="emp-form-group">
                                <label class="emp-form-label">Số CCCD/CMND</label>
                                <input type="text" name="national_id" id="field-national-id"
                                    class="emp-input {{ $errors->has('national_id') ? 'error' : '' }}"
                                    value="{{ old('national_id') }}" placeholder="VD: 001234567890"
                                    maxlength="12"
                                    inputmode="numeric"
                                    style="font-family:'Courier New',monospace"/>
                                <span class="emp-field-error" id="err-cccd" style="display:none"></span>
                                <span class="emp-field-hint">Đủ 12 chữ số (theo CCCD chip)</span>
                                @error('national_id') <span class="emp-field-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="emp-form-group">
                                <label class="emp-form-label">Ngày cấp</label>
                                <input type="date" name="national_id_issued_date" id="field-issued-date"
                                    class="emp-input" value="{{ old('national_id_issued_date') }}"/>
                            </div>

                            <div class="emp-form-group emp-col-full">
                                <label class="emp-form-label">Nơi cấp</label>
                                <input type="text" name="national_id_issued_place" class="emp-input"
                                    value="{{ old('national_id_issued_place') }}"
                                    placeholder="VD: Cục Cảnh sát QLHC về TTXH"/>
                            </div>

                            <div class="emp-form-group">
                                <label class="emp-form-label">Số hộ chiếu</label>
                                <input type="text" name="passport_number" id="field-passport"
                                    class="emp-input"
                                    value="{{ old('passport_number') }}" 
                                    placeholder="VD: B1234567"
                                    maxlength="20"
                                    style="font-family:'Courier New',monospace;text-transform:uppercase"/>
                                <span class="emp-field-error" id="err-passport" style="display:none"></span>
                                <span class="emp-field-hint">6–20 ký tự, chữ cái và chữ số (tự động viết hoa)</span>
                            </div>

                            <div class="emp-form-group">
                                <label class="emp-form-label">Ngày hết hạn hộ chiếu</label>
                                <input type="date" name="passport_expiry_date" class="emp-input"
                                    value="{{ old('passport_expiry_date') }}"/>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Liên hệ --}}
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Thông tin liên hệ</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Email cá nhân</label>
                            <input type="email" name="email" id="field-email"
                                class="emp-input {{ $errors->has('email') ? 'error' : '' }}"
                                value="{{ old('email') }}" placeholder="example@gmail.com"/>
                            <span class="emp-field-error" id="err-email" style="display:none"></span>
                            <span class="emp-field-hint">Chỉ chấp nhận đuôi @gmail.com</span>
                            @error('email') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Email công ty</label>
                            <input type="email" name="work_email" id="field-work-email"
                                class="emp-input {{ $errors->has('work_email') ? 'error' : '' }}"
                                value="{{ old('work_email') }}" placeholder="example@gmail.com"/>
                            <span class="emp-field-error" id="err-work-email" style="display:none"></span>
                            <span class="emp-field-hint">Chỉ chấp nhận đuôi @gmail.com</span>
                            @error('work_email') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        {{-- Số điện thoại --}}
                        <div class="emp-form-group">
                            <label class="emp-form-label">Số điện thoại</label>
                            <input type="text" name="phone" id="field-phone" class="emp-input"
                                value="{{ old('phone') }}" placeholder="0xxxxxxxxx"
                                maxlength="10"
                                inputmode="numeric"/>
                            <span class="emp-field-error" id="err-phone" style="display:none"></span>
                            <span class="emp-field-hint">Đầu số 0, đủ 10 chữ số (VD: 0912345678)</span>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">SĐT phụ</label>
                            <input type="text" name="phone_alt" id="field-phone-alt" class="emp-input"
                                value="{{ old('phone_alt') }}" placeholder="0xxxxxxxxx"
                                maxlength="10"
                                inputmode="numeric"/>
                            <span class="emp-field-error" id="err-phone-alt" style="display:none"></span>
                        </div>
                    </div>
                </div>

                {{-- Địa chỉ --}}
                <div class="emp-form-card">

                    {{-- Header + 1 toggle duy nhất --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;flex-wrap:wrap;gap:8px">
                        <div class="emp-form-card-title" style="margin-bottom:0">Địa chỉ</div>
                        <div style="display:flex;align-items:center;gap:8px">
                            <span style="font-size:11px;font-weight:600;color:#64748b">Dùng hệ thống địa chỉ:</span>
                            <div style="display:flex;border:0.5px solid #cbd5e1;border-radius:6px;overflow:hidden">
                                <button type="button" id="addr-btn-new"
                                        onclick="switchAddrVersion('new')"
                                        style="padding:5px 13px;font-size:11px;font-weight:600;border:none;cursor:pointer;background:#1d4ed8;color:#fff;transition:all .15s">
                                    ✦ Mới 2025 &nbsp;·&nbsp; 34 tỉnh
                                </button>
                                <button type="button" id="addr-btn-old"
                                        onclick="switchAddrVersion('old')"
                                        style="padding:5px 13px;font-size:11px;font-weight:600;border:none;cursor:pointer;background:transparent;color:#64748b;transition:all .15s">
                                    Cũ &nbsp;·&nbsp; 63 tỉnh
                                </button>
                            </div>
                            <span id="addr-version-badge"
                                style="font-size:10px;font-weight:600;background:#eff6ff;color:#1d4ed8;padding:2px 8px;border-radius:4px;border:0.5px solid #bfdbfe">
                                2 cấp: Tỉnh → Xã
                            </span>
                        </div>
                    </div>

                    {{-- THƯỜNG TRÚ --}}
                    <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:10px">
                        Địa chỉ thường trú
                    </div>
                    <div class="emp-form-grid emp-grid-2" style="margin-bottom:16px">

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Số nhà, tên đường</label>
                            <input type="text" name="permanent_address" class="emp-input"
                                value="{{ old('permanent_address') }}" placeholder="VD: 12 Nguyễn Huệ"/>
                        </div>

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Tỉnh / Thành phố</label>
                            <select class="emp-select addr-province-sel" name="permanent_province_name"
                                    data-prefix="permanent" onchange="onProvinceChange(this)">
                                <option value="">— Chọn tỉnh/thành —</option>
                            </select>
                            <input type="hidden" name="permanent_province" class="addr-province-val" data-prefix="permanent"/>
                        </div>

                        {{-- Quận/Huyện: chỉ hiện với bộ cũ --}}
                        <div class="emp-form-group addr-district-row" data-prefix="permanent"
                            style="display:none;grid-column:1/-1">
                            <label class="emp-form-label">Quận / Huyện</label>
                            <input type="text" name="permanent_district" class="emp-input addr-district-inp"
                                data-prefix="permanent" placeholder="Nhập quận/huyện"/>
                        </div>

                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Phường / Xã</label>
                            <select class="emp-select addr-ward-sel" name="permanent_ward_name"
                                    data-prefix="permanent" disabled onchange="onWardChange(this)">
                                <option value="">— Chọn tỉnh trước —</option>
                            </select>
                            <input type="hidden" name="permanent_ward" class="addr-ward-val" data-prefix="permanent"/>
                        </div>
                    </div>

                    <hr style="border:none;border-top:0.5px solid #e2e8f0;margin:4px 0 16px"/>

                    {{-- HIỆN TẠI --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px">
                        <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em">
                            Địa chỉ hiện tại
                        </div>
                        <label style="display:flex;align-items:center;gap:7px;cursor:pointer;font-size:12px;font-weight:600;color:#475569">
                            <input type="checkbox" id="same-address" style="accent-color:#1d4ed8;cursor:pointer"/>
                            Giống địa chỉ thường trú
                        </label>
                    </div>

                    <div id="current-address-fields">
                        <div class="emp-form-grid emp-grid-2">

                            <div class="emp-form-group emp-col-full">
                                <label class="emp-form-label">Số nhà, tên đường</label>
                                <input type="text" name="current_address" class="emp-input"
                                    value="{{ old('current_address') }}" placeholder="VD: 12 Nguyễn Huệ"/>
                            </div>

                            <div class="emp-form-group emp-col-full">
                                <label class="emp-form-label">Tỉnh / Thành phố</label>
                                <select class="emp-select addr-province-sel" name="current_province_name"
                                        data-prefix="current" onchange="onProvinceChange(this)">
                                    <option value="">— Chọn tỉnh/thành —</option>
                                </select>
                                <input type="hidden" name="current_province" class="addr-province-val" data-prefix="current"/>
                            </div>

                            <div class="emp-form-group addr-district-row" data-prefix="current"
                                style="display:none;grid-column:1/-1">
                                <label class="emp-form-label">Quận / Huyện</label>
                                <input type="text" name="current_district" class="emp-input addr-district-inp"
                                    data-prefix="current" placeholder="Nhập quận/huyện"/>
                            </div>

                            <div class="emp-form-group emp-col-full">
                                <label class="emp-form-label">Phường / Xã</label>
                                <select class="emp-select addr-ward-sel" name="current_ward_name"
                                        data-prefix="current" disabled onchange="onWardChange(this)">
                                    <option value="">— Chọn tỉnh trước —</option>
                                </select>
                                <input type="hidden" name="current_ward" class="addr-ward-val" data-prefix="current"/>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Liên hệ khẩn cấp --}}
                <div class="emp-form-card">
                    <div class="emp-form-card-title">Liên hệ khẩn cấp</div>
                    <div class="emp-form-grid emp-grid-3">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Họ tên</label>
                            <input type="text" name="emergency_contact_name" class="emp-input"
                                   value="{{ old('emergency_contact_name') }}" placeholder="Họ tên người liên hệ"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Số điện thoại</label>
                            <input type="text" name="emergency_contact_phone" id="field-emergency-phone"
                                class="emp-input"
                                value="{{ old('emergency_contact_phone') }}" 
                                placeholder="0xxxxxxxxx"
                                maxlength="10"
                                inputmode="numeric"/>
                            <span class="emp-field-error" id="err-emergency-phone" style="display:none"></span>
                            <span class="emp-field-hint">Đầu số 0, đủ 10 chữ số</span>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Quan hệ</label>
                            <input type="text" name="emergency_contact_relation" class="emp-input"
                                   value="{{ old('emergency_contact_relation') }}" placeholder="VD: Bố, Mẹ, Vợ..."/>
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

            {{-- TAB 4: LƯƠNG & TÀI CHÍNH --}}
            <div id="tab-salary" class="emp-tab-panel" style="display:none;flex-direction:column;gap:14px">

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Lương cơ bản</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Lương cơ bản</label>
                            <div style="position:relative">
                                <input type="number" name="basic_salary" class="emp-input {{ $errors->has('basic_salary') ? 'error' : '' }}"
                                       value="{{ old('basic_salary', 0) }}"
                                       min="0" step="500000" placeholder="0"
                                       style="padding-right:46px" id="salary-input"/>
                                <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:#94a3b8">VNĐ</span>
                            </div>
                            <span class="emp-field-hint" id="salary-preview">—</span>
                            @error('basic_salary') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Hình thức lương</label>
                            <select name="salary_type" class="emp-select">
                                <option value="monthly" {{ old('salary_type','monthly') === 'monthly' ? 'selected' : '' }}>Lương tháng</option>
                                <option value="daily"   {{ old('salary_type') === 'daily'   ? 'selected' : '' }}>Lương ngày</option>
                                <option value="hourly"  {{ old('salary_type') === 'hourly'  ? 'selected' : '' }}>Lương giờ</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                        <div class="emp-form-card-title" style="margin-bottom:0">Ngân hàng</div>
                        {{-- Badge trạng thái tra cứu --}}
                        <div id="bank-lookup-badge" style="display:none;font-size:11px;font-weight:600;padding:3px 10px;border-radius:20px"></div>
                    </div>

                    <div class="emp-form-grid emp-grid-2">

                        {{-- Chọn ngân hàng bằng select có search --}}
                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">Ngân hàng <span style="font-size:10px;color:#94a3b8;font-weight:500">(chọn để tra cứu)</span></label>
                            <div class="emp-autocomplete">
                                <input type="text" id="bank-search-input" class="emp-input"
                                    placeholder="Tìm ngân hàng... VD: Vietcombank, MB, Techcombank"
                                    autocomplete="off"/>
                                <input type="hidden" name="bank_name"    id="bank-name-val"  value="{{ old('bank_name') }}"/>
                                <input type="hidden" id="bank-bin-val"/>
                                <input type="hidden" id="bank-logo-val"/>
                                <div class="emp-autocomplete-dropdown" id="bank-dropdown"></div>
                            </div>
                        </div>

                        {{-- Hiển thị logo + tên ngân hàng đã chọn --}}
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

                        {{-- Số tài khoản --}}
                        <div class="emp-form-group">
                            <label class="emp-form-label">Số tài khoản</label>
                            <div style="display:flex;gap:8px">
                                <input type="text" name="bank_account" id="field-bank-account" class="emp-input"
                                    value="{{ old('bank_account') }}" placeholder="VD: 1234567890"
                                    style="font-family:'Courier New',monospace;flex:1"
                                    inputmode="numeric"/>
                                <button type="button" id="btn-lookup-bank"
                                        onclick="lookupBankAccount()"
                                        disabled
                                        style="flex-shrink:0;padding:0 14px;font-size:12px;font-weight:600;background:#1d4ed8;color:#fff;border:none;border-radius:7px;cursor:pointer;opacity:0.4;transition:all .15s;white-space:nowrap;display:flex;align-items:center;gap:6px">
                                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    Tra cứu
                                </button>
                            </div>
                            <span class="emp-field-hint" id="bank-account-hint">Chọn ngân hàng trước, sau đó nhập số tài khoản và nhấn Tra cứu</span>
                        </div>

                        {{-- Chi nhánh --}}
                        <div class="emp-form-group">
                            <label class="emp-form-label">Chi nhánh</label>
                            <input type="text" name="bank_branch" class="emp-input"
                                value="{{ old('bank_branch') }}" placeholder="VD: Hà Nội"/>
                        </div>

                        {{-- Tên chủ tài khoản — tự điền sau khi tra cứu --}}
                        <div class="emp-form-group emp-col-full">
                            <label class="emp-form-label">
                                Tên chủ tài khoản
                                <span id="bank-account-name-badge"
                                    style="display:none;font-size:9.5px;font-weight:700;background:#dcfce7;color:#16a34a;padding:1px 7px;border-radius:4px;margin-left:6px">
                                    ✓ Đã xác minh
                                </span>
                            </label>
                            <input type="text" name="bank_account_name" id="field-bank-account-name" class="emp-input"
                                value="{{ old('bank_account_name') }}" placeholder="Tự động điền sau khi tra cứu"
                                style="font-weight:600;text-transform:uppercase"/>
                        </div>
                    </div>
                </div>

                <div class="emp-form-card">
                    <div class="emp-form-card-title">Bảo hiểm & Thuế</div>
                    <div class="emp-form-grid emp-grid-2">

                        <div class="emp-form-group">
                            <label class="emp-form-label">Mã số thuế cá nhân</label>
                            <input type="text" name="tax_code" class="emp-input {{ $errors->has('tax_code') ? 'error' : '' }}"
                                   value="{{ old('tax_code') }}" placeholder="VD: 1234567890"
                                   style="font-family:'Courier New',monospace"/>
                            @error('tax_code') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Mã BHXH</label>
                            <input type="text" name="social_insurance_code" class="emp-input {{ $errors->has('social_insurance_code') ? 'error' : '' }}"
                                   value="{{ old('social_insurance_code') }}" placeholder="VD: 1234567890"
                                   style="font-family:'Courier New',monospace"/>
                            @error('social_insurance_code') <span class="emp-field-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Mã BHYT</label>
                            <input type="text" name="health_insurance_code" class="emp-input"
                                   value="{{ old('health_insurance_code') }}" placeholder="VD: HS4012..."
                                   style="font-family:'Courier New',monospace"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Nơi KCB ban đầu</label>
                            <input type="text" name="health_insurance_place" class="emp-input"
                                   value="{{ old('health_insurance_place') }}" placeholder="VD: BV Bạch Mai"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Ngày tham gia BHXH</label>
                            <input type="date" name="social_insurance_start_date" class="emp-input"
                                   value="{{ old('social_insurance_start_date') }}"/>
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
                                    <option value="{{ $key }}" {{ old('education_level') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Chuyên ngành</label>
                            <input type="text" name="education_major" class="emp-input"
                                   value="{{ old('education_major') }}" placeholder="VD: Công nghệ thông tin"/>
                        </div>

                        <div class="emp-form-group">
                            <label class="emp-form-label">Trường</label>
                            <input type="text" name="education_school" class="emp-input"
                                   value="{{ old('education_school') }}" placeholder="VD: ĐH Bách Khoa HN"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="emp-form-side">
            {{-- Avatar upload --}}
            <div class="emp-info-card">
                <div class="emp-info-card-head">
                    <div class="emp-info-card-title">Ảnh đại diện</div>
                </div>
                <div class="emp-avatar-upload">
                    <div class="emp-av-wrap">
                        <div class="emp-av-circle" id="av-preview">
                            <svg viewBox="0 0 24 24" style="width:30px;height:30px;stroke:#fff;fill:none;stroke-width:1.5">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <label class="emp-av-edit" for="avatar-input" title="Chọn ảnh">
                            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </label>
                        <input type="file" id="avatar-input" name="avatar" accept="image/*"
                               form="emp-create-form" style="display:none"/>
                    </div>
                    <div style="font-size:11px;color:#94a3b8;text-align:center;font-weight:500;line-height:1.5">
                        JPG, PNG, WEBP<br>Tối đa 2MB
                    </div>
                </div>
            </div>

            {{-- Trạng thái --}}
            <div class="emp-form-card">
                <div class="emp-form-card-title">Trạng thái</div>
                <div class="emp-form-group" style="margin-bottom:12px">
                    <label class="emp-form-label">Trạng thái nhân viên</label>
                    <select name="status" class="emp-select">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ old('status', 'active') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="emp-form-group">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;font-weight:600;color:#475569">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               style="accent-color:#1d4ed8;cursor:pointer;width:15px;height:15px"/>
                        Đang hoạt động (is_active)
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
                            <div class="emp-info-val" style="font-family:'Courier New',monospace;color:#94a3b8">
                                Tự động sinh
                            </div>
                        </div>
                    </div>
                    <div class="emp-info-row" style="padding:8px 0">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="emp-info-label">Ngày tạo</div>
                            <div class="emp-info-val">{{ now()->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress indicator --}}
            <div class="emp-form-card" style="padding:14px 16px">
                <div style="font-size:10px;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:10px">
                    Tiến độ điền form
                </div>
                <div style="display:flex;flex-direction:column;gap:6px" id="tab-progress">
                    @foreach([
                        ['tab-personal', 'Cá nhân'],
                        ['tab-work',     'Công việc'],
                        ['tab-contract', 'Hợp đồng'],
                        ['tab-salary',   'Lương & Tài chính'],
                        ['tab-education','Học vấn'],
                    ] as [$tabId, $tabLabel])
                    <div style="display:flex;align-items:center;justify-content:space-between">
                        <span style="font-size:11px;color:#64748b;font-weight:600">{{ $tabLabel }}</span>
                        <span class="emp-badge emp-badge-gray" style="font-size:9.5px" id="prog-{{ $tabId }}">—</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
    @vite(['app/packages/Nova/Employee/src/resources/js/app.js'])
    <script>
    function switchTab(tabId) {
        document.querySelectorAll('.emp-tab[data-tab]').forEach(t =>
            t.classList.toggle('active', t.dataset.tab === tabId)
        );
        document.querySelectorAll('.emp-tab-panel').forEach(p => {
            if (p.id === tabId) {
                p.style.display = 'flex';
                p.style.flexDirection = 'column';
            } else {
                p.style.display = 'none';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Tab switching 
        const tabs   = document.querySelectorAll('.emp-tab[data-tab]');
        const panels = document.querySelectorAll('.emp-tab-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                switchTab(tab.dataset.tab);
            });
        });

        // Default tab
        switchTab('tab-personal');

        // Avatar preview 
        const avatarInput = document.getElementById('avatar-input');
        const avPreview   = document.getElementById('av-preview');

        avatarInput?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                avPreview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%"/>`;
            };
            reader.readAsDataURL(file);
        });

        // Same address toggle 
        const sameAddr   = document.getElementById('same-address');
        const curFields  = document.getElementById('current-address-fields');

        sameAddr?.addEventListener('change', function () {
            if (this.checked) {
                curFields.style.display = 'none';
                // Copy values
                curFields.querySelectorAll('input').forEach(input => {
                    const permName = input.name.replace('current_', 'permanent_');
                    const permInput = document.querySelector(`[name="${permName}"]`);
                    if (permInput) input.value = permInput.value;
                });
            } else {
                curFields.style.display = 'block';
            }
        });

        // Salary format preview 
        const salaryInput   = document.getElementById('salary-input');
        const salaryPreview = document.getElementById('salary-preview');

        salaryInput?.addEventListener('input', function () {
            const val = parseInt(this.value);
            if (!val || isNaN(val)) {
                salaryPreview.textContent = '—';
                return;
            }
            salaryPreview.textContent = val.toLocaleString('vi-VN') + ' ₫';
        });

        // Autocomplete manager 
        const managerSearch   = document.getElementById('manager-search');
        const managerIdInput  = document.getElementById('manager-id-input');
        const managerDropdown = document.getElementById('manager-dropdown');

        let managerTimer;

        managerSearch?.addEventListener('input', function () {
            const q = this.value.trim();
            if (q.length < 2) {
                managerDropdown.classList.remove('open');
                return;
            }
            clearTimeout(managerTimer);
            managerTimer = setTimeout(async () => {
                try {
                    const res  = await fetch(`{{ route('hr.employees.search') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();

                    if (!data.length) {
                        managerDropdown.innerHTML = `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy</div>`;
                    } else {
                        managerDropdown.innerHTML = data.map(e => `
                            <div class="emp-autocomplete-item" data-id="${e.id}" data-name="${e.name}">
                                <img src="${e.avatar}" style="width:28px;height:28px;border-radius:50%;object-fit:cover;flex-shrink:0" onerror="this.style.display='none'"/>
                                <div>
                                    <div class="emp-autocomplete-item-name">${e.name}</div>
                                    <div class="emp-autocomplete-item-sub">${e.position || ''} ${e.department ? '· ' + e.department : ''}</div>
                                </div>
                            </div>
                        `).join('');
                    }
                    managerDropdown.classList.add('open');

                    // Click item
                    managerDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
                        item.addEventListener('click', () => {
                            managerSearch.value  = item.dataset.name;
                            managerIdInput.value = item.dataset.id;
                            managerDropdown.classList.remove('open');
                        });
                    });

                } catch (e) {
                    console.error(e);
                }
            }, 300);
        });

        // Đóng dropdown khi click ngoài
        document.addEventListener('click', e => {
            if (!e.target.closest('.emp-autocomplete')) {
                managerDropdown.classList.remove('open');
            }
        });

        // Keyboard navigation autocomplete 
        managerSearch?.addEventListener('keydown', function (e) {
            const items = managerDropdown.querySelectorAll('.emp-autocomplete-item');
            const focused = managerDropdown.querySelector('.focused');
            let idx = Array.from(items).indexOf(focused);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                focused?.classList.remove('focused');
                items[Math.min(idx + 1, items.length - 1)]?.classList.add('focused');
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                focused?.classList.remove('focused');
                items[Math.max(idx - 1, 0)]?.classList.add('focused');
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (focused) focused.click();
            } else if (e.key === 'Escape') {
                managerDropdown.classList.remove('open');
            }
        });
    });

    const addrDataNew = @json($provincesNew); 
    const addrDataOld = @json($provincesOld); 
    let currentAddrVersion = 'new';

    function switchAddrVersion(ver) {
        currentAddrVersion = ver;

        document.getElementById('addr-btn-new').style.background = ver === 'new' ? '#1d4ed8' : 'transparent';
        document.getElementById('addr-btn-new').style.color      = ver === 'new' ? '#fff'    : '#64748b';
        document.getElementById('addr-btn-old').style.background = ver === 'old' ? '#1d4ed8' : 'transparent';
        document.getElementById('addr-btn-old').style.color      = ver === 'old' ? '#fff'    : '#64748b';

        const badge = document.getElementById('addr-version-badge');
        badge.textContent  = ver === 'new' ? '2 cấp: Tỉnh → Xã' : '3 cấp: Tỉnh → Huyện → Xã';
        badge.style.background  = ver === 'new' ? '#eff6ff' : '#fefce8';
        badge.style.color       = ver === 'new' ? '#1d4ed8' : '#854d0e';
        badge.style.borderColor = ver === 'new' ? '#bfdbfe' : '#fde68a';

        // Hiện/ẩn ô Quận/Huyện
        document.querySelectorAll('.addr-district-row').forEach(el => {
            el.style.display = ver === 'old' ? '' : 'none';
        });

        // Reset + render lại cả 2
        ['permanent', 'current'].forEach(prefix => {
            resetAddr(prefix);
            renderProvinces(prefix);
        });
    }

    function renderProvinces(prefix) {
        const sel = document.querySelector(`.addr-province-sel[data-prefix="${prefix}"]`);
        if (!sel) return;
        sel.innerHTML = '<option value="">— Chọn tỉnh/thành —</option>';

        if (currentAddrVersion === 'new') {
            addrDataNew.forEach(p => {
                const o = new Option(p.FullName || p.Name, p.Name);
                o.dataset.code = p.Code;
                sel.appendChild(o);
            });
        } else {
            // bộ cũ: level1_id, name
            addrDataOld.forEach(p => {
                const o = new Option(p.name, p.name);
                o.dataset.code = p.level1_id;
                sel.appendChild(o);
            });
        }
    }

    function onProvinceChange(sel) {
        const prefix = sel.dataset.prefix;
        const opt    = sel.options[sel.selectedIndex];
        const code   = opt?.dataset?.code || '';
        const name   = opt?.value || '';

        document.querySelector(`.addr-province-val[data-prefix="${prefix}"]`).value = name;
        document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = '';

        // Reset district input
        const distInp = document.querySelector(`.addr-district-inp[data-prefix="${prefix}"]`);
        if (distInp) distInp.value = '';

        // Reset ward select
        const wardSel = document.querySelector(`.addr-ward-sel[data-prefix="${prefix}"]`);
        wardSel.innerHTML = '<option value="">— Chọn phường/xã —</option>';
        wardSel.disabled  = true;

        if (!code) return;

        if (currentAddrVersion === 'new') {
            // bộ mới: không có huyện, load xã thẳng
            const prov = addrDataNew.find(p => p.Code === code);
            (prov?.Wards || []).forEach(w => {
                const o = new Option(w.FullName || w.Name, w.Name);
                o.dataset.code = w.Code;
                wardSel.appendChild(o);
            });
            wardSel.disabled = wardSel.options.length <= 1;

        } else {
            // bộ cũ: có huyện — render select huyện trước
            const prov = addrDataOld.find(p => p.level1_id === code);
            if (!prov) return;

            // Thay ward select thành district select tạm
            const distRow = document.querySelector(`.addr-district-row[data-prefix="${prefix}"]`);
            if (distRow) {
                // Đổi input thường trú thành select huyện
                const distWrap = distRow.querySelector('.addr-district-inp');
                if (distWrap) distWrap.readOnly = false;

                // Render dropdown huyện vào wardSel tạm — thực ra ta dùng select riêng cho huyện
                // Render huyện vào select huyện
                let distSel = distRow.querySelector('select.addr-district-sel');
                if (!distSel) {
                    distSel = document.createElement('select');
                    distSel.className = 'emp-select addr-district-sel';
                    distSel.dataset.prefix = prefix;
                    distSel.style.marginTop = '6px';
                    distRow.appendChild(distSel);
                }
                distSel.innerHTML = '<option value="">— Chọn quận/huyện —</option>';
                (prov.level2s || []).forEach(d => {
                    const o = new Option(d.name, d.name);
                    o.dataset.id = d.level2_id;
                    o.dataset.districts = JSON.stringify(d.level3s || []);
                    distSel.appendChild(o);
                });

                distSel.onchange = function() {
                    const dOpt = this.options[this.selectedIndex];
                    if (distInp) distInp.value = dOpt?.value || '';

                    // Load xã của huyện vừa chọn
                    const level3s = JSON.parse(dOpt?.dataset?.districts || '[]');
                    wardSel.innerHTML = '<option value="">— Chọn phường/xã —</option>';
                    level3s.forEach(w => {
                        const o = new Option(w.name, w.name);
                        o.dataset.code = w.level3_id;
                        wardSel.appendChild(o);
                    });
                    wardSel.disabled = level3s.length === 0;
                    document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = '';
                };
            }
        }
    }

    function onWardChange(sel) {
        const prefix = sel.dataset.prefix;
        document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = sel.options[sel.selectedIndex]?.value || '';
    }

    function resetAddr(prefix) {
        const provSel = document.querySelector(`.addr-province-sel[data-prefix="${prefix}"]`);
        if (provSel) provSel.value = '';
        document.querySelector(`.addr-province-val[data-prefix="${prefix}"]`).value = '';

        const wardSel = document.querySelector(`.addr-ward-sel[data-prefix="${prefix}"]`);
        if (wardSel) { wardSel.innerHTML = '<option value="">— Chọn tỉnh trước —</option>'; wardSel.disabled = true; }
        document.querySelector(`.addr-ward-val[data-prefix="${prefix}"]`).value = '';

        const distInp = document.querySelector(`.addr-district-inp[data-prefix="${prefix}"]`);
        if (distInp) distInp.value = '';

        // Xóa select huyện động nếu có
        document.querySelectorAll(`.addr-district-sel[data-prefix="${prefix}"]`).forEach(el => el.remove());
    }

    // Init
    renderProvinces('permanent');
    renderProvinces('current');

    // Same address
    const sameAddr  = document.getElementById('same-address');
    const curFields = document.getElementById('current-address-fields');
    sameAddr?.addEventListener('change', function () {
        curFields.style.display = this.checked ? 'none' : '';
        if (this.checked) {
            document.querySelector('[name="current_address"]').value =
                document.querySelector('[name="permanent_address"]').value;
            document.querySelector('.addr-province-val[data-prefix="current"]').value =
                document.querySelector('.addr-province-val[data-prefix="permanent"]').value;
            document.querySelector('.addr-ward-val[data-prefix="current"]').value =
                document.querySelector('.addr-ward-val[data-prefix="permanent"]').value;
        }
    });

    // Validation số điện thoại 
    function validatePhone(input, errId) {
        const errEl = document.getElementById(errId);
        if (!errEl) return true;

        // Chỉ cho nhập số
        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });

        const val = input.value.trim();
        if (!val) { clearErr(input, errEl); return true; } // Không bắt buộc

        if (!/^0\d{9}$/.test(val)) {
            showErr(input, errEl,
                val.length < 10
                    ? `Cần đủ 10 chữ số (hiện ${val.length} số)`
                    : 'Số điện thoại phải bắt đầu bằng 0 và đủ 10 chữ số'
            );
            return false;
        }
        clearErr(input, errEl);
        return true;
    }

    // Validation số CCCD 
    function validateCccd(input, errId) {
        const errEl = document.getElementById(errId);
        if (!errEl) return true;

        input.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 12);
        });

        const val = input.value.trim();
        if (!val) { clearErr(input, errEl); return true; }

        if (!/^\d{12}$/.test(val)) {
            showErr(input, errEl,
                `CCCD cần đúng 12 chữ số (hiện ${val.length} số)`
            );
            return false;
        }
        clearErr(input, errEl);
        return true;
    }

    function showErr(input, errEl, msg) {
        input.classList.add('error');
        errEl.textContent = msg;
        errEl.style.display = 'block';
    }
    function clearErr(input, errEl) {
        input.classList.remove('error');
        errEl.style.display = 'none';
    }

    // Gắn real-time validation
    const phoneInput    = document.getElementById('field-phone');
    const phoneAltInput = document.getElementById('field-phone-alt');
    const cccdInput     = document.getElementById('field-national-id');

    // Chỉ cho nhập số vào các field này
    [phoneInput, phoneAltInput, cccdInput].forEach(el => {
        el?.addEventListener('input', function () {
            const maxLen = el === cccdInput ? 12 : 10;
            this.value = this.value.replace(/\D/g, '').slice(0, maxLen);
        });
    });

    phoneInput?.addEventListener('blur', () => validatePhone(phoneInput, 'err-phone'));
    phoneAltInput?.addEventListener('blur', () => validatePhone(phoneAltInput, 'err-phone-alt'));
    cccdInput?.addEventListener('blur', () => validateCccd(cccdInput, 'err-cccd'));

    // Validate trước khi submit 
    document.getElementById('emp-create-form')?.addEventListener('submit', function (e) {
        switchTab('tab-personal');
        const okPhone          = validatePhone(phoneInput,          'err-phone');
        const okPhoneAlt       = validatePhone(phoneAltInput,       'err-phone-alt');
        const okEmergencyPhone = validatePhone(emergencyPhoneInput, 'err-emergency-phone');
        const okCccd           = validateCccd(cccdInput,            'err-cccd');
        const okPassport       = validatePassport(passportInput,    'err-passport');
        const okEmail          = validateGmail(emailInput,          'err-email');          
        const okWorkEmail      = validateGmail(workEmailInput,      'err-work-email');     
        const okWorkEmail2     = validateGmail(workEmailInput2,     'err-work-email-2');   

        if (!okPhone || !okPhoneAlt || !okEmergencyPhone || !okCccd || !okPassport
            || !okEmail || !okWorkEmail || !okWorkEmail2) {
            e.preventDefault();

            // Chuyển đúng tab chứa lỗi đầu tiên
            if (!okEmail || !okWorkEmail || !okPhone || !okPhoneAlt 
                || !okEmergencyPhone || !okCccd || !okPassport) {
                document.querySelector('[data-tab="tab-personal"]')?.click();
            } else if (!okWorkEmail2) {
                document.querySelector('[data-tab="tab-work"]')?.click();
            }

            const firstErr = document.querySelector('.emp-input.error');
            firstErr?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstErr?.focus();
        }
    });

    // Validation số hộ chiếu 
    const passportInput = document.getElementById('field-passport');

    // Tự động uppercase + lọc ký tự đặc biệt khi nhập
    passportInput?.addEventListener('input', function () {
        const cursor = this.selectionStart;
        this.value = this.value
            .toUpperCase()
            .replace(/[^A-Z0-9]/g, '')  // Chỉ giữ chữ và số
            .slice(0, 20);
        // Giữ vị trí con trỏ
        this.setSelectionRange(cursor, cursor);
    });

    function validatePassport(input, errId) {
        const errEl = document.getElementById(errId);
        if (!errEl) return true;

        const val = input.value.trim();
        if (!val) { clearErr(input, errEl); return true; } // Không bắt buộc

        if (val.length < 6) {
            showErr(input, errEl, `Số hộ chiếu quá ngắn (tối thiểu 6 ký tự, hiện ${val.length})`);
            return false;
        }
        if (!/^[A-Z0-9]{6,20}$/.test(val)) {
            showErr(input, errEl, 'Số hộ chiếu chỉ được chứa chữ cái và chữ số');
            return false;
        }
        clearErr(input, errEl);
        return true;
    }

    passportInput?.addEventListener('blur', () => validatePassport(passportInput, 'err-passport'));

    // Validation số điện thoại liên hệ
    const emergencyPhoneInput = document.getElementById('field-emergency-phone');

    // Chỉ cho nhập số, giới hạn 10 ký tự
    emergencyPhoneInput?.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    emergencyPhoneInput?.addEventListener('blur', () => 
        validatePhone(emergencyPhoneInput, 'err-emergency-phone')
    );

    // Validation Email @gmail.com 
    function validateGmail(input, errId) {
        const errEl = document.getElementById(errId);
        if (!errEl) return true;

        const val = input.value.trim().toLowerCase();
        if (!val) { clearErr(input, errEl); return true; } // Không bắt buộc

        // Kiểm tra đúng format email cơ bản trước
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
            showErr(input, errEl, 'Email không đúng định dạng');
            return false;
        }

        // Kiểm tra đuôi @gmail.com
        if (!val.endsWith('@gmail.com')) {
            showErr(input, errEl, 'Email phải có đuôi @gmail.com');
            return false;
        }

        // Kiểm tra phần trước @ không rỗng và hợp lệ
        const localPart = val.split('@')[0];
        if (localPart.length < 6) {
            showErr(input, errEl, `Phần tên email quá ngắn (tối thiểu 6 ký tự, hiện ${localPart.length})`);
            return false;
        }
        if (!/^[a-z0-9._]+$/.test(localPart)) {
            showErr(input, errEl, 'Tên email chỉ được chứa chữ thường, số, dấu chấm và dấu gạch dưới');
            return false;
        }

        clearErr(input, errEl);
        return true;
    }

    // Lấy các field email
    const emailInput      = document.getElementById('field-email');
    const workEmailInput  = document.getElementById('field-work-email');
    const workEmailInput2 = document.getElementById('field-work-email-2');

    // Tự động lowercase khi nhập
    [emailInput, workEmailInput, workEmailInput2].forEach(el => {
        el?.addEventListener('input', function () {
            const cursor = this.selectionStart;
            this.value = this.value.toLowerCase().trim();
            this.setSelectionRange(cursor, cursor);
        });
    });

    // Validate khi rời field
    emailInput?.addEventListener('blur',      () => validateGmail(emailInput,      'err-email'));
    workEmailInput?.addEventListener('blur',  () => validateGmail(workEmailInput,  'err-work-email'));
    workEmailInput2?.addEventListener('blur', () => validateGmail(workEmailInput2, 'err-work-email-2'));

    // Đồng bộ 2 field work_email (tab Cá nhân ↔ tab Công việc)
    workEmailInput?.addEventListener('input', function () {
        if (workEmailInput2) workEmailInput2.value = this.value;
    });
    workEmailInput2?.addEventListener('input', function () {
        if (workEmailInput) workEmailInput.value = this.value;
    });

    let bankList = [];

    // Load danh sách ngân hàng
    async function loadBanks() {
        try {
            const res  = await fetch('{{ route("hr.bank.banks") }}');
            bankList   = await res.json();
        } catch (e) {
            console.error('Không load được danh sách ngân hàng', e);
        }
    }
    loadBanks();

    const bankSearchInput = document.getElementById('bank-search-input');
    const bankDropdown    = document.getElementById('bank-dropdown');
    const bankBinVal      = document.getElementById('bank-bin-val');
    const bankNameVal     = document.getElementById('bank-name-val');
    const btnLookup       = document.getElementById('btn-lookup-bank');
    const bankAccountInp  = document.getElementById('field-bank-account');

    // Tìm ngân hàng khi gõ
    bankSearchInput?.addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        if (!q) { bankDropdown.classList.remove('open'); return; }

        const matched = bankList.filter(b =>
            b.shortName?.toLowerCase().includes(q) ||
            b.name?.toLowerCase().includes(q) ||
            b.code?.toLowerCase().includes(q)
        ).slice(0, 8);

        if (!matched.length) {
            bankDropdown.innerHTML = `<div style="padding:12px 14px;font-size:12px;color:#94a3b8">Không tìm thấy ngân hàng</div>`;
        } else {
            bankDropdown.innerHTML = matched.map(b => `
                <div class="emp-autocomplete-item" 
                    data-bin="${b.bin}" 
                    data-name="${b.shortName}" 
                    data-fullname="${b.name}"
                    data-code="${b.code}"
                    data-logo="https://api.vietqr.io/img/${b.code}.png"
                    style="display:flex;align-items:center;gap:10px">
                    <img src="https://api.vietqr.io/img/${b.code}.png" 
                        style="width:28px;height:28px;object-fit:contain;border-radius:4px;border:0.5px solid #e2e8f0;background:#fff;padding:2px"
                        onerror="this.style.display='none'"/>
                    <div>
                        <div class="emp-autocomplete-item-name">${b.shortName}</div>
                        <div class="emp-autocomplete-item-sub">${b.name}</div>
                    </div>
                </div>
            `).join('');
        }
        bankDropdown.classList.add('open');

        // Click chọn ngân hàng
        bankDropdown.querySelectorAll('.emp-autocomplete-item').forEach(item => {
            item.addEventListener('click', () => {
                selectBank(item.dataset);
                bankDropdown.classList.remove('open');
            });
        });
    });

    function selectBank(data) {
        // Cập nhật hidden inputs
        bankBinVal.value  = data.bin;
        bankNameVal.value = data.name;

        // Ẩn search, hiện preview
        bankSearchInput.style.display = 'none';
        const preview = document.getElementById('bank-selected-preview');
        preview.style.display = 'block';
        document.getElementById('bank-logo-img').src         = data.logo;
        document.getElementById('bank-selected-name').textContent = data.name;
        document.getElementById('bank-selected-code').textContent = data.code + ' · BIN: ' + data.bin;

        // Kích hoạt nút tra cứu nếu đã có số TK
        updateLookupBtn();
    }

    function clearBankSelection() {
        bankBinVal.value  = '';
        bankNameVal.value = '';
        bankSearchInput.value = '';
        bankSearchInput.style.display = '';
        document.getElementById('bank-selected-preview').style.display = 'none';
        updateLookupBtn();
        clearBankResult();
    }

    // Kích hoạt nút Tra cứu khi có đủ ngân hàng + số TK
    bankAccountInp?.addEventListener('input', () => {
        bankAccountInp.value = bankAccountInp.value.replace(/\D/g, '').slice(0, 19);
        updateLookupBtn();
    });

    function updateLookupBtn() {
        const ready = bankBinVal.value && bankAccountInp.value.length >= 6;
        btnLookup.disabled = !ready;
        btnLookup.style.opacity = ready ? '1' : '0.4';
        btnLookup.style.cursor  = ready ? 'pointer' : 'not-allowed';
    }

    // Thực hiện tra cứu
    async function lookupBankAccount() {
        const bin    = bankBinVal.value;
        const accNum = bankAccountInp.value.trim();

        if (!bin || !accNum) return;

        // UI loading
        btnLookup.disabled = true;
        btnLookup.innerHTML = `
            <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;animation:spin 1s linear infinite">
                <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
            </svg>
            Đang tra...`;

        showBadge('loading', '⏳ Đang kiểm tra...');

        try {
            const res  = await fetch('{{ route("hr.bank.lookup") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ bin, accountNumber: accNum }),
            });
            const data = await res.json();

            if (data.success) {
                // Điền tên chủ TK
                const nameField = document.getElementById('field-bank-account-name');
                nameField.value = data.accountName;
                nameField.style.background = '#f0fdf4';
                nameField.style.borderColor = '#86efac';

                document.getElementById('bank-account-name-badge').style.display = 'inline';
                showBadge('success', '✓ Tài khoản hợp lệ');
                document.getElementById('bank-account-hint').textContent = 
                    'Tên tài khoản đã được xác minh qua VietQR';
            } else {
                clearBankResult();
                showBadge('error', '✗ ' + data.message);
            }
        } catch (e) {
            showBadge('error', '✗ Lỗi kết nối');
        } finally {
            btnLookup.disabled = false;
            btnLookup.innerHTML = `
                <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Tra cứu`;
            updateLookupBtn();
        }
    }

    function showBadge(type, text) {
        const badge = document.getElementById('bank-lookup-badge');
        badge.style.display = 'block';
        badge.textContent   = text;
        const styles = {
            loading: { bg: '#fef9c3', color: '#854d0e', border: '#fde68a' },
            success: { bg: '#dcfce7', color: '#16a34a', border: '#86efac' },
            error:   { bg: '#fee2e2', color: '#dc2626', border: '#fca5a5' },
        };
        const s = styles[type];
        badge.style.background   = s.bg;
        badge.style.color        = s.color;
        badge.style.border       = `0.5px solid ${s.border}`;
    }

    function clearBankResult() {
        const nameField = document.getElementById('field-bank-account-name');
        nameField.style.background  = '';
        nameField.style.borderColor = '';
        document.getElementById('bank-account-name-badge').style.display = 'none';
    }

    // CSS cho animation loading
    const style = document.createElement('style');
    style.textContent = `@keyframes spin { to { transform: rotate(360deg); } }`;
    document.head.appendChild(style);

    // Đóng dropdown ngân hàng khi click ngoài
    document.addEventListener('click', e => {
        if (!e.target.closest('#bank-search-input') && !e.target.closest('#bank-dropdown')) {
            bankDropdown.classList.remove('open');
        }
    });
    </script>
@endsection