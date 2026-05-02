<div id="tab-personal" class="emp-tab-panel" style="display:none">
    <div style="padding:22px 24px;display:flex;flex-direction:column;gap:14px">

        {{-- Thông tin cơ bản --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Thông tin cơ bản</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">

                <div>
                    <div class="emp-info-label">Họ và tên</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->name }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Giới tính</div>
                    <div class="emp-info-val" style="margin-top:3px">
                        {{ \Nova\Auth\Models\Employee::GENDERS[$employee->gender] ?? '—' }}
                    </div>
                </div>
                <div>
                    <div class="emp-info-label">Ngày sinh</div>
                    <div class="emp-info-val" style="margin-top:3px">
                        {{ $employee->date_of_birth?->format('d/m/Y') ?? '—' }}
                        @if($employee->age) <span style="color:#94a3b8;font-size:11px">({{ $employee->age }} tuổi)</span> @endif
                    </div>
                </div>
                <div>
                    <div class="emp-info-label">Nơi sinh</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->place_of_birth ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Quốc tịch</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->nationality ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Dân tộc</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->ethnicity ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Tôn giáo</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->religion ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- CCCD / Hộ chiếu --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">CCCD / Hộ chiếu</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
                <div>
                    <div class="emp-info-label">Số CCCD/CMND</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->national_id ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Ngày cấp</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->national_id_issued_date?->format('d/m/Y') ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Nơi cấp</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->national_id_issued_place ?? '—' }}</div>
                </div>
                @if($employee->passport_number)
                <div>
                    <div class="emp-info-label">Số hộ chiếu</div>
                    <div class="emp-info-val" style="margin-top:3px;font-family:'Courier New',monospace">{{ $employee->passport_number }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Hết hạn hộ chiếu</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->passport_expiry_date?->format('d/m/Y') ?? '—' }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Địa chỉ --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Địa chỉ</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:1fr 1fr;gap:20px">
                <div>
                    <div class="emp-info-label" style="margin-bottom:8px">Địa chỉ thường trú</div>
                    <div class="emp-info-val">{{ $employee->permanent_address ?? '—' }}</div>
                    @if($employee->permanent_ward || $employee->permanent_district)
                        <div style="font-size:11.5px;color:#64748b;margin-top:3px">
                            {{ collect([$employee->permanent_ward, $employee->permanent_district, $employee->permanent_province])->filter()->join(', ') }}
                        </div>
                    @endif
                </div>
                <div>
                    <div class="emp-info-label" style="margin-bottom:8px">Địa chỉ hiện tại</div>
                    <div class="emp-info-val">{{ $employee->current_address ?? '—' }}</div>
                    @if($employee->current_ward || $employee->current_district)
                        <div style="font-size:11.5px;color:#64748b;margin-top:3px">
                            {{ collect([$employee->current_ward, $employee->current_district, $employee->current_province])->filter()->join(', ') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Liên hệ & Khẩn cấp --}}
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Liên hệ khẩn cấp</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
                <div>
                    <div class="emp-info-label">Họ tên</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->emergency_contact_name ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Số điện thoại</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->emergency_contact_phone ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Quan hệ</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->emergency_contact_relation ?? '—' }}</div>
                </div>
            </div>
        </div>

        {{-- Học vấn --}}
        @if($employee->education_level || $employee->education_school)
        <div class="emp-info-card">
            <div class="emp-info-card-head">
                <div class="emp-info-card-title">Học vấn</div>
            </div>
            <div style="padding:16px 18px;display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
                <div>
                    <div class="emp-info-label">Trình độ</div>
                    <div class="emp-info-val" style="margin-top:3px">
                        {{ \Nova\Auth\Models\Employee::EDUCATION_LEVELS[$employee->education_level] ?? '—' }}
                    </div>
                </div>
                <div>
                    <div class="emp-info-label">Chuyên ngành</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->education_major ?? '—' }}</div>
                </div>
                <div>
                    <div class="emp-info-label">Trường</div>
                    <div class="emp-info-val" style="margin-top:3px">{{ $employee->education_school ?? '—' }}</div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>