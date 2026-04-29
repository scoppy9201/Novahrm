<?php

namespace App\packages\Nova\document\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DocumentCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon',
        'color', 'requires_approval', 'requires_signature',
        'access_level', 'order', 'is_active',
    ];

    protected $casts = [
        'requires_approval'  => 'boolean',
        'requires_signature' => 'boolean',
        'is_active'          => 'boolean',
    ];

    // Auto tạo slug từ name
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'category_id');
    }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    public function scopePersonal($query)
    {
        return $query->where('access_level', 'personal');
    }

    public function scopeCompany($query)
    {
        return $query->where('access_level', 'company');
    }
}