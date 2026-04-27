<?php

namespace Nova\Auth\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'remember_token',
        'email_verified_at',
        'national_id',
        'kra_pin',
        'emergency_contact_name',
        'emergency_contact_phone',
        'date_of_birth',
        'gender',
        'marital_status',
        'department_id',
        'position_id',
        'employment_type',
        'hire_date',
        'termination_date',
        'is_active',
        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_phone',
        'next_of_kin_email',
        'avatar',
        'language',
        'address',
        'job_title',
        'occupation',
        'office',
        'office_id',
        'manager_id',
        'email_personal',
        'bio',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['name'];

    protected $rememberTokenName = 'remember_token';

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'hire_date'         => 'date',
            'termination_date'  => 'date',
            'date_of_birth'     => 'date',
            'is_active'         => 'boolean',
            'password'          => 'hashed',
            'office_id'         => 'integer',
            'manager_id'        => 'integer',
        ];
    }

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }
}