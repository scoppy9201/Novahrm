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

    const EMPLOYMENT_TYPES = [
        'full_time'  => 'Toàn thời gian',
        'part_time'  => 'Bán thời gian',
        'contract'   => 'Hợp đồng',
        'intern'     => 'Thực tập sinh',
        'probation'  => 'Thử việc',
        'freelance'  => 'Cộng tác viên',
    ];

    const CONTRACT_TYPES = [
        'indefinite'     => 'Không xác định thời hạn',
        'fixed_term_1y'  => 'Hợp đồng 1 năm',
        'fixed_term_2y'  => 'Hợp đồng 2 năm',
        'fixed_term_3y'  => 'Hợp đồng 3 năm',
        'seasonal'       => 'Thời vụ',
        'probation'      => 'Thử việc',
        'internship'     => 'Thực tập',
    ];

    const STATUSES = [
        'active'          => 'Đang làm việc',
        'probation'       => 'Thử việc',
        'on_leave'        => 'Đang nghỉ phép',
        'maternity_leave' => 'Nghỉ thai sản',
        'paternity_leave' => 'Nghỉ thai sản (bố)',
        'sick_leave'      => 'Nghỉ ốm',
        'suspended'       => 'Tạm đình chỉ',
        'resigned'        => 'Đã nghỉ việc',
        'terminated'      => 'Bị sa thải',
        'retired'         => 'Nghỉ hưu',
        'deceased'        => 'Đã mất',
    ];

    const TERMINATION_TYPES = [
        'voluntary'       => 'Tự nguyện nghỉ',
        'involuntary'     => 'Bị buộc thôi việc',
        'retirement'      => 'Nghỉ hưu',
        'end_of_contract' => 'Hết hợp đồng',
        'deceased'        => 'Qua đời',
    ];

    const EDUCATION_LEVELS = [
        'none'        => 'Không có',
        'primary'     => 'Tiểu học',
        'secondary'   => 'THCS',
        'high_school' => 'THPT',
        'college'     => 'Cao đẳng',
        'bachelor'    => 'Đại học',
        'master'      => 'Thạc sĩ',
        'phd'         => 'Tiến sĩ',
    ];

    const GENDERS = [
        'male'   => 'Nam',
        'female' => 'Nữ',
        'other'  => 'Khác',
    ];

    // Fillable 
    protected $fillable = [
        'employee_code',
        'first_name', 'last_name',
        'email', 'phone', 'password', 'remember_token', 'email_verified_at',
        'national_id', 'kra_pin',
        'emergency_contact_name', 'emergency_contact_phone',
        'date_of_birth', 'gender', 'marital_status',
        'department_id', 'position_id', 'manager_id',
        'employment_type', 'hire_date', 'termination_date', 'is_active',
        'next_of_kin_name', 'next_of_kin_relationship', 'next_of_kin_phone', 'next_of_kin_email',
        'avatar', 'language', 'address',
        'job_title', 'occupation', 'office', 'office_id',
        'email_personal', 'bio', 'role',

        // Thông tin cá nhân bổ sung
        'place_of_birth', 'nationality', 'ethnicity', 'religion',
        'national_id_issued_date', 'national_id_issued_place',
        'passport_number', 'passport_expiry_date',

        // Liên hệ bổ sung
        'work_email', 'phone_alt', 'emergency_contact_relation',

        // Địa chỉ chi tiết
        'permanent_address', 'permanent_ward', 'permanent_district', 'permanent_province',
        'current_address', 'current_ward', 'current_district', 'current_province',

        // Công việc bổ sung
        'probation_start_date', 'probation_end_date', 'official_start_date',

        // Hợp đồng
        'contract_type', 'contract_number',
        'contract_start_date', 'contract_end_date', 'contract_renewal_count',

        // Lương & tài chính
        'basic_salary', 'salary_type',
        'bank_name', 'bank_account', 'bank_branch', 'bank_account_name',
        'tax_code', 'social_insurance_code', 'health_insurance_code',
        'health_insurance_place', 'social_insurance_start_date',

        // Học vấn
        'education_level', 'education_major', 'education_school',

        // Trạng thái mở rộng
        'status', 'termination_reason', 'termination_type',

        // Media & misc
        'cv_path', 'signature_path', 'meta',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['name', 'avatar_url'];

    protected $rememberTokenName = 'remember_token';

    // Casts 
    protected function casts(): array
    {
        return [
            // Cũ
            'email_verified_at'  => 'datetime',
            'hire_date'          => 'date',
            'termination_date'   => 'date',
            'date_of_birth'      => 'date',
            'is_active'          => 'boolean',
            'password'           => 'hashed',
            'office_id'          => 'integer',
            'manager_id'         => 'integer',
            'department_id'      => 'integer',
            'position_id'        => 'integer',

            // Mới
            'national_id_issued_date'    => 'date',
            'passport_expiry_date'       => 'date',
            'probation_start_date'       => 'date',
            'probation_end_date'         => 'date',
            'official_start_date'        => 'date',
            'contract_start_date'        => 'date',
            'contract_end_date'          => 'date',
            'social_insurance_start_date'=> 'date',
            'basic_salary'               => 'integer',
            'contract_renewal_count'     => 'integer',
            'meta'                       => 'array',
        ];
    }

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

    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth?->age;
    }

    public function getTenureAttribute(): ?string
    {
        if (!$this->hire_date) return null;
        $diff = $this->hire_date->diff(now());
        if ($diff->y > 0) return "{$diff->y} năm {$diff->m} tháng";
        if ($diff->m > 0) return "{$diff->m} tháng";
        return "{$diff->d} ngày";
    }

    public function getIsContractExpiringAttribute(): bool
    {
        return $this->contract_end_date
            && $this->contract_end_date->between(now(), now()->addDays(30));
    }

    public function getIsProbationEndingAttribute(): bool
    {
        return $this->probation_end_date
            && $this->probation_end_date->between(now(), now()->addDays(7));
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getEmploymentTypeLabelAttribute(): string
    {
        return self::EMPLOYMENT_TYPES[$this->employment_type] ?? $this->employment_type;
    }

    private function defaultAvatar(): string
    {
        $initials = strtoupper(
            substr($this->first_name, 0, 1) .
            substr($this->last_name,  0, 1)
        );
        return 'https://ui-avatars.com/api/?name=' . urlencode($initials) . '&background=1d4ed8&color=fff&size=128';
    }

    // Scopes 
    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true);
    }

    public function scopeInactive(Builder $q): Builder
    {
        return $q->where('is_active', false);
    }

    public function scopeInDepartment(Builder $q, int $departmentId): Builder
    {
        return $q->where('department_id', $departmentId);
    }

    public function scopeByStatus(Builder $q, string $status): Builder
    {
        return $q->where('status', $status);
    }

    public function scopeHiredThisMonth(Builder $q): Builder
    {
        return $q->whereMonth('hire_date', now()->month)
                 ->whereYear('hire_date', now()->year);
    }

    public function scopeContractExpiringSoon(Builder $q, int $days = 30): Builder
    {
        return $q->whereBetween('contract_end_date', [now(), now()->addDays($days)]);
    }

    public function scopeProbationEnding(Builder $q, int $days = 7): Builder
    {
        return $q->whereBetween('probation_end_date', [now(), now()->addDays($days)]);
    }

    // Relationships 
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function subordinates(): HasMany
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

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

    // Sẵn sàng mở rộng sau
    // public function contracts(): HasMany { ... }
    // public function leaveRequests(): HasMany { ... }
    // public function attendances(): HasMany { ... }
    // public function payslips(): HasMany { ... }
    // public function documents(): HasMany { ... }
}