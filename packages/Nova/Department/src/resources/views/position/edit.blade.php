@extends('nova-dashboard::layouts')

@section('title', __('nova-department::app.positions.edit_page_title'))

@section('styles')
    @vite([
        'packages/Nova/Dashboard/src/resources/css/app.css',
        'packages/Nova/Department/src/resources/css/app.css',
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
                    <a href="{{ route('hr.positions.show', $position) }}">{{ $position->title }}</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>@lang('nova-department::app.positions.edit_breadcrumb')</span>
                </div>
                <div style="display:flex;align-items:center;gap:10px">
                    <div class="dept-page-title">@lang('nova-department::app.positions.edit_heading')</div>
                    <span class="dept-table-code">{{ $position->code }}</span>
                </div>
                <div class="dept-page-subtitle" style="margin-top:4px">
                    {{ $position->title }}
                    @if($position->department)
                        &middot; {{ $position->department->name }}
                    @endif
                </div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.positions.show', $position) }}" class="btn-dept-secondary">@lang('nova-department::app.common.cancel')</a>
                <button type="submit" form="pos-form" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    @lang('nova-department::app.common.save_changes')
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

            <form id="pos-form" method="POST" action="{{ route('hr.positions.update', $position) }}">
                @csrf
                @method('PUT')

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
                                   value="{{ old('title', $position->title) }}"
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
                                   value="{{ old('code', $position->code) }}"
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
                                      placeholder="@lang('nova-department::app.positions.description_placeholder')">{{ old('description', $position->description) }}</textarea>
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
                                            {{ old('department_id', $position->department_id) == $dept->id ? 'selected' : '' }}>
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
                                    <option value="{{ $key }}"
                                            {{ old('level', $position->level) === $key ? 'selected' : '' }}>
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
                                       value="{{ old('salary_min', $position->salary_min) }}"
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
                                       value="{{ old('salary_max', $position->salary_max) }}"
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
                                   value="{{ old('headcount_plan', $position->headcount_plan) }}"
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
                                    @if($position->salary_min || $position->salary_max)
                                        {{ $position->salary_min ? number_format($position->salary_min) . ' ₫' : '?' }}
                                        <span class="sep">–</span>
                                        {{ $position->salary_max ? number_format($position->salary_max) . ' ₫' : '?' }}
                                    @else
                                        <span style="color:#cbd5e1">@lang('nova-department::app.common.salary_range_preview_empty')</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>

        {{-- Sidebar --}}
        <div class="dept-form-side">

            {{-- Trạng thái --}}
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.positions.status_card')</div>
                <div class="dept-form-group">
                    <label class="dept-form-label" for="status">@lang('nova-department::app.positions.status_label')</label>
                    <select id="status" name="status" form="pos-form"
                            class="dept-select {{ $errors->has('status') ? 'error' : '' }}">
                        <option value="active"   {{ old('status', $position->status) === 'active'   ? 'selected' : '' }}>@lang('nova-department::app.common.active')</option>
                        <option value="inactive" {{ old('status', $position->status) === 'inactive' ? 'selected' : '' }}>@lang('nova-department::app.common.inactive')</option>
                    </select>
                </div>
            </div>

            {{-- Thông tin hệ thống --}}
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.common.system_info')</div>
                <div class="dept-info-list">
                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.positions.current_employees')</div>
                            <div class="dept-info-val">
                                {{ __('nova-department::app.common.people_count', ['count' => $position->employees_count ?? $position->employees()->count()]) }}
                            </div>
                        </div>
                    </div>
                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.common.created_at')</div>
                            <div class="dept-info-val">{{ $position->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.common.updated_at')</div>
                            <div class="dept-info-val">{{ $position->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Thang cấp bậc tham khảo --}}
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.positions.grade_scale')</div>
                <div style="display:flex;flex-direction:column;gap:6px">
                    @foreach($levels as $key => $label)
                        @php
                            $badgeClass = match($key) {
                                'intern'         => 'dept-badge-gray',
                                'junior'         => 'dept-badge-blue',
                                'mid'            => 'dept-badge-purple',
                                'senior', 'lead' => 'dept-badge-amber',
                                default          => 'dept-badge-amber',
                            };
                            $isSelected = old('level', $position->level) === $key;
                        @endphp
                        <div style="display:flex;align-items:center;gap:8px;padding:4px 6px;border-radius:6px;background:{{ $isSelected ? '#f0f7ff' : 'transparent' }};transition:background 0.15s"
                             id="level-hint-{{ $key }}">
                            <span class="dept-badge {{ $badgeClass }}" style="font-size:10px;min-width:70px;justify-content:center">
                                {{ $label }}
                            </span>
                            <span style="font-size:11px;color:#94a3b8;font-family:'Courier New',monospace">{{ $key }}</span>
                            @if($isSelected)
                                <svg viewBox="0 0 24 24" style="width:11px;height:11px;stroke:#1d4ed8;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;margin-left:auto">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Vùng nguy hiểm --}}
            <div class="dept-form-card" style="border-color:#fecaca">
                <div class="dept-form-card-title" style="color:#dc2626">@lang('nova-department::app.common.danger_zone')</div>
                @if($position->employees()->exists())
                    <div class="dept-alert dept-alert-error" style="padding:10px 12px;font-size:11.5px;margin-bottom:10px">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>{{ __('nova-department::app.positions.delete_blocked', ['count' => $position->employees()->count()]) }}</span>
                    </div>
                    <button type="button" class="btn-dept-danger" disabled style="width:100%;justify-content:center;opacity:0.5;cursor:not-allowed">
                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                        @lang('nova-department::app.positions.delete_button')
                    </button>
                @else
                    <p style="font-size:12px;color:#94a3b8;margin:0 0 12px">
                        @lang('nova-department::app.positions.delete_warning')
                    </p>
                    <form id="delete-pos-{{ $position->id }}" method="POST"
                          action="{{ route('hr.positions.destroy', $position) }}">
                        @csrf @method('DELETE')
                    </form>
                    <button type="button" class="btn-dept-danger"
                            data-delete-form="delete-pos-{{ $position->id }}"
                            data-name="{{ $position->title }}"
                            style="width:100%;justify-content:center">
                        <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                        @lang('nova-department::app.positions.delete_button')
                    </button>
                @endif
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    @vite(['packages/Nova/Department/src/resources/js/app.js'])
    <script>
        const minInput    = document.getElementById('salary_min');
        const maxInput    = document.getElementById('salary_max');
        const preview     = document.getElementById('salary-preview');
        const levelSelect = document.getElementById('level');
        const levelHints  = document.querySelectorAll('[id^="level-hint-"]');

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
            preview.innerHTML = `${min ? min + ' ₫' : '?'} <span class="sep">–</span> ${max ? max + ' ₫' : '?'}`;
        }

        function updateLevelHint() {
            levelHints.forEach(el => {
                const key = el.id.replace('level-hint-', '');
                el.style.background = levelSelect.value === key ? '#f0f7ff' : 'transparent';

                // Xóa/thêm icon tick
                const existingTick = el.querySelector('svg');
                if (levelSelect.value === key && !existingTick) {
                    el.insertAdjacentHTML('beforeend', `
                        <svg viewBox="0 0 24 24" style="width:11px;height:11px;stroke:#1d4ed8;fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round;margin-left:auto">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>`);
                } else if (levelSelect.value !== key && existingTick) {
                    existingTick.remove();
                }
            });
        }

        minInput?.addEventListener('input', updatePreview);
        maxInput?.addEventListener('input', updatePreview);
        levelSelect?.addEventListener('change', updateLevelHint);
    </script>
@endsection

