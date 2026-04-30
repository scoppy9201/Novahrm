<?php

namespace App\packages\Nova\Department\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\packages\Nova\OrgChart\src\Models\Department;
use Nova\Auth\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

class Position extends Model
{
    use SoftDeletes;

    protected $table = 'positions';

    protected $fillable = [
        'title',
        'code',
        'description',
        'department_id',
        'level',
        'salary',
        'salary_min',
        'salary_max',
        'headcount_plan',
        'status',
    ];

    protected $casts = [
        'department_id'  => 'integer',
        'headcount_plan' => 'integer',
        'salary'         => 'decimal:2',
        'salary_min'     => 'decimal:2',
        'salary_max'     => 'decimal:2',
    ];

    // Level labels dùng cho hiển thị UI
    const LEVELS = [
        'intern'   => 'Thực tập sinh',
        'junior'   => 'Junior',
        'mid'      => 'Middle',
        'senior'   => 'Senior',
        'lead'     => 'Team Lead',
        'manager'  => 'Manager',
        'director' => 'Director',
    ];

    // Scopes
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDepartment(Builder $query, int $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByLevel(Builder $query, string $level)
    {
        return $query->where('level', $level);
    }

    // Accessors

    /**
     * Label hiển thị của level, VD: "senior" → "Senior"
     */
    public function getLevelLabelAttribute(): string
    {
        return self::LEVELS[$this->level] ?? ucfirst($this->level ?? '');
    }

    /**
     * Số chỗ còn trống = headcount_plan - số nhân viên đang giữ vị trí này
     */
    public function getOpenSlotsAttribute(): int
    {
        if ($this->headcount_plan === 0) {
            return 0; // 0 = không giới hạn
        }

        return max(0, $this->headcount_plan - $this->employees()->count());
    }

    /**
     * Khung lương dạng chuỗi, VD: "10,000,000 – 20,000,000"
     */
    public function getSalaryRangeAttribute(): ?string
    {
        if (! $this->salary_min && ! $this->salary_max) {
            return null;
        }

        $fmt = fn($v) => number_format($v, 0, ',', '.');

        if ($this->salary_min && $this->salary_max) {
            return $fmt($this->salary_min) . ' – ' . $fmt($this->salary_max);
        }

        return $fmt($this->salary_min ?? $this->salary_max);
    }

    // Relationships
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'position_id');
    }
}
