@extends('nova-dashboard::layouts')

@section('title', __('nova-department::app.departments.create_page_title'))

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
                    <span>@lang('nova-department::app.departments.create_breadcrumb')</span>
                </div>
                <div class="dept-page-title">@lang('nova-department::app.departments.create_heading')</div>
            </div>
            <div class="dept-actions">
                <a href="{{ route('hr.departments.index') }}" class="btn-dept-secondary">@lang('nova-department::app.common.cancel')</a>
                <button type="submit" form="dept-form" class="btn-dept-primary">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    @lang('nova-department::app.departments.save_button')
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

            <form id="dept-form" method="POST" action="{{ route('hr.departments.store') }}">
                @csrf

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
                                   value="{{ old('name') }}"
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
                                   value="{{ old('code') }}"
                                   placeholder="@lang('nova-department::app.departments.code_placeholder')" style="font-family:'Courier New',monospace" required/>
                            @error('code')
                                <span class="dept-field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="dept-form-group dept-col-full">
                            <label class="dept-form-label" for="description">@lang('nova-department::app.common.description')</label>
                            <textarea id="description" name="description"
                                      class="dept-textarea {{ $errors->has('description') ? 'error' : '' }}"
                                      placeholder="@lang('nova-department::app.departments.description_placeholder')">{{ old('description') }}</textarea>
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

                        @if(isset($preselectedParent))
                            {{-- Đã có parent từ query string: hiển thị tên, disable, gửi hidden --}}
                            <input type="hidden" name="parent_id" value="{{ $preselectedParent->id }}">
                            <div class="dept-input" style="background:#f8fafc;color:#64748b;display:flex;align-items:center;gap:8px;cursor:not-allowed">
                                @if($preselectedParent->color)
                                    <span style="width:8px;height:8px;border-radius:50%;background:{{ $preselectedParent->color }};flex-shrink:0;display:inline-block"></span>
                                @endif
                                {{ $preselectedParent->name }}
                                <span class="dept-table-code" style="margin-left:auto">{{ $preselectedParent->code }}</span>
                            </div>
                            <span class="dept-field-hint">@lang('nova-department::app.departments.manager_locked_hint')</span>
                        @else
                            {{-- Thêm bình thường: cho chọn tự do --}}
                            <select id="parent_id" name="parent_id"
                                    class="dept-select {{ $errors->has('parent_id') ? 'error' : '' }}">
                                <option value="">@lang('nova-department::app.departments.parent_placeholder')</option>
                                @foreach($parentOptions as $opt)
                                    <option value="{{ $opt['id'] }}"
                                            {{ old('parent_id') == $opt['id'] ? 'selected' : '' }}>
                                        {{ $opt['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        @error('parent_id')
                            <span class="dept-field-error">{{ $message }}</span>
                        @enderror
                    </div>

                        <div class="dept-form-group">
                            <label class="dept-form-label" for="order">@lang('nova-department::app.departments.order')</label>
                            <input type="number" id="order" name="order"
                                   class="dept-input {{ $errors->has('order') ? 'error' : '' }}"
                                   value="{{ old('order', 0) }}" min="0"/>
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
                            <option value="active"   {{ old('status','active') === 'active'   ? 'selected' : '' }}>@lang('nova-department::app.common.active')</option>
                            <option value="inactive" {{ old('status','active') === 'inactive' ? 'selected' : '' }}>@lang('nova-department::app.common.inactive')</option>
                        </select>
                    </div>

                    <div class="dept-form-group">
                        <label class="dept-form-label" for="color-input">@lang('nova-department::app.common.color')</label>
                        <div class="dept-color-row">
                            <input type="color" id="color-input" name="color" form="dept-form"
                                   class="dept-color-input"
                                   value="{{ old('color', '#1d4ed8') }}"/>
                            <div id="color-preview" class="dept-color-preview"
                                 style="background: {{ old('color','#1d4ed8') }}"></div>
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
                        value="{{ old('manager_id') ? '' : '' }}"
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
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['packages/Nova/Department/src/resources/js/app.js'])
@endsection

