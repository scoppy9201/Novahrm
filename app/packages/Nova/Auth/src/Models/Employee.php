<?php

namespace Nova\Auth\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\packages\Nova\OrgChart\src\Models\Department;
use App\packages\Nova\Department\src\Models\Position;
use Illuminate\Database\Eloquent\Builder;

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

    // Accessors 

    public function getNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : $this->defaultAvatar();
    }

    private function defaultAvatar(): string
    {
        $initials = strtoupper(
            substr($this->first_name, 0, 1) .
            substr($this->last_name,  0, 1)
        );

        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&background=1d4ed8&color=fff&size=128';
    }

    // Casts 
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
            'department_id'     => 'integer',
            'position_id'       => 'integer',
        ];
    }

    // Relationships 
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    /**
     * Chuỗi báo cáo đệ quy xuống các cấp dưới
     */
    public function subordinatesRecursive(): HasMany
    {
        return $this->subordinates()->with('subordinatesRecursive');
    }

    public function notificationPreference(): HasOne
    {
        return $this->hasOne(
            \App\packages\Nova\Profile\src\Models\NotificationPreference::class,
            'employee_id'
        );
    }

    // Scopes 
    public function scopeActive(Builder $query) : Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeInDepartment(Builder $query, int $departmentId) : Builder
    {
        return $query->where('department_id', $departmentId);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}