<?php

namespace Nova\OrgChart\Services;

use Nova\Auth\Models\Employee;
use Nova\OrgChart\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\UniqueConstraintViolationException;

class OrgChartService
{
    public function getTree(): array
    {
        $departments = Department::with([
            'manager:id,first_name,last_name,avatar,job_title',
            'employees:id,first_name,last_name,avatar,job_title,department_id,manager_id,is_active',
        ])
        ->whereNull('parent_id')
        ->orderBy('order')
        ->get();

        return $departments->map(fn($dept) => $this->buildDeptNode($dept))->toArray();
    }

    public function create(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            if (empty($data['order'])) {
                $data['order'] = Department::where('parent_id', $data['parent_id'] ?? null)
                    ->max('order') + 1;
            }

            try {
                return Department::create($data);
            } catch (UniqueConstraintViolationException) {
                throw new \InvalidArgumentException(
                    'Phòng ban "' . $data['name'] . '" đã tồn tại trong cùng phòng ban cha.'
                );
            }
        });
    }

    public function update(Department $department, array $data): Department
    {
        return DB::transaction(function () use ($department, $data) {
            if (!empty($data['parent_id'])) {
                if ($this->isDescendant($department, (int) $data['parent_id'])) {
                    throw new \InvalidArgumentException('Không thể chọn phòng ban con làm phòng ban cha.');
                }
            }

            try {
                $department->update($data);
                return $department->fresh(['manager', 'parent']);
            } catch (UniqueConstraintViolationException) {
                throw new \InvalidArgumentException(
                    'Phòng ban "' . $data['name'] . '" đã tồn tại trong cùng phòng ban cha.'
                );
            }
        });
    }

    public function delete(Department $department): void
    {
        if ($department->children()->exists()) {
            throw new \RuntimeException('Không thể xóa phòng ban vì còn phòng ban con.');
        }

        if ($department->employees()->exists()) {
            throw new \RuntimeException('Không thể xóa phòng ban vì còn nhân viên.');
        }

        $department->delete();
    }

    public function move(Department $department, array $data): void
    {
        if (!empty($data['parent_id'])) {
            $descendantIds = $this->getDescendantIds($department);
            if (in_array($data['parent_id'], $descendantIds) || $data['parent_id'] == $department->id) {
                throw new \InvalidArgumentException('Không thể di chuyển phòng ban vào chính nó hoặc phòng ban con của nó.');
            }
        }

        $department->update(['parent_id' => $data['parent_id'] ?? null]);
    }

    public function getEmployeeChain(Employee $employee): array
    {
        $chain   = [];
        $current = $employee->load('department:id,name');

        while ($current) {
            $chain[] = [
                'id'         => $current->id,
                'name'       => $current->name,
                'avatar'     => $current->avatar_url,
                'job_title'  => $current->job_title,
                'department' => $current->department?->name,
            ];

            $current = $current->manager_id
                ? Employee::with('department:id,name')->find($current->manager_id)
                : null;
        }

        return $chain;
    }

    private function buildDeptNode(Department $dept, int $depth = 0): array
    {
        $dept->load([
            'children.manager:id,first_name,last_name,avatar,job_title',
            'children.employees:id,first_name,last_name,avatar,job_title,department_id,manager_id,is_active',
        ]);

        return [
            'id'             => $dept->id,
            'type'           => 'department',
            'name'           => $dept->name,
            'code'           => $dept->code,
            'color'          => $dept->color,
            'depth'          => $depth,
            'parent_id'      => $dept->parent_id,
            'description'    => $dept->description,
            'employee_count' => $dept->employees->count(),
            'manager'        => $dept->manager ? [
                'id'        => $dept->manager->id,
                'name'      => $dept->manager->name,
                'avatar'    => $dept->manager->avatar_url,
                'job_title' => $dept->manager->job_title,
            ] : null,
            'employees'      => $dept->employees->map(fn($emp) => [
                'id'         => $emp->id,
                'type'       => 'employee',
                'name'       => $emp->name,
                'avatar'     => $emp->avatar_url,
                'job_title'  => $emp->job_title,
                'is_active'  => $emp->is_active,
                'is_manager' => $emp->id === $dept->manager_id,
            ])->values(),
            'children'       => $dept->children
                ->map(fn($child) => $this->buildDeptNode($child, $depth + 1))
                ->values(),
        ];
    }

    private function isDescendant(Department $department, int $targetId): bool
    {
        foreach ($department->children as $child) {
            if ($child->id === $targetId) return true;
            if ($this->isDescendant($child, $targetId)) return true;
        }
        return false;
    }

    private function getDescendantIds(Department $dept): array
    {
        $ids = [];
        foreach ($dept->children as $child) {
            $ids[] = $child->id;
            $ids   = array_merge($ids, $this->getDescendantIds($child));
        }
        return $ids;
    }
}