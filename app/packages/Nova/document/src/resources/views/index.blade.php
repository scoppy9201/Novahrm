@extends('nova-dashboard::layouts')

@section('title', 'Tài liệu — NovaHRM')

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
                    <a href="#">Nova HRM+</a>
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    <span>Tài liệu</span>
                </div>
                <div class="doc-page-title">Tài liệu</div>
            </div>
            <div class="doc-topbar-actions">
                <button class="doc-btn doc-btn-secondary" id="btn-toggle-view" title="Chuyển chế độ xem">
                    <svg id="icon-view" viewBox="0 0 24 24" stroke="currentColor">
                        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
                        <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
                    </svg>
                    Lưới
                </button>
                <a href="{{ route('documents.create') }}" class="doc-btn doc-btn-primary">
                    <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tải lên tài liệu
                </a>
            </div>
        </div>

        <div class="doc-topbar-tabs">
            <a href="{{ route('documents.index') }}"
               class="doc-tab {{ !request('tab') || request('tab') === 'all' ? 'active' : '' }}">
                Tất cả
            </a>
            <a href="{{ route('documents.index', ['tab' => 'personal']) }}"
               class="doc-tab {{ request('tab') === 'personal' ? 'active' : '' }}">
                Của tôi
            </a>
            <a href="{{ route('documents.index', ['tab' => 'company']) }}"
               class="doc-tab {{ request('tab') === 'company' ? 'active' : '' }}">
                Công ty
            </a>
            <a href="{{ route('documents.index', ['tab' => 'pending']) }}"
               class="doc-tab {{ request('tab') === 'pending' ? 'active' : '' }}">
                Chờ duyệt
            </a>
            <a href="{{ route('documents.index', ['tab' => 'signing']) }}"
               class="doc-tab {{ request('tab') === 'signing' ? 'active' : '' }}">
                Chờ ký
            </a>
        </div>
    </header>

    {{-- BODY --}}
    <div class="doc-body">

        {{-- FILTER BAR --}}
        <div class="doc-filter-bar">
            <div class="doc-search-wrap">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input
                    type="text"
                    class="doc-search-input"
                    id="search-input"
                    placeholder="Tìm theo tên tài liệu..."
                    value="{{ request('search') }}"
                    autocomplete="off"
                />
            </div>

            <div class="doc-filter-divider"></div>

            <select class="doc-filter-select" id="filter-category" onchange="applyFilters()">
                <option value="">Tất cả danh mục</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <select class="doc-filter-select" id="filter-status" onchange="applyFilters()">
                <option value="">Tất cả trạng thái</option>
                <option value="draft"    {{ request('status') === 'draft'    ? 'selected' : '' }}>Nháp</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Chờ duyệt</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                <option value="signing"  {{ request('status') === 'signing'  ? 'selected' : '' }}>Chờ ký</option>
                <option value="signed"   {{ request('status') === 'signed'   ? 'selected' : '' }}>Đã ký</option>
                <option value="expired"  {{ request('status') === 'expired'  ? 'selected' : '' }}>Hết hạn</option>
            </select>

            <select class="doc-filter-select" id="filter-sort" onchange="applyFilters()">
                <option value="newest" {{ request('sort','newest') === 'newest' ? 'selected' : '' }}>Mới nhất</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                <option value="name"   {{ request('sort') === 'name'   ? 'selected' : '' }}>Tên A-Z</option>
                <option value="size"   {{ request('sort') === 'size'   ? 'selected' : '' }}>Dung lượng</option>
            </select>

            @if(request()->hasAny(['search','category','status','sort']))
                <a href="{{ route('documents.index') }}" class="doc-btn doc-btn-secondary doc-btn-sm">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Xoá bộ lọc
                </a>
            @endif
        </div>

        {{-- TABLE VIEW --}}
        <div id="view-table">
            <div class="doc-table-wrap">
                @if($documents->isEmpty())
                    <div class="doc-empty">
                        <div class="doc-empty-icon">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                        </div>
                        <div class="doc-empty-title">Chưa có tài liệu nào</div>
                        <div class="doc-empty-desc">
                            @if(request()->hasAny(['search','category','status']))
                                Không tìm thấy tài liệu phù hợp với bộ lọc hiện tại.
                            @else
                                Bắt đầu bằng cách tải lên tài liệu đầu tiên.
                            @endif
                        </div>
                        @if(!request()->hasAny(['search','category','status']))
                            <a href="{{ route('documents.create') }}" class="doc-btn doc-btn-primary" style="margin-top:4px">
                                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Tải lên tài liệu
                            </a>
                        @endif
                    </div>
                @else
                    <table class="doc-table">
                        <thead>
                            <tr>
                                <th style="width:40%">Tài liệu</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Ngày tải lên</th>
                                <th>Hết hạn</th>
                                <th style="width:90px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $doc)
                            <tr onclick="window.location='{{ route('documents.show', $doc) }}'" style="cursor:pointer">
                                <td>
                                    <div class="doc-file-cell">
                                        <div class="doc-file-icon">
                                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        </div>
                                        <div>
                                            <div class="doc-file-name">{{ $doc->file_name }}</div>
                                            <div class="doc-file-meta">
                                                {{ $doc->fileSizeHuman() }}
                                                @if($doc->is_confidential)
                                                    &nbsp;·&nbsp;
                                                    <span style="color:#b45309;font-weight:700">🔒 Mật</span>
                                                @endif
                                                @if($doc->version > 1)
                                                    &nbsp;·&nbsp; v{{ $doc->version }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-size:12px;color:var(--doc-text-muted)">
                                        {{ $doc->category->name ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @include('documents::partials.badge', ['status' => $doc->status])
                                </td>
                                <td>
                                    <span style="font-size:12px;color:var(--doc-text-muted)">
                                        {{ $doc->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if($doc->expires_at)
                                        <span style="font-size:12px;color:{{ $doc->isExpiringSoon(30) ? '#b45309' : 'var(--doc-text-muted)' }};font-weight:{{ $doc->isExpiringSoon(30) ? '700' : '400' }}">
                                            {{ $doc->expires_at->format('d/m/Y') }}
                                            @if($doc->isExpiringSoon(30) && !$doc->isExpired())
                                                <br><span style="font-size:10.5px;color:#b45309">Sắp hết hạn</span>
                                            @elseif($doc->isExpired())
                                                <br><span style="font-size:10.5px;color:#dc2626">Đã hết hạn</span>
                                            @endif
                                        </span>
                                    @else
                                        <span style="font-size:12px;color:var(--doc-text-faint)">—</span>
                                    @endif
                                </td>
                                <td onclick="event.stopPropagation()">
                                    <div class="doc-table-actions">
                                        <a href="{{ route('documents.show', $doc) }}"
                                           class="doc-btn doc-btn-ghost doc-btn-icon"
                                           title="Xem chi tiết">
                                            <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                        </a>
                                        <a href="{{ route('documents.download', $doc) }}"
                                           class="doc-btn doc-btn-ghost doc-btn-icon"
                                           title="Tải xuống">
                                            <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        </a>
                                        @can('update', $doc)
                                        <a href="{{ route('documents.edit', $doc) }}"
                                           class="doc-btn doc-btn-ghost doc-btn-icon"
                                           title="Chỉnh sửa">
                                            <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- PAGINATION --}}
                    @if($documents->hasPages())
                    <div class="doc-pagination">
                        <div class="doc-pagination-info">
                            Hiển thị {{ $documents->firstItem() }}–{{ $documents->lastItem() }}
                            trong tổng số {{ $documents->total() }} tài liệu
                        </div>
                        <div class="doc-pagination-pages">
                            @if($documents->onFirstPage())
                                <button class="doc-page-btn" disabled style="opacity:.4">
                                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                                </button>
                            @else
                                <a href="{{ $documents->previousPageUrl() }}" class="doc-page-btn">
                                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                                </a>
                            @endif

                            @foreach($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                                @if($page == $documents->currentPage())
                                    <button class="doc-page-btn active">{{ $page }}</button>
                                @elseif(abs($page - $documents->currentPage()) <= 2 || $page == 1 || $page == $documents->lastPage())
                                    <a href="{{ $url }}" class="doc-page-btn">{{ $page }}</a>
                                @elseif(abs($page - $documents->currentPage()) == 3)
                                    <span class="doc-page-btn" style="cursor:default">…</span>
                                @endif
                            @endforeach

                            @if($documents->hasMorePages())
                                <a href="{{ $documents->nextPageUrl() }}" class="doc-page-btn">
                                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                </a>
                            @else
                                <button class="doc-page-btn" disabled style="opacity:.4">
                                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif
            </div>
        </div>

        {{-- GRID VIEW (ẩn mặc định) --}}
        <div id="view-grid" style="display:none">
            @if($documents->isEmpty())
                {{-- empty state đã hiển thị ở table view --}}
            @else
                <div class="doc-grid">
                    @foreach($documents as $doc)
                    <div class="doc-card" onclick="window.location='{{ route('documents.show', $doc) }}'">
                        <div class="doc-card-header">
                            <div class="doc-card-icon">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            </div>
                            @include('documents::partials.badge', ['status' => $doc->status])
                        </div>
                        <div>
                            <div class="doc-card-title">{{ $doc->file_name }}</div>
                            <div class="doc-card-meta">
                                {{ $doc->category->name ?? '—' }} · {{ $doc->fileSizeHuman() }}
                            </div>
                        </div>
                        <div class="doc-card-footer">
                            <span style="font-size:11px;color:var(--doc-text-faint)">
                                {{ $doc->created_at->format('d/m/Y') }}
                            </span>
                            <div style="display:flex;gap:4px" onclick="event.stopPropagation()">
                                <a href="{{ route('documents.download', $doc) }}"
                                   class="doc-btn doc-btn-ghost doc-btn-icon doc-btn-sm"
                                   title="Tải xuống">
                                    <svg viewBox="0 0 24 24" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($documents->hasPages())
                <div class="doc-pagination" style="background:var(--doc-white);border:1px solid var(--doc-border);border-radius:var(--doc-radius-lg);margin-top:4px">
                    <div class="doc-pagination-info">
                        {{ $documents->firstItem() }}–{{ $documents->lastItem() }} / {{ $documents->total() }}
                    </div>
                    <div class="doc-pagination-pages">
                        @if(!$documents->onFirstPage())
                            <a href="{{ $documents->previousPageUrl() }}" class="doc-page-btn">
                                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </a>
                        @endif
                        @foreach($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                            @if($page == $documents->currentPage())
                                <button class="doc-page-btn active">{{ $page }}</button>
                            @elseif(abs($page - $documents->currentPage()) <= 2 || $page == 1 || $page == $documents->lastPage())
                                <a href="{{ $url }}" class="doc-page-btn">{{ $page }}</a>
                            @endif
                        @endforeach
                        @if($documents->hasMorePages())
                            <a href="{{ $documents->nextPageUrl() }}" class="doc-page-btn">
                                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        @endif
    </div>

    </div>{{-- end doc-body --}}
</div>

{{-- Flash messages --}}
@if(session('success'))
<div hidden data-nova-toast-message="{{ session('success') }}" data-nova-toast-type="success"></div>
@endif

@if(session('error'))
<div hidden data-nova-toast-message="{{ session('error') }}" data-nova-toast-type="error"></div>
@endif
@endsection

@section('scripts')
    @vite(['app/packages/Nova/document/src/resources/js/app.js'])
<script>
// Toggle table / grid view
const viewTable = document.getElementById('view-table');
const viewGrid  = document.getElementById('view-grid');
const btnToggle = document.getElementById('btn-toggle-view');
const iconView  = document.getElementById('icon-view');

let isGrid = localStorage.getItem('doc-view') === 'grid';

function setView(grid) {
    isGrid = grid;
    localStorage.setItem('doc-view', grid ? 'grid' : 'table');
    viewTable.style.display = grid ? 'none' : 'block';
    viewGrid.style.display  = grid ? 'block' : 'none';
    btnToggle.innerHTML = grid
        ? `<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg> Danh sách`
        : `<svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg> Lưới`;
}

setView(isGrid);
btnToggle.addEventListener('click', () => setView(!isGrid));

// Apply filters (debounced search)
let searchTimer;
document.getElementById('search-input').addEventListener('input', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(applyFilters, 450);
});

function applyFilters() {
    const params = new URLSearchParams(window.location.search);

    const search   = document.getElementById('search-input').value.trim();
    const category = document.getElementById('filter-category').value;
    const status   = document.getElementById('filter-status').value;
    const sort     = document.getElementById('filter-sort').value;
    const tab      = params.get('tab') || '';

    const newParams = new URLSearchParams();
    if (tab)      newParams.set('tab', tab);
    if (search)   newParams.set('search', search);
    if (category) newParams.set('category', category);
    if (status)   newParams.set('status', status);
    if (sort && sort !== 'newest') newParams.set('sort', sort);

    window.location.href = '{{ route('documents.index') }}' + (newParams.toString() ? '?' + newParams.toString() : '');
}

</script>
@endsection
