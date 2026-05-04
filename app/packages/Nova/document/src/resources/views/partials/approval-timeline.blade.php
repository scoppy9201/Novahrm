{{-- partials/approval-timeline.blade.php --}}
{{-- Usage: @include('document::partials.approval-timeline', ['approvals' => $document->approvals]) --}}

<div class="doc-detail-card">
    <div class="doc-detail-card-head">
        <div class="doc-detail-card-title">@lang('documents::app.timeline.title')</div>
        <span style="font-size:11px;color:var(--doc-text-faint);font-weight:600">
            {{ __('documents::app.timeline.count', ['count' => $approvals->count()]) }}
        </span>
    </div>
    <div class="doc-detail-card-body">

        @if($approvals->isEmpty())
        <div style="text-align:center;padding:20px 0;color:var(--doc-text-faint);font-size:12.5px">
            @lang('documents::app.timeline.empty')
        </div>
        @else
        <div class="doc-timeline">
            @foreach($approvals as $approval)
            @php
                $dotConfig = match($approval->action) {
                    'submitted'          => ['class' => 'doc-tl-submitted',  'icon' => '<line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>'],
                    'approved'           => ['class' => 'doc-tl-approved',   'icon' => '<polyline points="20 6 9 17 4 12"/>'],
                    'rejected'           => ['class' => 'doc-tl-rejected',   'icon' => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>'],
                    'revision_requested' => ['class' => 'doc-tl-revision',   'icon' => '<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>'],
                    default              => ['class' => 'doc-tl-submitted',  'icon' => '<circle cx="12" cy="12" r="10"/>'],
                };
            @endphp

            <div class="doc-timeline-item">
                <div class="doc-timeline-left">
                    <div class="doc-timeline-dot {{ $dotConfig['class'] }}">
                        <svg viewBox="0 0 24 24">{!! $dotConfig['icon'] !!}</svg>
                    </div>
                    <div class="doc-timeline-line"></div>
                </div>

                <div class="doc-timeline-content">
                    <div class="doc-tl-actor">
                        {{ $approval->actor->name ?? __('documents::app.timeline.system') }}
                    </div>
                    <div class="doc-tl-action">
                        {{ $approval->action_label }}
                    </div>
                    @if($approval->note)
                    <div class="doc-tl-note">{{ $approval->note }}</div>
                    @endif
                    <div class="doc-tl-time">
                        {{ $approval->created_at->format('H:i · d/m/Y') }}
                        <span style="margin-left:6px;color:var(--doc-text-faint)">
                            ({{ $approval->created_at->diffForHumans() }})
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>
