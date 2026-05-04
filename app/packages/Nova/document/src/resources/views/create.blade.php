@extends('nova-dashboard::layouts')

@section('title', __('documents::app.form.create_page_title'))

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Document/src/resources/css/app.css',
    ])
@endsection

@section('content')
<div style="display:flex;flex-direction:column;height:100vh;overflow:hidden;">

    {{-- TOPBAR --}}
    <header class="doc-topbar">
        <div class="doc-topbar-row1">
            <div>
                <div class="doc-breadcrumb">
                    <a href="{{ route('dashboard') }}">@lang('documents::app.common.dashboard')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('documents.index') }}">@lang('documents::app.common.documents')</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>@lang('documents::app.form.create_heading')</span>
                </div>
                <div class="doc-page-title">@lang('documents::app.form.create_heading')</div>
            </div>
            <div class="doc-topbar-actions">
                <a href="{{ route('documents.index') }}" class="doc-btn doc-btn-secondary">@lang('documents::app.common.cancel')</a>
                <button type="submit" form="create-doc-form" class="doc-btn doc-btn-primary" id="btn-submit">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    @lang('documents::app.common.upload')
                </button>
            </div>
        </div>
    </header>

    {{-- BODY --}}
    <div class="doc-body">

        @if($errors->any())
        <div class="doc-alert doc-alert-error">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <div style="font-weight:700;margin-bottom:4px">@lang('documents::app.form.errors_heading')</div>
                @foreach($errors->all() as $err)
                    <div>· {{ $err }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <form id="create-doc-form"
              method="POST"
              action="{{ route('documents.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="doc-detail-layout">

                {{-- LEFT: File upload + metadata --}}
                <div style="display:flex;flex-direction:column;gap:16px">

                    {{-- Upload zone --}}
                    <div class="doc-form-card">
                        <div class="doc-form-card-title">@lang('documents::app.form.file_card')</div>

                        <div class="doc-upload-zone" id="upload-zone">
                            <div class="doc-upload-icon">
                                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            </div>
                            <div class="doc-upload-title">@lang('documents::app.form.drop_file')</div>
                            <div class="doc-upload-hint">
                                <span onclick="document.getElementById('file-input').click()">@lang('documents::app.form.choose_file')</span>
                                <span> @lang('documents::app.form.or_drag_drop')</span>
                            </div>
                            <div style="font-size:11px;color:var(--doc-text-faint)">
                                @lang('documents::app.form.supported_file')
                            </div>
                        </div>

                        <input
                            type="file"
                            id="file-input"
                            name="file"
                            accept=".pdf"
                            style="display:none"
                            required
                        />

                        {{-- Preview file đã chọn --}}
                        <div class="doc-upload-preview" id="file-preview" style="display:none">
                            <div class="doc-upload-preview-icon">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;min-width:0">
                                <div class="doc-upload-preview-name" id="preview-name">—</div>
                                <div class="doc-upload-preview-size" id="preview-size">—</div>
                                <div class="doc-upload-progress">
                                    <div class="doc-upload-progress-bar" id="progress-bar"></div>
                                </div>
                            </div>
                            <button type="button" class="doc-btn doc-btn-ghost doc-btn-icon" onclick="clearFile()" title="@lang('documents::app.form.remove_file')">
                                <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Thông tin cơ bản --}}
                    <div class="doc-form-card">
                        <div class="doc-form-card-title">@lang('documents::app.form.document_info')</div>
                        <div class="doc-form-grid">

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="title">@lang('documents::app.form.display_name')</label>
                                <input
                                    class="doc-input {{ $errors->has('title') ? 'border-red-400' : '' }}"
                                    type="text"
                                    id="title"
                                    name="title"
                                    value="{{ old('title') }}"
                                    placeholder="@lang('documents::app.form.display_name_placeholder')"
                                    required
                                />
                            </div>

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="category_id">@lang('documents::app.form.category')</label>
                                <select class="doc-select" id="category_id" name="category_id" required onchange="onCategoryChange(this)">
                                    <option value="">@lang('documents::app.form.category_placeholder')</option>
                                    @foreach($categories ?? [] as $cat)
                                        <option
                                            value="{{ $cat->id }}"
                                            data-requires-approval="{{ $cat->requires_approval ? '1' : '0' }}"
                                            data-requires-signature="{{ $cat->requires_signature ? '1' : '0' }}"
                                            data-access="{{ $cat->access_level }}"
                                            {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Thông tin danh mục (hiển thị khi chọn) --}}
                            <div id="category-info" style="display:none" class="doc-col-full">
                                <div class="doc-alert doc-alert-info" id="category-info-box">
                                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                                    <span id="category-info-text"></span>
                                </div>
                            </div>

                            <div class="doc-form-group doc-col-full">
                                <label class="doc-form-label" for="tags">@lang('documents::app.common.tags')</label>
                                <input
                                    class="doc-input"
                                    type="text"
                                    id="tags-input"
                                    placeholder="@lang('documents::app.form.tags_placeholder')"
                                    autocomplete="off"
                                />
                                <input type="hidden" id="tags" name="tags" value="{{ old('tags') }}"/>
                                <div id="tags-wrap" class="doc-tags-wrap" style="margin-top:6px"></div>
                                <div style="font-size:10.5px;color:var(--doc-text-faint);margin-top:4px">
                                    @lang('documents::app.form.tags_hint')
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Thời hạn & phiên bản --}}
                    <div class="doc-form-card">
                        <div class="doc-form-card-title">@lang('documents::app.form.date_version')</div>
                        <div class="doc-form-grid doc-grid-2">

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="issued_at">@lang('documents::app.form.issued_at')</label>
                                <input
                                    class="doc-input"
                                    type="date"
                                    id="issued_at"
                                    name="issued_at"
                                    value="{{ old('issued_at', now()->format('Y-m-d')) }}"
                                />
                            </div>

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="expires_at">@lang('documents::app.form.expires_at')</label>
                                <input
                                    class="doc-input"
                                    type="date"
                                    id="expires_at"
                                    name="expires_at"
                                    value="{{ old('expires_at') }}"
                                />
                            </div>

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="version">@lang('documents::app.form.version')</label>
                                <input
                                    class="doc-input"
                                    type="number"
                                    id="version"
                                    name="version"
                                    value="{{ old('version', 1) }}"
                                    min="1"
                                    style="max-width:100px"
                                />
                            </div>

                        </div>
                    </div>

                </div>

                {{-- RIGHT: Sidebar options --}}
                <div style="display:flex;flex-direction:column;gap:16px">

                    {{-- Quyền truy cập --}}
                    <div class="doc-detail-card">
                        <div class="doc-detail-card-head">
                            <div class="doc-detail-card-title">@lang('documents::app.form.access')</div>
                        </div>
                        <div class="doc-detail-card-body" style="display:flex;flex-direction:column;gap:14px">

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="employee_id">@lang('documents::app.form.assign_employee')</label>
                                <select class="doc-select" id="employee_id" name="employee_id">
                                    <option value="">@lang('documents::app.form.assign_employee_placeholder')</option>
                                    @foreach($employees ?? [] as $emp)
                                        <option value="{{ $emp->id }}" {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }} ({{ $emp->employee_code }})
                                        </option>
                                    @endforeach
                                </select>
                                <div style="font-size:10.5px;color:var(--doc-text-faint);margin-top:4px">
                                    @lang('documents::app.form.assign_employee_hint')
                                </div>
                            </div>

                            <div>
                                <label class="doc-toggle-wrap">
                                    <div class="doc-toggle" id="toggle-confidential"></div>
                                    <input type="hidden" name="is_confidential" id="is_confidential" value="{{ old('is_confidential', '0') }}"/>
                                    <div>
                                        <div class="doc-toggle-label">@lang('documents::app.form.confidential_title')</div>
                                        <div style="font-size:10.5px;color:var(--doc-text-faint);margin-top:2px">
                                            @lang('documents::app.form.confidential_hint')
                                        </div>
                                    </div>
                                </label>
                            </div>

                        </div>
                    </div>

                    {{-- Luồng xử lý (hiển thị theo danh mục) --}}
                    <div class="doc-detail-card" id="workflow-card">
                        <div class="doc-detail-card-head">
                            <div class="doc-detail-card-title">@lang('documents::app.form.workflow')</div>
                        </div>
                        <div class="doc-detail-card-body" style="display:flex;flex-direction:column;gap:10px">

                            <div class="doc-meta-row" id="row-approval">
                                <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                <div>
                                    <div class="doc-meta-label">@lang('documents::app.form.requires_approval')</div>
                                    <div class="doc-meta-val" id="val-approval">—</div>
                                </div>
                            </div>

                            <div class="doc-meta-row" id="row-signature">
                                <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                <div>
                                    <div class="doc-meta-label">@lang('documents::app.form.requires_signature')</div>
                                    <div class="doc-meta-val" id="val-signature">—</div>
                                </div>
                            </div>

                            <div style="font-size:11px;color:var(--doc-text-faint);padding-top:4px">
                                @lang('documents::app.form.workflow_hint')
                            </div>
                        </div>
                    </div>

                    {{-- Hướng dẫn --}}
                    <div class="doc-alert doc-alert-info">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        <div style="font-size:11.5px;line-height:1.6">
                            @lang('documents::app.form.help_text')
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['app/packages/Nova/document/src/resources/js/app.js'])
<script>
// File Upload 
const fileInput   = document.getElementById('file-input');
const uploadZone  = document.getElementById('upload-zone');
const filePreview = document.getElementById('file-preview');

