<div class="emp-form-side">

    {{-- AVATAR --}}
    <div class="emp-info-card">
        <div class="emp-info-card-head">
            <div class="emp-info-card-title">Ảnh đại diện</div>
        </div>
        <div class="emp-avatar-upload">
            <div class="emp-av-wrap">
                <div class="emp-av-circle" id="av-preview">
                    @if($employee->avatar ?? false)
                        <img src="{{ $employee->avatar_url }}" alt="{{ $employee->name }}"/>
                    @elseif($employee->first_name ?? false)
                        {{ strtoupper(substr($employee->first_name,0,1).substr($employee->last_name,0,1)) }}
                    @else
                        <svg viewBox="0 0 24 24" style="width:30px;height:30px;stroke:#fff;fill:none;stroke-width:1.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    @endif
                </div>
                <label class="emp-av-edit" for="avatar-input" title="Đổi ảnh">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </label>
                <input type="file" id="avatar-input" name="avatar" accept="image/*"
                       form="{{ isset($employee->id) ? 'emp-edit-form' : 'emp-create-form' }}"
                       style="display:none"/>
            </div>
            @if($employee->name ?? false)
                <div class="emp-av-name">{{ $employee->name }}</div>
                <div class="emp-av-code">{{ $employee->employee_code }}</div>
            @endif
            <div style="font-size:11px;color:#94a3b8;text-align:center;font-weight:500;line-height:1.5">
                JPG, PNG, WEBP<br>Tối đa 2MB
            </div>
            @if($employee->avatar ?? false)
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

    {{-- TRẠNG THÁI --}}
    <div class="emp-form-card">
        <div class="emp-form-card-title">Trạng thái</div>
        <div class="emp-form-group" style="margin-bottom:12px">
            <label class="emp-form-label">Trạng thái nhân viên</label>
            <select name="status" class="emp-select" form="{{ isset($employee->id) ? 'emp-edit-form' : 'emp-create-form' }}">
                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ old('status', $employee->status ?? 'active') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="emp-form-group">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:12px;font-weight:600;color:#475569">
                <input type="checkbox" name="is_active" value="1"
                       form="{{ isset($employee->id) ? 'emp-edit-form' : 'emp-create-form' }}"
                       {{ old('is_active', $employee->is_active ?? true) ? 'checked' : '' }}
                       style="accent-color:#1d4ed8;cursor:pointer;width:15px;height:15px"/>
                Đang hoạt động
            </label>
        </div>
    </div>

    {{-- THÔNG TIN HỆ THỐNG --}}
    <div class="emp-form-card">
        <div class="emp-form-card-title">Hệ thống</div>
        <div style="padding:4px 0">
            <div class="emp-info-row" style="padding:8px 0">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <div>
                    <div class="emp-info-label">Mã nhân viên</div>
                    <div class="emp-info-val" style="font-family:'Courier New',monospace;{{ isset($employee->id) ? '' : 'color:#94a3b8' }}">
                        {{ $employee->employee_code ?? 'Tự động sinh' }}
                    </div>
                </div>
            </div>
            <div class="emp-info-row" style="padding:8px 0">
                <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <div>
                    <div class="emp-info-label">Ngày tạo</div>
                    <div class="emp-info-val">
                        {{ isset($employee->created_at) ? $employee->created_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}
                    </div>
                </div>
            </div>
            @if(isset($employee->updated_at))
            <div class="emp-info-row" style="padding:8px 0">
                <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                <div>
                    <div class="emp-info-label">Cập nhật lần cuối</div>
                    <div class="emp-info-val">{{ $employee->updated_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            @endif
            @if($employee->hire_date ?? false)
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

    {{-- PROGRESS (chỉ hiện khi create) --}}
    @if(!isset($employee->id))
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
    @endif

    {{-- VÙNG NGUY HIỂM (chỉ hiện khi edit) --}}
    @if(isset($employee->id))
    <div class="emp-danger-card">
        <div class="emp-danger-title">Vùng nguy hiểm</div>

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

        <div class="emp-danger-row">
            <div>
                <div class="emp-danger-row-label">Xoá nhân viên</div>
                <div class="emp-danger-row-desc">Chuyển vào thùng rác, có thể khôi phục</div>
            </div>
            <form method="POST" action="{{ route('hr.employees.destroy', $employee) }}" id="delete-form">
                @csrf @method('DELETE')
                <button type="submit" class="btn-emp-danger" style="font-size:11px;padding:5px 12px"
                        onclick="return confirm('Xoá nhân viên {{ addslashes($employee->name) }}?')">
                    Xoá
                </button>
            </form>
        </div>
    </div>
    @endif
</div>