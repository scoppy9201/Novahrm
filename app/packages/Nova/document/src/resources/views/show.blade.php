@extends('nova-dashboard::layouts')

@section('title', $document->file_name . ' — NovaHRM')

@section('styles')
    @vite([
        'app/packages/Nova/Dashboard/src/resources/css/app.css',
        'app/packages/Nova/Document/src/resources/css/app.css',
    ])
@endsection

@section('content')
@php $signature = $document->signatures->first() @endphp
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
                    <span>{{ Str::limit($document->file_name, 40) }}</span>
                </div>
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="doc-page-title">{{ $document->file_name }}</div>
                    @include('documents::partials.badge', ['status' => $document->status])
                    @if($document->is_confidential)
                        <span style="font-size:11px;color:#b45309;font-weight:700;
                            background:#fffbeb;border:1px solid #fde68a;
                            padding:2px 8px;border-radius:20px">
                            🔒 @lang('documents::app.common.confidential')
                        </span>
                    @endif
                </div>
            </div>

            <div class="doc-topbar-actions">
                {{-- Gửi duyệt --}}
                @if($document->status === 'draft')
                    <form method="POST" action="{{ route('documents.submit', $document) }}" style="display:inline">
                        @csrf
                        <button type="submit" class="doc-btn doc-btn-secondary">
                            <svg viewBox="0 0 24 24" stroke="currentColor"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            @lang('documents::app.show.submit')
                        </button>
                    </form>
                @endif

                {{-- Duyệt / Từ chối --}}
                @if($document->status === 'pending')
                    @can('approve', $document)
                    <button class="doc-btn doc-btn-success" onclick="openModal('modal-approve')">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        @lang('documents::app.show.approve')
                    </button>
                    <button class="doc-btn doc-btn-danger" onclick="openModal('modal-reject')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        @lang('documents::app.show.reject')
                    </button>
                    @endcan
                @endif

                {{-- Ký tài liệu --}}
                @if(in_array($document->status, ['signing', 'approved']) && $document->category?->requires_signature && !$document->isSigned())
                <button class="doc-btn doc-btn-primary" 
                    onclick="document.getElementById('signature-pad-card').scrollIntoView({behavior:'smooth'});document.getElementById('signature-pad-card').style.boxShadow='0 0 0 2px var(--doc-primary)';">
                    <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    @lang('documents::app.show.sign')
                </button>
                @endif

                {{-- Download --}}
                <a href="{{ route('documents.download', ['document' => $document, 'type' => $document->signed_file_path ? 'signed' : 'original']) }}" 
                class="doc-btn doc-btn-secondary">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    @lang('documents::app.show.download')
                </a>

                {{-- Edit --}}
                @can('update', $document)
                <a href="{{ route('documents.edit', $document) }}" class="doc-btn doc-btn-secondary">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    @lang('documents::app.show.edit')
                </a>
                @endcan

                {{-- Xoá --}}
                @can('delete', $document)
                <button class="doc-btn doc-btn-danger" onclick="openModal('modal-delete')">
                    <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                </button>
                @endcan
            </div>
        </div>
    </header>

    {{-- BODY --}}
    <div class="doc-body">

        @if(session('success'))
        <div hidden data-nova-toast-message="{{ session('success') }}" data-nova-toast-type="success"></div>
        @endif

        @if(session('error'))
        <div hidden data-nova-toast-message="{{ session('error') }}" data-nova-toast-type="error"></div>
        @endif

        <div class="doc-detail-layout">

            {{-- LEFT: PDF Preview + Timeline --}}
            <div style="display:flex;flex-direction:column;gap:16px">

                {{-- PDF Preview --}}
                <div class="doc-detail-card">
                    <div class="doc-detail-card-head">
                        <div class="doc-detail-card-title">@lang('documents::app.show.preview')</div>
                        <div style="display:flex;gap:8px;align-items:center">
                            <span style="font-size:11px;color:var(--doc-text-faint)">
                                {{ $document->fileSizeHuman() }}
                            </span>
                            <a href="{{ route('documents.download', ['document' => $document, 'type' => $document->signed_file_path ? 'signed' : 'original']) }}" 
                            class="doc-btn doc-btn-secondary">
                                <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                @lang('documents::app.show.download')
                            </a>
                        </div>
                    </div>
                    <div class="doc-detail-card-body" style="padding:12px">
                        <div class="doc-pdf-preview">
                            <iframe
                                src="{{ route('documents.preview', $document) }}#toolbar=0&view=FitH"
                                title="{{ $document->file_name }}"
                                loading="lazy"
                                style="width:100%;height:100%;border:none;">
                            </iframe>
                        </div>
                        @if($document->signed_file_path && $document->file_path)
                        <div style="text-align:center;margin-top:10px">
                            <a href="{{ route('documents.preview', ['document' => $document, 'type' => 'original']) }}"
                            target="_blank"
                            style="font-size:11.5px;color:var(--doc-primary);font-weight:600;text-decoration:none">
                                @lang('documents::app.show.original_file')
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Lịch sử phê duyệt --}}
                @if($document->approvals->isNotEmpty() || $document->category?->requires_approval)
                @include('documents::partials.approval-timeline', ['approvals' => $document->approvals])
                @endif

            </div>

            {{-- RIGHT: Sidebar --}}
            <div style="display:flex;flex-direction:column;gap:16px">

                {{-- Thông tin tài liệu --}}
                @include('documents::partials.doc-meta', ['document' => $document])

                {{-- Chữ ký --}}
                @if($signature)
                <div class="doc-detail-card">
                    <div class="doc-detail-card-head">
                        <div class="doc-detail-card-title">@lang('documents::app.show.signature_title')</div>
                        <span class="doc-badge doc-badge-signed">@lang('documents::app.show.signed')</span>
                    </div>
                    <div class="doc-detail-card-body">
                        @if($signature->signature_image)
                        <div style="background:var(--doc-surface);border:1px solid var(--doc-border);
                                    border-radius:var(--doc-radius-md);padding:12px;text-align:center;margin-bottom:12px">
                            <img src="{{ $signature->signature_image }}"
                                 alt="@lang('documents::app.show.signature_title')"
                                 style="max-width:100%;max-height:80px;object-fit:contain"/>
                        </div>
                        @endif
                        <div class="doc-meta-row">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/></svg>
                            <div>
                                <div class="doc-meta-label">@lang('documents::app.show.signer')</div>
                                <div class="doc-meta-val">{{ $signature->employee->name ?? __('documents::app.common.none') }}</div>
                            </div>
                        </div>
                        <div class="doc-meta-row">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <div>
                                <div class="doc-meta-label">@lang('documents::app.show.signed_at')</div>
                                <div class="doc-meta-val">
                                    {{ $signature->signed_at?->format('H:i · d/m/Y') ?? __('documents::app.common.none') }}
                                </div>
                            </div>
                        </div>
                        <div class="doc-meta-row">
                            <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                            <div>
                                <div class="doc-meta-label">@lang('documents::app.show.device')</div>
                                <div class="doc-meta-val" style="font-size:11px;word-break:break-word">
                                    {{ Str::limit($signature->user_agent ?? __('documents::app.common.none'), 60) }}
                                </div>
                            </div>
                        </div>
                        <div class="doc-meta-row">
                            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            <div>
                                <div class="doc-meta-label">@lang('documents::app.show.ip_address')</div>
                                <div class="doc-meta-val">{{ $signature->ip_address ?? __('documents::app.common.none') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Ký tài liệu panel --}}
                @if(in_array($document->status, ['signing','approved']) && !$document->isSigned())
                    @include('documents::partials.signature-pad', ['document' => $document])
                @endif

            </div>
        </div>
    </div>
</div>

@can('approve', $document)
@include('documents::partials.modals.modal-approve', ['document' => $document])
@include('documents::partials.modals.modal-reject',  ['document' => $document])
@endcan

@include('documents::partials.modals.modal-delete', ['document' => $document])

@if(!$document->isSigned())
@include('documents::partials.modals.modal-otp', ['document' => $document])
@endif

@endsection

@section('scripts')
    @vite(['app/packages/Nova/document/src/resources/js/app.js'])
<script>
function openModal(id) {
    document.getElementById(id)?.classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id)?.classList.remove('open');
    document.body.style.overflow = '';
}

document.querySelectorAll('.doc-modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) {
        if (e.target === this) closeModal(this.id);
    });
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.doc-modal-overlay.open').forEach(el => closeModal(el.id));
    }
});
</script>
@endsection
