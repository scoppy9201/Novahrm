@php
$map = [
    'draft'    => ['label' => 'Nháp',      'class' => 'doc-badge-draft'],
    'pending'  => ['label' => 'Chờ duyệt', 'class' => 'doc-badge-pending'],
    'approved' => ['label' => 'Đã duyệt',  'class' => 'doc-badge-approved'],
    'rejected' => ['label' => 'Từ chối',   'class' => 'doc-badge-rejected'],
    'signing'  => ['label' => 'Chờ ký',    'class' => 'doc-badge-signing'],
    'signed'   => ['label' => 'Đã ký',     'class' => 'doc-badge-signed'],
    'expired'  => ['label' => 'Hết hạn',   'class' => 'doc-badge-expired'],
];
$badge = $map[$status] ?? ['label' => $status, 'class' => 'doc-badge-draft'];
@endphp

<span class="doc-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>