<?php

namespace Nova\document\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentSignature extends Model
{
    protected $fillable = [
        'document_id', 'employee_id', 'signature_image',
        'ip_address', 'user_agent', 'otp',
        'otp_sent_at', 'otp_verified_at', 'signed_at',
        'page_number', 'pos_x', 'pos_y', 'width', 'height',
    ];

    protected $casts = [
        'otp_sent_at'      => 'datetime',
        'otp_verified_at'  => 'datetime',
        'signed_at'        => 'datetime',
    ];

    protected $hidden = ['otp', 'signature_image']; // không expose ra API

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function employee()
    {
        return $this->belongsTo(\Nova\Auth\Models\Employee::class);
    }
}