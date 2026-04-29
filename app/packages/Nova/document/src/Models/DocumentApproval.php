<?php

namespace App\packages\Nova\document\src\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentApproval extends Model
{
    protected $fillable = ['document_id', 'actor_id', 'action', 'note'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function actor()
    {
        return $this->belongsTo(\Nova\Auth\Models\Employee::class, 'actor_id');
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'submitted'          => 'Đã gửi duyệt',
            'approved'           => 'Đã duyệt',
            'rejected'           => 'Từ chối',
            'revision_requested' => 'Yêu cầu chỉnh sửa',
            default              => $this->action,
        };
    }
}