uploadZone.addEventListener('click', () => fileInput.click());
uploadZone.addEventListener('dragover', e => { e.preventDefault(); uploadZone.classList.add('dragover'); });
uploadZone.addEventListener('dragleave', () => uploadZone.classList.remove('dragover'));
uploadZone.addEventListener('drop', e => {
    e.preventDefault();
    uploadZone.classList.remove('dragover');
    if (e.dataTransfer.files[0]) setFile(e.dataTransfer.files[0]);
});
fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) setFile(fileInput.files[0]);
});

function setFile(file) {
    if (file.type !== 'application/pdf') {
        novaToast(@json(__('documents::app.form.pdf_only')), 'error');
        return;
    }
    if (file.size > 20 * 1024 * 1024) {
        novaToast(@json(__('documents::app.form.max_size')), 'warning');
        return;
    }

    // Transfer to actual input
    const dt = new DataTransfer();
    dt.items.add(file);
    fileInput.files = dt.files;

    document.getElementById('preview-name').textContent = file.name;
    document.getElementById('preview-size').textContent = formatBytes(file.size);

    // Auto-fill tên hiển thị nếu chưa có
    const nameInput = document.getElementById('title');
    if (!nameInput.value) {
        nameInput.value = file.name.replace(/\.pdf$/i, '');
    }

    uploadZone.style.display = 'none';
    filePreview.style.display = 'flex';

    // Fake progress (visual only)
    let w = 0;
    const bar = document.getElementById('progress-bar');
    const iv = setInterval(() => {
        w += Math.random() * 18;
        if (w >= 100) { w = 100; clearInterval(iv); }
        bar.style.width = w + '%';
    }, 80);
}

