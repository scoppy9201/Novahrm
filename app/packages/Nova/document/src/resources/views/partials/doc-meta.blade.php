{{-- partials/doc-meta.blade.php --}}
{{-- Usage: @include('document::partials.doc-meta', ['document' => $document]) --}}

<div class="doc-detail-card">
    <div class="doc-detail-card-head">
        <div class="doc-detail-card-title">Thông tin tài liệu</div>
    </div>
    <div class="doc-detail-card-body">

        {{-- Danh mục --}}
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
            <div>
                <div class="doc-meta-label">Danh mục</div>
                <div class="doc-meta-val">{{ $document->category->name ?? '—' }}</div>
            </div>
        </div>

        {{-- Nhân viên --}}
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <div>
                <div class="doc-meta-label">Nhân viên</div>
                <div class="doc-meta-val">
                    @if($document->employee)
                        {{ $document->employee->name }}
                        <span style="font-size:10.5px;color:var(--doc-text-faint);display:block">
                            {{ $document->employee->employee_code }}
                        </span>
                    @else
                        <span style="color:var(--doc-text-faint)">Tài liệu công ty</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Dung lượng --}}
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <div>
                <div class="doc-meta-label">File</div>
                <div class="doc-meta-val">
                    {{ $document->file_mime === 'application/pdf' ? 'PDF' : $document->file_mime }}
                    · {{ $document->fileSizeHuman() }}
                    @if($document->version > 1)
                        · v{{ $document->version }}
                    @endif
                </div>
            </div>
        </div>

        {{-- Ngày ban hành --}}
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <div>
                <div class="doc-meta-label">Ngày ban hành</div>
                <div class="doc-meta-val">
                    {{ $document->issued_at ? $document->issued_at->format('d/m/Y') : '—' }}
                </div>
            </div>
        </div>

        {{-- Ngày hết hạn --}}
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <div>
                <div class="doc-meta-label">Ngày hết hạn</div>
                <div class="doc-meta-val">
                    @if($document->expires_at)
                        <span style="color:{{ $document->isExpired() ? '#dc2626' : ($document->isExpiringSoon(30) ? '#b45309' : 'var(--doc-text-base)') }};font-weight:{{ $document->isExpiringSoon(30) ? '700' : '600' }}">
                            {{ $document->expires_at->format('d/m/Y') }}
                        </span>
                        @if($document->isExpired())
                            <span style="font-size:10.5px;color:#dc2626;display:block;font-weight:700">Đã hết hạn</span>
                        @elseif($document->isExpiringSoon(30))
                            <span style="font-size:10.5px;color:#b45309;display:block;font-weight:700">
                                Còn {{ (int) now()->diffInDays($document->expires_at) }} ngày
                            </span>
                        @endif
                    @else
                        <span style="color:var(--doc-text-faint)">Không giới hạn</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tải lên lúc --}}
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            <div>
                <div class="doc-meta-label">Tải lên lúc</div>
                <div class="doc-meta-val">{{ $document->created_at->format('H:i · d/m/Y') }}</div>
            </div>
        </div>

        {{-- Luồng xử lý --}}
        @if($document->category)
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <div>
                <div class="doc-meta-label">Luồng xử lý</div>
                <div class="doc-meta-val" style="font-size:11.5px">
                    @if($document->category->requires_approval)
                        <span style="color:#15803d">✓ Cần phê duyệt</span><br>
                    @else
                        <span style="color:var(--doc-text-faint)">— Không cần duyệt</span><br>
                    @endif
                    @if($document->category->requires_signature)
                        <span style="color:#1d4ed8">✓ Cần ký số</span>
                    @else
                        <span style="color:var(--doc-text-faint)">— Không cần ký</span>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Tags --}}
        @if($document->tags && count($document->tags))
        <div class="doc-meta-row">
            <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            <div>
                <div class="doc-meta-label">Tags</div>
                <div class="doc-tags-wrap" style="margin-top:6px">
                    @foreach($document->tags as $tag)
                        <span class="doc-tag">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

    </div>
</div>