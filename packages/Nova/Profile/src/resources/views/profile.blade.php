@extends('nova-dashboard::layouts')

@section('title', 'Tài khoản của tôi — NovaHRM')

@section('styles')
    @vite([
        'packages/Nova/Dashboard/src/resources/css/app.css',
        'packages/Nova/Profile/src/resources/css/app.css',
        'packages/Nova/Profile/src/resources/js/app.js',
    ])
@endsection

@section('content')
    <header class="profile-topbar">
        <div class="profile-topbar-row1">
            <div>
                <div class="profile-breadcrumb">
                    <a href="{{ route('dashboard') }}">
                        @lang('nova-profile::app.dashboard')
                    </a>
                    <svg viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                    <span>
                        @lang('nova-profile::app.my_account')
                    </span>
                </div>
                <div class="profile-page-title">
                    @lang('nova-profile::app.my_account')
                </div>
            </div>

            <div class="profile-actions">
                <a href="{{ route('dashboard') }}"
                class="btn-profile-cancel">
                    @lang('nova-profile::app.cancel')
                </a>
                <button type="submit"
                        form="profile-form"
                        class="btn-profile-save">
                    <svg viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    @lang('nova-profile::app.save_changes')
                </button>
            </div>
        </div>

        <div class="profile-topbar-tabs">
            <div class="profile-tab active" data-tab="ho-so">
                @lang('nova-profile::app.profile')
            </div>

            <div class="profile-tab" data-tab="email">
                @lang('nova-profile::app.email_settings')
            </div>

            <div class="profile-tab" data-tab="bao-mat">
                @lang('nova-profile::app.security')
            </div>
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
                    @lang('nova-profile::app.active')
                </div>
            </div>

            <div class="profile-meta-list">
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <div>
                        <div class="profile-meta-label">
                            @lang('nova-profile::app.department')
                        </div>

                        <div class="profile-meta-val">
                            {{ Auth::user()->department ?? __('nova-profile::app.none') }}
                        </div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    <div>
                        <div class="profile-meta-label">
                            @lang('nova-profile::app.office')
                        </div>

                        <div class="profile-meta-val">
                            {{ Auth::user()->office ?? __('nova-profile::app.none') }}
                        </div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <div>
                        <div class="profile-meta-label">@lang('nova-profile::app.hire_date')</div>
                        <div class="profile-meta-val">
                            {{ Auth::user()->hire_date ? Auth::user()->hire_date->format('d/m/Y') : __('nova-profile::app.none') }}
                        </div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <div>
                        <div class="profile-meta-label">@lang('nova-profile::app.direct_manager')</div>
                        <div class="profile-meta-val">
                            {{ Auth::user()->manager->name ?? __('nova-profile::app.none') }}
                        </div>
                    </div>
                </div>
                <div class="profile-meta-item">
                    <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.58 3.32 2 2 0 0 1 3.55 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 6 6l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <div>
                        <div class="profile-meta-label">@lang('nova-profile::app.phone')</div>
                        <div class="profile-meta-val">
                            {{ Auth::user()->phone ?? __('nova-profile::app.none') }}
                        </div>
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
                        <div class="profile-form-card-title">@lang('nova-profile::app.basic_information')</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group">
                                <label class="profile-form-label" for="first_name">@lang('nova-profile::app.first_name') *</label>
                                <input class="profile-input" type="text" id="first_name" name="first_name"
                                    value="{{ old('first_name', Auth::user()->first_name) }}"
                                    placeholder="@lang('nova-profile::app.enter_first_name')" required
                                    oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ỹ\s]/g, '')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="last_name">@lang('nova-profile::app.last_name') *</label>
                                <input class="profile-input" type="text" id="last_name" name="last_name"
                                    value="{{ old('last_name', Auth::user()->last_name) }}"
                                    placeholder="@lang('nova-profile::app.enter_last_name')" required
                                    oninput="this.value = this.value.replace(/[^a-zA-ZÀ-ỹ\s]/g, '')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="language">@lang('nova-profile::app.language')</label>
                                <select class="profile-select" id="language" name="language">
                                    <option value="vi" {{ old('language', Auth::user()->language) === 'vi' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.vietnamese')
                                    </option>
                                    <option value="en" {{ old('language', Auth::user()->language) === 'en' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.english')
                                    </option>
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="phone">@lang('nova-profile::app.phone')</label>
                                <input class="profile-input" type="text" id="phone" name="phone"
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    placeholder="@lang('nova-profile::app.phone_placeholder')"
                                    pattern="^(\+84|0)\d{9}$"
                                    maxlength="12"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g, '')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="date_of_birth">@lang('nova-profile::app.date_of_birth')</label>
                                <input class="profile-input" type="date" id="date_of_birth" name="date_of_birth"
                                    value="{{ old('date_of_birth', Auth::user()->date_of_birth 
                                        ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('Y-m-d') 
                                        : '') }}"
                                    max="{{ now()->subYears(18)->format('Y-m-d') }}"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="gender">@lang('nova-profile::app.gender')</label>
                                <select class="profile-select" id="gender" name="gender">
                                    <option value="male" {{ old('gender', Auth::user()->gender) === 'male' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.male')
                                    </option>
                                    <option value="female" {{ old('gender', Auth::user()->gender) === 'female' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.female')
                                    </option>
                                    <option value="other" {{ old('gender', Auth::user()->gender) === 'other' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.other')
                                    </option>
                                </select>
                            </div>

                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label" for="address">@lang('nova-profile::app.address')</label>
                                <input class="profile-input" type="text" id="address" name="address"
                                    value="{{ old('address', Auth::user()->address) }}"
                                    placeholder="@lang('nova-profile::app.enter_address')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="hire_date">@lang('nova-profile::app.hire_date')</label>
                                <input class="profile-input" type="date" id="hire_date" name="hire_date"
                                    value="{{ old('hire_date', Auth::user()->hire_date 
                                        ? \Carbon\Carbon::parse(Auth::user()->hire_date)->format('Y-m-d') 
                                        : '') }}"/>
                            </div>
                        </div>
                    </div>

                    <div class="profile-form-card">
                        <div class="profile-form-card-title">@lang('nova-profile::app.work_information')</div>
                        <div class="profile-form-grid profile-grid-3">
                            <div class="profile-form-group">
                                <label class="profile-form-label" for="job_title">@lang('nova-profile::app.job_title')</label>
                                <input class="profile-input" type="text" id="job_title" name="job_title"
                                    value="{{ old('job_title', Auth::user()->job_title) }}"
                                    placeholder="@lang('nova-profile::app.enter_job_title')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="occupation">@lang('nova-profile::app.occupation')</label>
                                <input class="profile-input" type="text" id="occupation" name="occupation"
                                    value="{{ old('occupation', Auth::user()->occupation) }}"
                                    placeholder="@lang('nova-profile::app.enter_occupation')"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="department">@lang('nova-profile::app.department_area')</label>
                                <select class="profile-select" id="department" name="department">
                                    <option value="">@lang('nova-profile::app.select_option')</option>
                                    @foreach($departments ?? [] as $dept)
                                        <option value="{{ $dept->id }}" {{ old('department', Auth::user()->department_id) == $dept->id ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="office">@lang('nova-profile::app.office')</label>
                                <select class="profile-select" id="office" name="office">
                                    <option value="">@lang('nova-profile::app.select_option')</option>
                                    @foreach($offices ?? [] as $office)
                                        <option value="{{ $office->id }}" {{ old('office', Auth::user()->office_id) == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="position">@lang('nova-profile::app.position')</label>
                                <select class="profile-select" id="position" name="position">
                                    <option value="">@lang('nova-profile::app.select_option')</option>
                                    @foreach($positions ?? [] as $pos)
                                        <option value="{{ $pos->id }}" {{ old('position', Auth::user()->position_id) == $pos->id ? 'selected' : '' }}>
                                            {{ $pos->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="manager_id">@lang('nova-profile::app.direct_manager')</label>
                                <select class="profile-select" id="manager_id" name="manager_id">
                                    <option value="">@lang('nova-profile::app.no_manager')</option>
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
                        <div class="profile-form-card-title">@lang('nova-profile::app.contact_additional_information')</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group">
                                <label class="profile-form-label" for="email_work">@lang('nova-profile::app.work_email')</label>
                                <input class="profile-input" type="email" id="email_work" name="email"
                                    value="{{ old('email', Auth::user()->email) }}"
                                    readonly
                                    style="opacity: 0.6; cursor: not-allowed; background: var(--color-surface-alt, #f5f5f5);"
                                    required/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="email_personal">@lang('nova-profile::app.personal_email')</label>
                                <input class="profile-input" type="email" id="email_personal" name="email_personal"
                                    value="{{ old('email_personal', Auth::user()->email_personal) }}"
                                    placeholder="@lang('nova-profile::app.personal_email_placeholder')"
                                    pattern="^[^@]+@gmail\.com$"
                                    title="@lang('nova-profile::app.personal_email_title')"/>
                            </div>

                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label" for="bio">@lang('nova-profile::app.bio')</label>
                                <textarea class="profile-textarea" id="bio" name="bio"
                                        placeholder="@lang('nova-profile::app.bio_placeholder')">{{ old('bio', Auth::user()->bio) }}</textarea>
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
                        <div class="profile-form-card-title">@lang('nova-profile::app.email_notification_settings')</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label">@lang('nova-profile::app.receive_attendance_notifications')</label>
                                <select class="profile-select" name="notif_attendance">
                                    <option value="all" {{ optional($employee->notificationPreference)->notif_attendance === 'all' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.all')
                                    </option>
                                    <option value="daily" {{ optional($employee->notificationPreference)->notif_attendance === 'daily' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.daily')
                                    </option>
                                    <option value="none" {{ optional($employee->notificationPreference)->notif_attendance === 'none' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.turn_off')
                                    </option>
                                </select>
                            </div>

                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label">@lang('nova-profile::app.receive_payroll_notifications')</label>
                                <select class="profile-select" name="notif_payroll">
                                    <option value="monthly" {{ optional($employee->notificationPreference)->notif_payroll === 'monthly' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.monthly')
                                    </option>
                                    <option value="none" {{ optional($employee->notificationPreference)->notif_payroll === 'none' ? 'selected' : '' }}>
                                        @lang('nova-profile::app.turn_off')
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top:16px">
                            <button type="submit" class="btn-profile-save">
                                @lang('nova-profile::app.save_settings')
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="profile-tab-panel" id="panel-bao-mat">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="profile-form-card">
                        <div class="profile-form-card-title">@lang('nova-profile::app.change_password')</div>
                        <div class="profile-form-grid profile-grid-2">
                            <div class="profile-form-group profile-col-full">
                                <label class="profile-form-label" for="current_password">
                                    @lang('nova-profile::app.current_password')
                                </label>
                                <input class="profile-input" type="password" id="current_password" name="current_password" placeholder="••••••••"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="password">
                                    @lang('nova-profile::app.new_password')
                                </label>
                                <input class="profile-input" type="password" id="password" name="password" placeholder="••••••••"/>
                            </div>

                            <div class="profile-form-group">
                                <label class="profile-form-label" for="password_confirmation">
                                    @lang('nova-profile::app.confirm_password')
                                </label>
                                <input class="profile-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••"/>
                            </div>
                        </div>

                        <div style="margin-top:16px">
                            <button type="submit" class="btn-profile-save">
                                @lang('nova-profile::app.update_password')
                            </button>
                        </div>
                    </div>
                </form>

                <div class="profile-danger-zone" style="margin-top:14px">
                    <div class="profile-danger-title">@lang('nova-profile::app.danger_zone')</div>

                    <div class="profile-danger-row">
                        <div>
                            <div class="profile-danger-row-label">
                                @lang('nova-profile::app.suspend_account')
                            </div>
                            <div class="profile-danger-row-desc">
                                @lang('nova-profile::app.suspend_account_desc')
                            </div>
                        </div>
                        <button type="button" class="btn-profile-danger" id="btn-suspend-account">
                            @lang('nova-profile::app.suspend')
                        </button>
                    </div>

                    <div class="profile-danger-row">
                        <div>
                            <div class="profile-danger-row-label">
                                @lang('nova-profile::app.delete_account')
                            </div>
                            <div class="profile-danger-row-desc">
                                @lang('nova-profile::app.delete_account_desc')
                            </div>
                        </div>
                        <button type="button" class="btn-profile-danger" id="btn-delete-account">
                            @lang('nova-profile::app.delete_account')
                        </button>
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