function clearFile() {
    fileInput.value = '';
    filePreview.style.display = 'none';
    uploadZone.style.display = 'flex';
    document.getElementById('progress-bar').style.width = '0%';
}

function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
}

// Category change 
function onCategoryChange(sel) {
    const opt = sel.options[sel.selectedIndex];
    const infoBox  = document.getElementById('category-info');
    const infoText = document.getElementById('category-info-text');
    const valApproval  = document.getElementById('val-approval');
    const valSignature = document.getElementById('val-signature');

    if (!opt.value) {
        infoBox.style.display = 'none';
        valApproval.textContent = @json(__('documents::app.common.none'));
        valSignature.textContent = @json(__('documents::app.common.none'));
        return;
    }

    const needApproval  = opt.dataset.requiresApproval === '1';
    const needSignature = opt.dataset.requiresSignature === '1';
    const access        = opt.dataset.access;

    valApproval.textContent  = needApproval  ? @json(__('documents::app.form.approval_yes')) : @json(__('documents::app.form.approval_no'));
    valSignature.textContent = needSignature ? @json(__('documents::app.form.signature_yes')) : @json(__('documents::app.form.signature_no'));

    const parts = [];
    if (access === 'personal') parts.push(@json(__('documents::app.form.category_access_personal')));
    if (access === 'company')  parts.push(@json(__('documents::app.form.category_access_company')));
    if (needApproval)  parts.push(@json(__('documents::app.form.requires_approval')));
    if (needSignature) parts.push(@json(__('documents::app.form.requires_signature')));

    infoText.textContent = parts.join(' · ');
    infoBox.style.display = 'flex';
}

// Toggle confidential 
const toggleEl    = document.getElementById('toggle-confidential');
const hiddenField = document.getElementById('is_confidential');
let isConfidential = hiddenField.value === '1';

function syncToggle() {
    toggleEl.classList.toggle('on', isConfidential);
    hiddenField.value = isConfidential ? '1' : '0';
}
syncToggle();
toggleEl.addEventListener('click', () => {
    isConfidential = !isConfidential;
    syncToggle();
});

// Tags 
let tags = [];
const tagsInput  = document.getElementById('tags-input');
const tagsHidden = document.getElementById('tags');
const tagsWrap   = document.getElementById('tags-wrap');

function renderTags() {
    tagsWrap.innerHTML = tags.map((t, i) => `
        <span class="doc-tag">
            ${t}
            <button type="button" onclick="removeTag(${i})"
                style="background:none;border:none;cursor:pointer;margin-left:4px;
                       color:var(--doc-primary);font-size:11px;padding:0;line-height:1">×</button>
        </span>
    `).join('');
    tagsHidden.value = JSON.stringify(tags);
}

function addTag(val) {
    const t = val.trim().toLowerCase();
    if (t && !tags.includes(t) && tags.length < 10) {
        tags.push(t);
        renderTags();
    }
    tagsInput.value = '';
}

function removeTag(i) {
    tags.splice(i, 1);
    renderTags();
}

tagsInput.addEventListener('keydown', e => {
    if (e.key === 'Enter') { e.preventDefault(); addTag(tagsInput.value); }
    if (e.key === ',')     { e.preventDefault(); addTag(tagsInput.value); }
    if (e.key === 'Backspace' && !tagsInput.value && tags.length) {
        tags.pop(); renderTags();
    }
});
tagsInput.addEventListener('blur', () => {
    if (tagsInput.value.trim()) addTag(tagsInput.value);
});

// Restore old tags nếu có validation error
@if(old('tags'))
try {
    tags = JSON.parse('{{ old('tags') }}') || [];
    renderTags();
} catch(e) {}
@endif

// Submit guard 
document.getElementById('create-doc-form').addEventListener('submit', function() {
    const btn = document.getElementById('btn-submit');
    btn.disabled = true;
    btn.textContent = @json(__('documents::app.form.uploading'));
});
</script>
@endsection
