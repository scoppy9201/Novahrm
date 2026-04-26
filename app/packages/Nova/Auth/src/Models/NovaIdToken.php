<?php

namespace Nova\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class NovaIdToken extends Model
{
    public $timestamps = false;

    protected $table = 'nova_id_tokens';

    protected $fillable = [
        'email',
        'token',
        'otp',
        'type',
        'used',
        'expires_at',
        'created_at',
    ];

    protected $casts = [
        'used'       => 'boolean',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isValid(): bool
    {
        return ! $this->used && ! $this->isExpired();
    }
}