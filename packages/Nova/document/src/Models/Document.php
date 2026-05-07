<?php

namespace Nova\document\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\document\Models\DocumentCategory;
use Nova\document\Models\DocumentApproval;
use Nova\document\Models\DocumentSignature;
use Nova\document\Models\DocumentOtp;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'title', 'description',
        'file_path', 'file_name', 'file_mime', 'file_size',
        'signed_file_path', 'uploaded_by', 'employee_id',
        'status', 'approved_by', 'approved_at', 'rejection_reason',
        'issued_at', 'expires_at', 'tags',
        'is_confidential', 'version',
    ];

    protected $casts = [
        'tags'           => 'array',
        'is_confidential'=> 'boolean',
        'approved_at'    => 'datetime',
        'issued_at'      => 'date',
        'expires_at'     => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(DocumentCategory::class, 'category_id');
    }

    public function uploader()
    {
        return $this->belongsTo(\Nova\Auth\Models\Employee::class, 'uploaded_by');
    }

    public function employee()
    {
        return $this->belongsTo(\Nova\Auth\Models\Employee::class, 'employee_id');
    }

    public function approver()
    {
        return $this->belongsTo(\Nova\Auth\Models\Employee::class, 'approved_by');
    }

    public function approvals()
    {
        return $this->hasMany(DocumentApproval::class)->latest();
    }

    public function signatures()
    {
        return $this->hasMany(DocumentSignature::class);
    }

    public function otps()
    {
        return $this->hasMany(DocumentOtp::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeSigned($query)
    {
        return $query->where('status', 'signed');
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('expires_at')
                     ->whereBetween('expires_at', [now(), now()->addDays($days)]);
    }

    public function scopeForEmployee($query, int $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeCompanyWide($query)
    {
        return $query->whereNull('employee_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->expires_at
            && $this->expires_at->isFuture()
            && $this->expires_at->diffInDays(now()) <= $days;
    }

    public function isSigned(): bool
    {
        return $this->status === 'signed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeSigned(): bool
    {
        return in_array($this->status, ['signing', 'approved'])
            && $this->category?->requires_signature;
    }

    public function fileSizeHuman(): string
    {
        $bytes = $this->file_size;
        if ($bytes < 1024)       return $bytes . ' B';
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }
}