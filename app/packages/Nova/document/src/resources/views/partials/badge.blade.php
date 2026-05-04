@php
$map = [
    'draft'    => ['label' => __('documents::app.statuses.draft'),    'class' => 'doc-badge-draft'],
    'pending'  => ['label' => __('documents::app.statuses.pending'),  'class' => 'doc-badge-pending'],
    'approved' => ['label' => __('documents::app.statuses.approved'), 'class' => 'doc-badge-approved'],
    'rejected' => ['label' => __('documents::app.statuses.rejected'), 'class' => 'doc-badge-rejected'],
    'signing'  => ['label' => __('documents::app.statuses.signing'),  'class' => 'doc-badge-signing'],
    'signed'   => ['label' => __('documents::app.statuses.signed'),   'class' => 'doc-badge-signed'],
    'expired'  => ['label' => __('documents::app.statuses.expired'),  'class' => 'doc-badge-expired'],
];
$badge = $map[$status] ?? ['label' => $status, 'class' => 'doc-badge-draft'];
@endphp

<span class="doc-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
