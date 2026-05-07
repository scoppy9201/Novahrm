@extends('nova-dashboard::layouts')

@section('title', __('nova-department::app.departments.edit_page_title'))

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
                    <a href="{{ route('hr.departments.index') }}">@lang('nova-department::app.common.departments')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('hr.departments.show', $department) }}">{{ $department->name }}</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>@lang('nova-department::app.departments.edit_breadcrumb')</span>
                </div>
                <div class="dept-page-title">@lang('nova-department::app.departments.edit_heading')</div>
                <div class="dept-page-subtitle">{{ $department->name }} &middot; <span class="dept-table-code">{{ $department->code }}</span></div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.departments.show', $department) }}" class="btn-dept-secondary">@lang('nova-department::app.common.cancel')</a>
                <button type="submit" form="dept-form" class="btn-dept-primary">
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

            <form id="dept-form" method="POST" action="{{ route('hr.departments.update', $department) }}">
                @csrf
                @method('PUT')

                {{-- Thông tin cơ bản --}}
                <div class="dept-form-card">
                    <div class="dept-form-card-title">@lang('nova-department::app.departments.basic_info')</div>
                    <div class="dept-form-grid dept-grid-2">

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="name">
                                @lang('nova-department::app.departments.name_label') <span class="required">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                   class="dept-input {{ $errors->has('name') ? 'error' : '' }}"
                                   value="{{ old('name', $department->name) }}"
                                   placeholder="@lang('nova-department::app.departments.name_placeholder')" required/>
                            @error('name')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="code">
                                @lang('nova-department::app.departments.code_label') <span class="required">*</span>
                            </label>
                            <input type="text" id="code" name="code"
                                   class="dept-input {{ $errors->has('code') ? 'error' : '' }}"
                                   value="{{ old('code', $department->code) }}"
                                   placeholder="@lang('nova-department::app.departments.code_placeholder')" style="font-family:'Courier New',monospace" required/>
                            @error('code')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group dept-col-full">
                            <label class="dept-form-label" for="description">@lang('nova-department::app.common.description')</label>
                            <textarea id="description" name="description"
                                      class="dept-textarea {{ $errors->has('description') ? 'error' : '' }}"
                                      placeholder="@lang('nova-department::app.departments.description_placeholder')">{{ old('description', $department->description) }}</textarea>
                            @error('description')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Cấu trúc --}}
                <div class="dept-form-card">
                    <div class="dept-form-card-title">@lang('nova-department::app.departments.structure')</div>
                    <div class="dept-form-grid dept-grid-2">

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="parent_id">@lang('nova-department::app.departments.parent_department')</label>
                            <select id="parent_id" name="parent_id"
                                    class="dept-select {{ $errors->has('parent_id') ? 'error' : '' }}">
                                <option value="">@lang('nova-department::app.departments.parent_placeholder')</option>
                                @foreach($parentOptions as $opt)
                                    {{-- Không cho chọn chính nó làm cha --}}
                                    @if($opt['id'] !== $department->id)
                                        <option value="{{ $opt['id'] }}"
                                                {{ old('parent_id', $department->parent_id) == $opt['id'] ? 'selected' : '' }}>
                                            {{ $opt['name'] }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('parent_id')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="order">@lang('nova-department::app.departments.order')</label>
                            <input type="number" id="order" name="order"
                                   class="dept-input {{ $errors->has('order') ? 'error' : '' }}"
                                   value="{{ old('order', $department->order ?? 0) }}" min="0"/>
                            <span class="dept-field-hint">@lang('nova-department::app.departments.order_hint')</span>
                            @error('order')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

            </form>
        </div>

        {{-- Sidebar --}}
        <div class="dept-form-side">
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.departments.display')</div>
                <div class="dept-form-grid" style="gap:14px">

                    <div class="dept-form-group">
                        <label class="dept-form-label" for="status">@lang('nova-department::app.common.status')</label>
                        <select id="status" name="status" form="dept-form"
                                class="dept-select {{ $errors->has('status') ? 'error' : '' }}">
                            <option value="active"   {{ old('status', $department->status) === 'active'   ? 'selected' : '' }}>@lang('nova-department::app.common.active')</option>
                            <option value="inactive" {{ old('status', $department->status) === 'inactive' ? 'selected' : '' }}>@lang('nova-department::app.common.inactive')</option>
                        </select>
                    </div>

                    <div class="dept-form-group">
                        <label class="dept-form-label" for="color-input">@lang('nova-department::app.common.color')</label>
                        <div class="dept-color-row">
                            <input type="color" id="color-input" name="color" form="dept-form"
                                   class="dept-color-input"
                                   value="{{ old('color', $department->color ?? '#1d4ed8') }}"/>
                            <div id="color-preview" class="dept-color-preview"
                                 style="background: {{ old('color', $department->color ?? '#1d4ed8') }}"></div>
                            <span class="dept-field-hint">@lang('nova-department::app.departments.color_hint')</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="dept-form-group">
                <label class="dept-form-label">
                    @lang('nova-department::app.departments.manager')
                </label>

                {{-- Hidden input gửi lên server --}}
                <input type="hidden" name="manager_id" id="manager_id"
                    form="dept-form"
                    value="{{ old('manager_id', $department->manager_id ?? '') }}">

                {{-- Search input hiển thị --}}
                <div class="dept-manager-search-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="manager_search"
                        class="dept-input"
                        data-url="{{ route('hr.departments.search-managers') }}"
                        placeholder="@lang('nova-department::app.departments.manager_search_placeholder')"
                        value="{{ old('manager_id') ? '' : ($department->manager->name ?? '') }}"
                        autocomplete="off"/>
                    <button type="button" id="manager_clear"
                            class="dept-manager-clear {{ isset($department->manager) ? '' : 'hidden' }}"
                            title="@lang('nova-department::app.departments.manager_clear_title')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                {{-- Dropdown kết quả --}}
                <div id="manager_dropdown" class="dept-manager-dropdown hidden"></div>

                {{-- Preview người đã chọn --}}
                <div id="manager_preview" class="dept-manager-preview {{ isset($department->manager) ? '' : 'hidden' }}">
                    @if(isset($department->manager))
                        <div class="dept-avatar" style="width:28px;height:28px;font-size:10px">
                            <img src="{{ $department->manager->avatar_url }}" alt="">
                        </div>
                        <div>
                            <div style="font-size:12px;font-weight:700;color:#0f172a">{{ $department->manager->name }}</div>
                            <div style="font-size:11px;color:#94a3b8">{{ $department->manager->position?->title }}</div>
                        </div>
                    @endif
                </div>

                @error('manager_id')
                    <span class="dept-field-error">{{ $message }}</span>
                @enderror
            </div>

            {{-- Thông tin tạo / cập nhật --}}
            <div class="dept-form-card">
                <div class="dept-form-card-title">@lang('nova-department::app.common.system_info')</div>
                <div class="dept-info-list">
                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.common.created_at')</div>
                            <div class="dept-info-val">{{ $department->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="dept-info-row">
                        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <div>
                            <div class="dept-info-label">@lang('nova-department::app.common.updated_at')</div>
                            <div class="dept-info-val">{{ $department->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Xóa phòng ban --}}
            <div class="dept-form-card" style="border-color:#fecaca">
                <div class="dept-form-card-title" style="color:#dc2626">@lang('nova-department::app.common.danger_zone')</div>
                <p style="font-size:12px;color:#94a3b8;margin:0 0 12px">
                    @lang('nova-department::app.departments.delete_warning')
                </p>
                <form id="delete-dept-{{ $department->id }}" method="POST"
                      action="{{ route('hr.departments.destroy', $department) }}">
                    @csrf @method('DELETE')
                </form>
                <button type="button" class="btn-dept-danger"
                        data-delete-form="delete-dept-{{ $department->id }}"
                        data-name="{{ $department->name }}"
                        style="width:100%;justify-content:center">
                    <svg viewBox="0 0 24 24" style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    @lang('nova-department::app.departments.delete_button')
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['packages/Nova/Department/src/resources/js/app.js'])
@endsection

