@extends('nova-dashboard::layouts')

@section('title', 'Chỉnh sửa — ' . $document->file_name . ' — NovaHRM')

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
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('documents.index') }}">Tài liệu</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <a href="{{ route('documents.show', $document) }}">{{ Str::limit($document->file_name, 30) }}</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>Chỉnh sửa</span>
                </div>
                <div class="doc-page-title">Chỉnh sửa tài liệu</div>
            </div>
            <div class="doc-topbar-actions">
                <a href="{{ route('documents.show', $document) }}" class="doc-btn doc-btn-secondary">Huỷ</a>
                <button type="submit" form="edit-doc-form" class="doc-btn doc-btn-primary" id="btn-submit">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Lưu thay đổi
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
                <div style="font-weight:700;margin-bottom:4px">Có lỗi xảy ra:</div>
                @foreach($errors->all() as $err)<div>· {{ $err }}</div>@endforeach
            </div>
        </div>
        @endif

        <form id="edit-doc-form"
              method="POST"
              action="{{ route('documents.update', $document) }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="doc-detail-layout">

                {{-- LEFT --}}
                <div style="display:flex;flex-direction:column;gap:16px">

                    {{-- File hiện tại --}}
                    <div class="doc-form-card">
                        <div class="doc-form-card-title">File tài liệu</div>

                        {{-- File hiện tại --}}
                        <div class="doc-upload-preview">
                            <div class="doc-upload-preview-icon">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            <div style="flex:1;min-width:0">
                                <div class="doc-upload-preview-name">{{ $document->file_name }}</div>
                                <div class="doc-upload-preview-size">
                                    File hiện tại · {{ $document->fileSizeHuman() }}
                                </div>
                            </div>
                            <a href="{{ route('documents.download', $document) }}"
                               class="doc-btn doc-btn-ghost doc-btn-icon"
                               title="Tải xuống">
                                <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            </a>
                        </div>

                        {{-- Thay thế file mới --}}
                        <div style="margin-top:14px">
                            <div style="font-size:10px;font-weight:700;color:var(--doc-text-faint);
                                        text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px">
                                Thay thế bằng file mới (tuỳ chọn)
                            </div>
                            <div class="doc-upload-zone" id="upload-zone" style="padding:24px">
                                <div class="doc-upload-icon" style="width:40px;height:40px">
                                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                </div>
                                <div class="doc-upload-hint">
                                    <span onclick="document.getElementById('file-new').click()">Chọn file PDF mới</span>
                                    &nbsp;hoặc kéo thả vào đây
                                </div>
                            </div>
                            <input type="file" id="file-new" name="file" accept=".pdf" style="display:none"/>

                            <div class="doc-upload-preview" id="new-file-preview" style="display:none;margin-top:8px">
                                <div class="doc-upload-preview-icon">
                                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <div style="flex:1">
                                    <div class="doc-upload-preview-name" id="new-file-name">—</div>
                                    <div class="doc-upload-preview-size" id="new-file-size">—</div>
                                </div>
                                <button type="button" class="doc-btn doc-btn-ghost doc-btn-icon"
                                        onclick="clearNewFile()">
                                    <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Thông tin --}}
                    <div class="doc-form-card">
                        <div class="doc-form-card-title">Thông tin tài liệu</div>
                        <div class="doc-form-grid">

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="file_name">Tên hiển thị *</label>
                                <input class="doc-input" type="text" id="file_name" name="file_name"
                                    value="{{ old('file_name', $document->file_name) }}" required/>
                            </div>

                            <div class="doc-form-group">
                                <label class="doc-form-label" for="category_id">Danh mục *</label>
                                <select class="doc-select" id="category_id" name="category_id" required>
                                    <option value="">— Chọn danh mục —</option>
                                    @foreach($categories ?? [] as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ old('category_id', $document->category_id) == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="doc-form-group doc-col-full">
                                <label class="doc-form-label" for="tags-input">Tags</label>
                                <input class="doc-input" type="text" id="tags-input"
                                    placeholder="Nhập tag rồi nhấn Enter..." autocomplete="off"/>
                                <input type="hidden" id="tags" name="tags"
                                    value="{{ old('tags', json_encode($document->tags ?? [])) }}"/>
                                <div id="tags-wrap" class="doc-tags-wrap" style="margin-top:6px"></div>
                            </div>

                        </div>
                    </div>

                    {{-- Thời hạn --}}
                    <div class="doc-form-card">
                        <div class="doc-form-card-title">Thời hạn & phiên bản</div>
                        <div class="doc-form-grid doc-grid-2">
                            <div class="doc-form-group">
                                <label class="doc-form-label">Ngày ban hành</label>
                                <input class="doc-input" type="date" name="issued_at"
                                    lang="vi"
                                    value="{{ old('issued_at', $document->issued_at?->format('Y-m-d')) }}"/>
                            </div>
                            <div class="doc-form-group">
                                <label class="doc-form-label">Ngày hết hạn</label>
                                <input class="doc-input" type="date" name="expires_at"
                                    lang="vi"
                                    value="{{ old('expires_at', $document->expires_at?->format('Y-m-d')) }}"/>
                            </div>
                            <div class="doc-form-group">
                                <label class="doc-form-label">Phiên bản</label>
                                <input class="doc-input" type="number" name="version" min="1"
                                    value="{{ old('version', $document->version) }}"
                                    style="max-width:100px"/>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT sidebar --}}
                <div style="display:flex;flex-direction:column;gap:16px">

                    {{-- Trạng thái hiện tại --}}
                    <div class="doc-detail-card">
                        <div class="doc-detail-card-head">
                            <div class="doc-detail-card-title">Trạng thái</div>
                        </div>
                        <div class="doc-detail-card-body">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                                @include('documents::partials.badge', ['status' => $document->status])
                                <span style="font-size:11.5px;color:var(--doc-text-faint)">
                                    {{ $document->created_at->format('d/m/Y') }}
                                </span>
                            </div>

                            @if(in_array($document->status, ['approved','signing','signed']))
                            <div class="doc-alert doc-alert-warning" style="font-size:11.5px">
                                <svg viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                Chỉnh sửa tài liệu đã duyệt có thể yêu cầu phê duyệt lại.
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Quyền truy cập --}}
                    <div class="doc-detail-card">
                        <div class="doc-detail-card-head">
                            <div class="doc-detail-card-title">Quyền truy cập</div>
                        </div>
                        <div class="doc-detail-card-body" style="display:flex;flex-direction:column;gap:14px">
                            <div class="doc-form-group">
                                <label class="doc-form-label">Gán cho nhân viên</label>
                                <select class="doc-select" name="employee_id">
                                    <option value="">— Tài liệu công ty —</option>
                                    @foreach($employees ?? [] as $emp)
                                        <option value="{{ $emp->id }}"
                                            {{ old('employee_id', $document->employee_id) == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->name }} ({{ $emp->employee_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="doc-toggle-wrap">
                                <div class="doc-toggle {{ $document->is_confidential ? 'on' : '' }}" id="toggle-confidential"></div>
                                <input type="hidden" name="is_confidential" id="is_confidential"
                                    value="{{ old('is_confidential', $document->is_confidential ? '1' : '0') }}"/>
                                <div>
                                    <div class="doc-toggle-label">Tài liệu mật</div>
                                    <div style="font-size:10.5px;color:var(--doc-text-faint);margin-top:2px">
                                        Chỉ HR, admin và đương sự xem được
                                    </div>
                                </div>
                            </label>
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
// File mới
const fileNew = document.getElementById('file-new');
const zone    = document.getElementById('upload-zone');

zone.addEventListener('click', () => fileNew.click());
zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
    e.preventDefault(); zone.classList.remove('dragover');
    if (e.dataTransfer.files[0]) setNewFile(e.dataTransfer.files[0]);
});
fileNew.addEventListener('change', () => { if (fileNew.files[0]) setNewFile(fileNew.files[0]); });

function setNewFile(file) {
    if (file.type !== 'application/pdf') { novaToast('Chỉ hỗ trợ PDF!', 'error'); return; }
    if (file.size > 20*1024*1024) { novaToast('File tối đa 20MB!', 'warning'); return; }
    document.getElementById('new-file-name').textContent = file.name;
    document.getElementById('new-file-size').textContent = formatBytes(file.size);
    document.getElementById('new-file-preview').style.display = 'flex';
    zone.style.display = 'none';
}
function clearNewFile() {
    fileNew.value = '';
    document.getElementById('new-file-preview').style.display = 'none';
    zone.style.display = 'flex';
}
function formatBytes(b) {
    if (b < 1024) return b + ' B';
    if (b < 1048576) return (b/1024).toFixed(1) + ' KB';
    return (b/1048576).toFixed(1) + ' MB';
}

// Toggle confidential
const toggleEl    = document.getElementById('toggle-confidential');
const hiddenField = document.getElementById('is_confidential');
toggleEl.addEventListener('click', () => {
    const isOn = toggleEl.classList.toggle('on');
    hiddenField.value = isOn ? '1' : '0';
});

// Tags
let tags = [];
try { tags = JSON.parse(document.getElementById('tags').value) || []; } catch(e) {}
const tagsInput  = document.getElementById('tags-input');
const tagsHidden = document.getElementById('tags');
const tagsWrap   = document.getElementById('tags-wrap');

function renderTags() {
    tagsWrap.innerHTML = tags.map((t,i) => `
        <span class="doc-tag">${t}
            <button type="button" onclick="removeTag(${i})"
                style="background:none;border:none;cursor:pointer;margin-left:4px;
                       color:var(--doc-primary);font-size:11px;padding:0">×</button>
        </span>`).join('');
    tagsHidden.value = JSON.stringify(tags);
}
function addTag(v) {
    const t = v.trim().toLowerCase();
    if (t && !tags.includes(t) && tags.length < 10) { tags.push(t); renderTags(); }
    tagsInput.value = '';
}
function removeTag(i) { tags.splice(i,1); renderTags(); }

tagsInput.addEventListener('keydown', e => {
    if (e.key === 'Enter') { e.preventDefault(); addTag(tagsInput.value); }
    if (e.key === ',')     { e.preventDefault(); addTag(tagsInput.value); }
    if (e.key === 'Backspace' && !tagsInput.value && tags.length) { tags.pop(); renderTags(); }
});
renderTags();

document.getElementById('edit-doc-form').addEventListener('submit', () => {
    const btn = document.getElementById('btn-submit');
    btn.disabled = true; btn.textContent = 'Đang lưu...';
});
</script>
@endsection
