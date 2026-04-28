<?php

namespace App\packages\Nova\OrgChart\src\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Auth\Models\Employee;  

class Department extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'manager_id',
        'parent_id',
        'order',
        'color',
    ];

    protected $casts = [
        'manager_id' => 'integer',
        'parent_id'  => 'integer',
        'order'      => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id')
                    ->orderBy('order');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id'); 
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'department_id'); 
    }


    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function getTotalEmployeeCountAttribute(): int
    {
        $count = $this->employees()->count();

        foreach ($this->children as $child) {
            $count += $child->total_employee_count;
        }

        return $count;
    }
}