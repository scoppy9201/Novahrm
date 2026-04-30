<?php

namespace App\Services;

use App\packages\Nova\OrgChart\src\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\UniqueConstraintViolationException;

class DepartmentService
{
    /**
     * Lấy toàn bộ cây phòng ban (chỉ root, các cấp con load theo childrenRecursive)
     */
    public function getTree(): \Illuminate\Database\Eloquent\Collection
    {
        return Department::with(['childrenRecursive', 'manager'])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
    }

    /**
     * Lấy danh sách phẳng cho dropdown (có indent theo cấp)
     */
    public function getFlatList(): array
    {
        $departments = Department::active()
            ->orderBy('order')
            ->get();

        return $this->buildFlatList($departments);
    }

    /**
     * Tạo phòng ban mới
     */
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

    /**
     * Cập nhật phòng ban
     */
    public function update(Department $department, array $data): Department
    {
        return DB::transaction(function () use ($department, $data) {
            if (isset($data['parent_id']) && $data['parent_id']) {
                if ($this->isDescendant($department, (int) $data['parent_id'])) {
                    throw new \InvalidArgumentException(
                        'Không thể chọn phòng ban con làm phòng ban cha.'
                    );
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

    /**
     * Xóa mềm — kiểm tra không có nhân viên và phòng con trước
     */
    public function delete(Department $department): void
    {
        if ($department->employees()->exists()) {
            throw new \RuntimeException(
                'Không thể xóa phòng ban đang có nhân viên.'
            );
        }

        if ($department->children()->exists()) {
            throw new \RuntimeException(
                'Không thể xóa phòng ban đang có phòng ban con.'
            );
        }

        $department->delete();
    }

    /**
     * Kiểm tra $targetId có phải là hậu duệ của $department không
     */
    private function isDescendant(Department $department, int $targetId): bool
    {
        foreach ($department->children as $child) {
            if ($child->id === $targetId) {
                return true;
            }

            if ($this->isDescendant($child, $targetId)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Xây danh sách phẳng có indent để dùng cho <select>
     * VD: "— — Engineering", "— — — Frontend"
     */
    private function buildFlatList(
        \Illuminate\Database\Eloquent\Collection $departments,
        ?int $parentId = null,
        int $depth = 0
    ): array {
        $result = [];

        foreach ($departments->where('parent_id', $parentId) as $dept) {
            $result[] = [
                'id'   => $dept->id,
                'name' => str_repeat('— ', $depth) . $dept->name,
            ];

            $result = array_merge(
                $result,
                $this->buildFlatList($departments, $dept->id, $depth + 1)
            );
        }

        return $result;
    }
}