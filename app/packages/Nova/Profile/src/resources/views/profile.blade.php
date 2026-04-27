@extends('nova-dashboard::layouts')

@section('title', 'Tài khoản của tôi — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Profile/src/resources/css/app.css',
        'app/packages/Nova/Profile/src/resources/js/app.js',
    ])
@endsection

@section('content')
    <header class="profile-topbar">
        <div class="profile-topbar-row1">
            <div>
                <div class="profile-breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>Tài khoản của tôi</span>
                </div>
                <div class="profile-page-title">Tài khoản của tôi</div>
            </div>
            <div class="profile-actions">
                <a href="{{ route('dashboard') }}" class="btn-profile-cancel">Huỷ</a>
                <button type="submit" form="profile-form" class="btn-profile-save">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Lưu thay đổi
                </button>
            </div>
        </div>

        <div class="profile-topbar-tabs">
            <div class="profile-tab active" data-tab="ho-so">Hồ sơ</div>
            <div class="profile-tab" data-tab="email">Cài đặt email</div>
            <div class="profile-tab" data-tab="bao-mat">Bảo mật</div>
        </div>
    </header>

    <div class="profile-body">
        <aside class="profile-side">
            <div class="profile-avatar-block">
                <div class="profile-av-wrap">
                    <div class="profile-av-circle" id="av-preview">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                alt="avatar" 
                                style="width:100%;height:100%;object-fit:cover;border-radius:50%;"/>
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        @endif
                    </div>
                    <label class="profile-av-edit" for="avatar-input" title="Đổi ảnh">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </label>
                    <input type="file" id="avatar-input" accept="image/*" style="display:none" form="profile-form" name="avatar"/>
                </div>
                <div class="profile-av-name">{{ Auth::user()->name }}</div>
                <div class="profile-av-role">{{ Auth::user()->role ?? 'Quản trị viên' }}</div>
                <div class="profile-av-id">{{ Auth::user()->employee_code ?? 'NNV-000' }}</div>
                <div class="profile-status-pill">
                    <span class="profile-status-dot"></span>
                    Đang hoạt động
                </div>
            </div>

            <div class="profile-meta-list">
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <div>
                        <div class="profile-meta-label">Phòng ban</div>
                        <div class="profile-meta-val">{{ Auth::user()->department ?? '—' }}</div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <div>
                        <div class="profile-meta-label">Văn phòng</div>
                        <div class="profile-meta-val">{{ Auth::user()->office ?? '—' }}</div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div>
                        <div class="profile-meta-label">Ngày vào làm</div>
                        <div class="profile-meta-val">{{ Auth::user()->hire_date ? Auth::user()->hire_date->format('d/m/Y') : '—' }}</div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div>
                        <div class="profile-meta-label">Quản lý trực tiếp</div>
                        <div class="profile-meta-val">{{ Auth::user()->manager->name ?? '—' }}</div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.58 3.32 2 2 0 0 1 3.55 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <div>
                        <div class="profile-meta-label">Điện thoại</div>
                        <div class="profile-meta-val">{{ Auth::user()->phone ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </aside>

        <div class="profile-main">
            <div class="profile-tab-panel active" id="panel-ho-so">
                <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="profile-form-card">
                        <div class="profile-form-card-title">Thông tin cơ bản</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group">
                                <label class="profile-form-label" for="first_name">Họ *</label>
                                <input class="profile-input" type="text" id="first_name" name="first_name"
                                    value="{{ old('first_name', Auth::user()->first_name) }}"
                                    placeholder="Nhập họ..." required
                                    oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ỹ\s]/g, '')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="last_name">Tên *</label>
                                <input class="profile-input" type="text" id="last_name" name="last_name"
                                    value="{{ old('last_name', Auth::user()->last_name) }}"
                                    placeholder="Nhập tên..." required
                                    oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ỹ\s]/g, '')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="language">Ngôn ngữ</label>
                                <select class="profile-select" id="language" name="language">
                                    <option value="vi" {{ old('language', Auth::user()->language) === 'vi' ? 'selected' : '' }}>Tiếng Việt</option>
                                    <option value="en" {{ old('language', Auth::user()->language) === 'en' ? 'selected' : '' }}>English</option>
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="phone">Số điện thoại</label>
                                <input class="profile-input" type="text" id="phone" name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    placeholder="0xxxxxxxxx hoặc +84xxxxxxxxx"
                                    pattern="^(\+84|0)\d{9}$"
                                    maxlength="12"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g, '')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="date_of_birth">Ngày sinh</label>
                                <input class="profile-input" type="date" id="date_of_birth" name="date_of_birth"
                                    value="{{ old('date_of_birth', Auth::user()->date_of_birth 
                                        ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('Y-m-d') 
                                        : '') }}"
                                    max="{{ now()->subYears(18)->format('Y-m-d') }}"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="gender">Giới tính</label>
                                <select class="profile-select" id="gender" name="gender">
                                    <option value="male" {{ old('gender', Auth::user()->gender) === 'male' ? 'selected' : '' }}>Nam</option>
                                    <option value="female" {{ old('gender', Auth::user()->gender) === 'female' ? 'selected' : '' }}>Nữ</option>
                                    <option value="other" {{ old('gender', Auth::user()->gender) === 'other' ? 'selected' : '' }}>Khác</option>
                                </select>
                            </div>

                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label" for="address">Địa chỉ</label>
                                <input class="profile-input" type="text" id="address" name="address"
                                       value="{{ old('address', Auth::user()->address) }}"
                                       placeholder="Nhập địa chỉ..."/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="hire_date">Ngày vào làm</label>
                                <input class="profile-input" type="date" id="hire_date" name="hire_date"
                                    value="{{ old('hire_date', Auth::user()->hire_date 
                                        ? \Carbon\Carbon::parse(Auth::user()->hire_date)->format('Y-m-d') 
                                        : '') }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="profile-form-card">
                        <div class="profile-form-card-title">Thông tin công việc</div>
                        <div class="profile-form-grid profile-grid-3">
                            <div class="profile-form-group">
                                <label class="profile-form-label" for="job_title">Chức danh</label>
                                <input class="profile-input" type="text" id="job_title" name="job_title"
                                       value="{{ old('job_title', Auth::user()->job_title) }}"
                                       placeholder="Nhập chức danh..."/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="occupation">Nghề nghiệp</label>
                                <input class="profile-input" type="text" id="occupation" name="occupation"
                                       value="{{ old('occupation', Auth::user()->occupation) }}"
                                       placeholder="Nhập nghề nghiệp..."/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="department">Khu vực / Phòng ban</label>
                                <select class="profile-select" id="department" name="department">
                                    <option value="">— Chọn —</option>
                                    @foreach($departments ?? [] as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department', Auth::user()->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="office">Văn phòng</label>
                                <select class="profile-select" id="office" name="office">
                                    <option value="">— Chọn —</option>
                                    @foreach($offices ?? [] as $office)
                                        <option value="{{ $office->id }}" {{ old('office', Auth::user()->office_id) == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="position">Vị trí</label>
                                <select class="profile-select" id="position" name="position">
                                    <option value="">— Chọn —</option>
                                    @foreach($positions ?? [] as $pos)
                                        <option value="{{ $pos->id }}" {{ old('position', Auth::user()->position_id) == $pos->id ? 'selected' : '' }}>
                                            {{ $pos->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="manager_id">Quản lý trực tiếp</label>
                                <select class="profile-select" id="manager_id" name="manager_id">
                                    <option value="">— Không có —</option>
                                    @foreach($managers ?? [] as $manager)
                                        <option value="{{ $manager->id }}" {{ old('manager_id', Auth::user()->manager_id) == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="profile-form-card">
                        <div class="profile-form-card-title">Thông tin liên hệ & bổ sung</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group">
                                <label class="profile-form-label" for="email_work">Email nội bộ</label>
                                <input class="profile-input" type="email" id="email_work" name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    readonly
                                    style="opacity: 0.6; cursor: not-allowed; background: var(--color-surface-alt, #f5f5f5);"
                                    required/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="email_personal">Email cá nhân</label>
                                <input class="profile-input" type="email" id="email_personal" name="email_personal"
                                    value="{{ old('email_personal', Auth::user()->email_personal) }}"
                                    placeholder="example@gmail.com"
                                    pattern="^[^@]+@gmail\.com$"
                                    title="Email phải có đuôi @gmail.com"/>
                            </div>

                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label" for="bio">Giới thiệu bản thân</label>
                                <textarea class="profile-textarea" id="bio" name="bio"
                                          placeholder="Viết vài dòng giới thiệu về bản thân...">{{ old('bio', Auth::user()->bio) }}</textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="profile-tab-panel" id="panel-email">
                <form method="POST" action="{{ route('profile.notifications') }}">
                    @csrf
                    @method('PUT')
                    <div class="profile-form-card">
                        <div class="profile-form-card-title">Cài đặt thông báo email</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label">Nhận thông báo chấm công</label>
                                <select class="profile-select" name="notif_attendance">
                                    <option value="all"   {{ optional($employee->notificationPreference)->notif_attendance === 'all'   ? 'selected' : '' }}>Tất cả</option>
                                    <option value="daily" {{ optional($employee->notificationPreference)->notif_attendance === 'daily' ? 'selected' : '' }}>Hàng ngày</option>
                                    <option value="none"  {{ optional($employee->notificationPreference)->notif_attendance === 'none'  ? 'selected' : '' }}>Tắt</option>
                                </select>
                            </div>

                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label">Nhận thông báo lương</label>
                                <select class="profile-select" name="notif_payroll">
                                    <option value="monthly" {{ optional($employee->notificationPreference)->notif_payroll === 'monthly' ? 'selected' : '' }}>Hàng tháng</option>
                                    <option value="none"    {{ optional($employee->notificationPreference)->notif_payroll === 'none'    ? 'selected' : '' }}>Tắt</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top:16px">
                            <button type="submit" class="btn-profile-save">Lưu cài đặt</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="profile-tab-panel" id="panel-bao-mat">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="profile-form-card">
                        <div class="profile-form-card-title">Đổi mật khẩu</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label" for="current_password">Mật khẩu hiện tại</label>
                                <input class="profile-input" type="password" id="current_password" name="current_password" placeholder="••••••••"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="password">Mật khẩu mới</label>
                                <input class="profile-input" type="password" id="password" name="password" placeholder="••••••••"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="password_confirmation">Xác nhận mật khẩu</label>
                                <input class="profile-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"/>
                            </div>
                        </div>

                        <div style="margin-top:16px">
                            <button type="submit" class="btn-profile-save">Cập nhật mật khẩu</button>
                        </div>
                    </div>
                </form>

                <div class="profile-danger-zone" style="margin-top:14px">
                    <div class="profile-danger-title">Vùng nguy hiểm</div>

                    <div class="profile-danger-row">
                        <div>
                            <div class="profile-danger-row-label">Đình chỉ tài khoản</div>
                            <div class="profile-danger-row-desc">Tạm thời vô hiệu hoá quyền truy cập của tài khoản này</div>
                        </div>
                        <button type="button" class="btn-profile-danger" id="btn-suspend-account">Đình chỉ</button>
                    </div>

                    <div class="profile-danger-row">
                        <div>
                            <div class="profile-danger-row-label">Xoá tài khoản</div>
                            <div class="profile-danger-row-desc">Hành động này không thể hoàn tác. Toàn bộ dữ liệu sẽ bị xoá vĩnh viễn</div>
                        </div>
                        <button type="button" class="btn-profile-danger" id="btn-delete-account">Xoá tài khoản</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        window.__profileSuccess = @json(session('success'));
        window.__profileErrors = @json($errors->all());
    </script>
@endsection
