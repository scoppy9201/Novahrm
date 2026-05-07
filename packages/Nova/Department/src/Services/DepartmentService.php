<?php

namespace Nova\Department\Services;

use Nova\OrgChart\Models\Department;
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
     * Trả về Collection thay vì array để linh hoạt hơn khi dùng phía ngoài
     */
    public function getFlatList(): \Illuminate\Support\Collection
    {
        $departments = Department::active()
            ->orderBy('order')
            ->get();

        return collect($this->buildFlatList($departments));
    }

    /**
     * Tạo phòng ban mới
     */
    public function create(array $data): Department
    {
        return DB::transaction(function () use ($data) {
            // Kiểm tra circular reference trước khi tạo
            if (!empty($data['parent_id'])) {
                $this->checkCircular(null, (int) $data['parent_id']);
            }

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
            if (!empty($data['parent_id'])) {
                // Kiểm tra không tự làm cha của chính nó hoặc chọn cấp con làm cha
                $this->checkCircular($department->id, (int) $data['parent_id']);

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
     * Xóa mềm — kiểm tra không có phòng con và nhân viên trước
     */
    public function delete(Department $department): void
    {
        if ($department->children()->exists()) {
            throw new \RuntimeException(
                'Không thể xóa phòng ban đang có phòng ban con.'
            );
        }

        if ($department->employees()->exists()) {
            throw new \RuntimeException(
                'Không thể xóa phòng ban đang có nhân viên.'
            );
        }

        $department->delete();
    }

    /**
     * Kiểm tra circular reference đơn giản:
     * phòng ban không thể là cha của chính nó
     */
    private function checkCircular(?int $departmentId, int $parentId): void
    {
        if ($departmentId !== null && $departmentId === $parentId) {
            throw new \InvalidArgumentException(
                'Phòng ban không thể là cha của chính nó.'
            );
        }
    }

    /**
     * Kiểm tra $targetId có phải là hậu duệ của $department không
     * (dùng khi update để chặn chọn cấp con làm cha)
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