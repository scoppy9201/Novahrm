<?php

namespace App\packages\Nova\OrgChart\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\Auth\Models\Employee;
use App\packages\Nova\Department\src\Models\Position;
use Illuminate\Database\Eloquent\Builder;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'code',
        'description',
        'parent_id',
        'manager_id',
        'order',
        'color',
        'status',
    ];

    protected $casts = [
        'parent_id'  => 'integer',
        'manager_id' => 'integer',
        'order'      => 'integer',
    ];

    // Scopes
    public function scopeActive(Builder $query) : Builder
    {
        return $query->where('status', 'active');
    }

    // Accessors
    /**
     * Số nhân viên thực tế (chỉ phòng này, không tính phòng con)
     */
    public function getEmployeeCountAttribute(): int
    {
        return $this->employees()->count();
    }

    /**
     * Số nhân viên toàn cây (phòng này + tất cả phòng con đệ quy)
     */
    public function getTotalEmployeeCountAttribute(): int
    {
        $count = $this->employees()->count();

        foreach ($this->children as $child) {
            $count += $child->total_employee_count;
        }

        return $count;
    }

    /**
     * Số vị trí còn thiếu người (tổng headcount_plan - số nhân viên thực)
     */
    public function getOpenHeadcountAttribute(): int
    {
        $plan  = $this->positions()->sum('headcount_plan');
        $atual = $this->employees()->count();

        return max(0, $plan - $atual);
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id')
                    ->orderBy('order');
    }

    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class, 'department_id');
    }
}