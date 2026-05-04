@extends('nova-dashboard::layouts')

@section('title', __('nova-department::app.positions.create_page_title'))

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Department/src/resources/css/app.css',
    ])
@endsection

@section('content')
    <header class="dept-topbar">
        <div class="dept-topbar-row1">
            <div>
                <div class="dept-breadcrumb">
                    <a href="{{ route('dashboard') }}">@lang('nova-department::app.common.dashboard')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('hr.positions.index') }}">@lang('nova-department::app.common.positions')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>@lang('nova-department::app.positions.create_breadcrumb')</span>
                </div>
                <div class="dept-page-title">@lang('nova-department::app.positions.create_heading')</div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.positions.index') }}" class="btn-dept-secondary">@lang('nova-department::app.common.cancel')</a>
                <button type="submit" form="pos-form" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    @lang('nova-department::app.positions.save_button')
                </button>
            </div>
        </div>
    </header>

    <div class="dept-form-body">
        {{-- Main --}}
        <div class="dept-form-main">
            @if($errors->any())
                <div class="dept-alert dept-alert-error">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>
                        <div style="font-weight:700;margin-bottom:4px">@lang('nova-department::app.validation.heading')</div>
                        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:2px">
                            @foreach($errors->all() as $err)
                                <li>• {{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form id="pos-form" method="POST" action="{{ route('hr.positions.store') }}">
                @csrf

                {{-- Nếu vào từ trang phòng ban --}}
                @if($selectedDepartmentId)
                    <input type="hidden" name="from_department" value="1">
                @endif

                {{-- Thông tin cơ bản --}}
                <div class="dept-form-card">
                    <div class="dept-form-card-title">@lang('nova-department::app.positions.basic_info')</div>
                    <div class="dept-form-grid dept-grid-2">

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="title">
                                @lang('nova-department::app.positions.name_label') <span class="required">*</span>
                            </label>
                            <input type="text" id="title" name="title"
                                   class="dept-input {{ $errors->has('title') ? 'error' : '' }}"
                                   value="{{ old('title') }}"
                                   placeholder="@lang('nova-department::app.positions.name_placeholder')" required/>
                            @error('title')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="code">
                                @lang('nova-department::app.positions.code_label') <span class="required">*</span>
                            </label>
                            <input type="text" id="code" name="code"
                                   class="dept-input {{ $errors->has('code') ? 'error' : '' }}"
                                   value="{{ old('code') }}"
                                   placeholder="@lang('nova-department::app.positions.code_placeholder')"
                                   style="font-family:'Courier New',monospace" required/>
                            @error('code')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group dept-col-full">
                            <label class="dept-form-label" for="description">@lang('nova-department::app.common.description')</label>
                            <textarea id="description" name="description"
                                      class="dept-textarea {{ $errors->has('description') ? 'error' : '' }}"
                                      placeholder="@lang('nova-department::app.positions.description_placeholder')">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Phân loại --}}
                <div class="dept-form-card">
                    <div class="dept-form-card-title">@lang('nova-department::app.positions.classification')</div>
                    <div class="dept-form-grid dept-grid-2">

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="department_id">
                                @lang('nova-department::app.positions.department_label') <span class="required">*</span>
                            </label>
                            <select id="department_id" name="department_id"
                                    class="dept-select {{ $errors->has('department_id') ? 'error' : '' }}" required>
                                <option value="">@lang('nova-department::app.positions.department_placeholder')</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                            {{ old('department_id', $selectedDepartmentId) == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="level">@lang('nova-department::app.positions.level_label')</label>
                            <select id="level" name="level"
                                    class="dept-select {{ $errors->has('level') ? 'error' : '' }}">
                                <option value="">@lang('nova-department::app.positions.level_placeholder')</option>
                                @foreach($levels as $key => $label)
                                    <option value="{{ $key }}" {{ old('level') === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Lương & Biên chế --}}
                <div class="dept-form-card">
                    <div class="dept-form-card-title">@lang('nova-department::app.positions.compensation')</div>
                    <div class="dept-form-grid dept-grid-2">

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="salary_min">@lang('nova-department::app.positions.salary_min')</label>
                            <div style="position:relative">
                                <input type="number" id="salary_min" name="salary_min"
                                       class="dept-input {{ $errors->has('salary_min') ? 'error' : '' }}"
                                       value="{{ old('salary_min') }}"
                                       placeholder="0" min="0" step="500000"
                                       style="padding-right:44px"/>
                                <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:#94a3b8">VNĐ</span>
                            </div>
                            @error('salary_min')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="salary_max">@lang('nova-department::app.positions.salary_max')</label>
                            <div style="position:relative">
                                <input type="number" id="salary_max" name="salary_max"
                                       class="dept-input {{ $errors->has('salary_max') ? 'error' : '' }}"
                                       value="{{ old('salary_max') }}"
                                       placeholder="0" min="0" step="500000"
                                       style="padding-right:44px"/>
                                <span style="position:absolute;right:11px;top:50%;transform:translateY(-50%);font-size:11px;font-weight:700;color:#94a3b8">VNĐ</span>
                            </div>
                            @error('salary_max')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="headcount_plan">@lang('nova-department::app.positions.headcount_plan')</label>
                            <input type="number" id="headcount_plan" name="headcount_plan"
                                   class="dept-input {{ $errors->has('headcount_plan') ? 'error' : '' }}"
                                   value="{{ old('headcount_plan') }}"
                                   placeholder="5" min="0"/>
                            <span class="dept-field-hint">@lang('nova-department::app.positions.headcount_hint')</span>
                            @error('headcount_plan')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Preview dải lương --}}
                        <div class="dept-form-group">
                            <label class="dept-form-label">@lang('nova-department::app.positions.salary_preview')</label>
                            <div style="padding:9px 12px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;min-height:37px;display:flex;align-items:center">
                                <span id="salary-preview" class="dept-salary-range" style="font-size:13px">
                                    <span style="color:#cbd5e1">@lang('nova-department::app.common.salary_range_preview_empty')</span>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>

        {{-- Sidebar --}}
        <div class="dept-form-side">
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.positions.status_card')</div>
                <div class="dept-form-group">
                    <label class="dept-form-label" for="status">@lang('nova-department::app.positions.status_label')</label>
                    <select id="status" name="status" form="pos-form"
                            class="dept-select {{ $errors->has('status') ? 'error' : '' }}">
                        <option value="active"   {{ old('status','active') === 'active'   ? 'selected' : '' }}>@lang('nova-department::app.common.active')</option>
                        <option value="inactive" {{ old('status','active') === 'inactive' ? 'selected' : '' }}>@lang('nova-department::app.common.inactive')</option>
                    </select>
                </div>
            </div>

            {{-- Hướng dẫn điền mã --}}
            <div class="dept-form-card" style="border-color:#dbeafe;background:#f0f7ff">
                <div class="dept-form-card-title" style="color:#1d4ed8">@lang('nova-department::app.positions.code_suggestion')</div>
                <div style="display:flex;flex-direction:column;gap:8px">
                    @php
                        $examples = [
                            ['code' => 'SWE-01', 'label' => __('nova-department::app.positions.examples.software_engineer')],
                            ['code' => 'MGR-02', 'label' => __('nova-department::app.positions.examples.manager')],
                            ['code' => 'HR-03',  'label' => __('nova-department::app.positions.examples.hr_specialist')],
                            ['code' => 'DEV-04', 'label' => __('nova-department::app.positions.examples.developer')],
                        ];
                    @endphp
                    @foreach($examples as $ex)
                        <div style="display:flex;align-items:center;gap:8px">
                            <span class="dept-table-code">{{ $ex['code'] }}</span>
                            <span style="font-size:11.5px;color:#64748b">{{ $ex['label'] }}</span>
                        </div>
                    @endforeach
                    <div style="font-size:11px;color:#94a3b8;margin-top:4px;font-weight:500">
                        @lang('nova-department::app.positions.example_format')<br>
                        @lang('nova-department::app.positions.example_format_note')
                    </div>
                </div>
            </div>

            {{-- Gợi ý cấp bậc --}}
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.positions.grade_scale')</div>
                <div style="display:flex;flex-direction:column;gap:6px">
                    @foreach($levels as $key => $label)
                        @php
                            $badgeClass = match($key) {
                                'intern'             => 'dept-badge-gray',
                                'junior'             => 'dept-badge-blue',
                                'mid'                => 'dept-badge-purple',
                                'senior', 'lead'     => 'dept-badge-amber',
                                default              => 'dept-badge-amber',
                            };
                        @endphp
                        <div style="display:flex;align-items:center;gap:8px">
                            <span class="dept-badge {{ $badgeClass }}" style="font-size:10px;min-width:70px;justify-content:center">
                                {{ $label }}
                            </span>
                            <span style="font-size:11px;color:#94a3b8;font-family:'Courier New',monospace">{{ $key }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['app/packages/Nova/Department/src/resources/js/app.js'])
    <script>
        // Preview dải lương realtime
        const minInput  = document.getElementById('salary_min');
        const maxInput  = document.getElementById('salary_max');
        const preview   = document.getElementById('salary-preview');

        function fmt(val) {
            const n = parseInt(val);
            if (!val || isNaN(n)) return null;
            return n.toLocaleString('vi-VN');
        }

        function updatePreview() {
            const min = fmt(minInput.value);
            const max = fmt(maxInput.value);

            if (!min && !max) {
                preview.innerHTML = `<span style="color:#cbd5e1">${@json(__('nova-department::app.common.salary_range_preview_empty'))}</span>`;
                return;
            }

            const minStr = min ? `${min} ₫` : '?';
            const maxStr = max ? `${max} ₫` : '?';
            preview.innerHTML = `${minStr} <span class="sep">–</span> ${maxStr}`;
        }

        minInput?.addEventListener('input', updatePreview);
        maxInput?.addEventListener('input', updatePreview);
    </script>
@endsection
