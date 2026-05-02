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