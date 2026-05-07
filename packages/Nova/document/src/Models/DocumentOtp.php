<?php

namespace Nova\document\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentOtp extends Model
{
    protected $fillable = [
        'document_id', 'employee_id', 'otp', 'expires_at', 'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used'    => 'boolean',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function employee()
    {
        return $this->belongsTo(\Nova\Auth\Models\Employee::class);
    }
}