<?php

namespace App\packages\Nova\OrgChart\src\Http\Controllers;

use App\Http\Controllers\Controller;
use Nova\Auth\Models\Employee;
use App\packages\Nova\OrgChart\src\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrgChartController extends Controller
{
    public function index()
    {
        return view('org-chart::OrgChart');
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('departments')->where(fn($q) => 
                    $q->where('parent_id', $request->parent_id)
                ),
            ],
            'code'        => 'nullable|string|max:50|unique:departments,code',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|integer|exists:departments,id',
            'manager_id'  => 'nullable|integer|exists:employees,id',
            'color'       => 'nullable|string|max:20',
            'order'       => 'nullable|integer',
        ], [
            'name.unique' => 'Tên phòng ban đã tồn tại trong cùng cấp này.',
            'code.unique' => 'Mã phòng ban đã được sử dụng.',
        ]);

        $dept = Department::create($validated);

        return response()->json([
            'success'    => true,
            'message'    => 'Tạo phòng ban thành công',
            'department' => $dept->load('manager:id,first_name,last_name,job_title'),
        ], 201);
    }

    public function update(Request $request, $department): JsonResponse
    {
        $dept = Department::findOrFail($department);

        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('departments')
                    ->where(fn($q) => $q->where('parent_id', $request->parent_id))
                    ->ignore($dept->id),
            ],
            'code'        => 'nullable|string|max:50|unique:departments,code,' . $dept->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|integer|exists:departments,id',
            'manager_id'  => 'nullable|integer|exists:employees,id',
            'color'       => 'nullable|string|max:20',
            'order'       => 'nullable|integer',
        ], [
            'name.unique' => 'Tên phòng ban đã tồn tại trong cùng cấp này.',
            'code.unique' => 'Mã phòng ban đã được sử dụng.',
        ]);

        $dept->update($validated);

        return response()->json([
            'success'    => true,
            'message'    => 'Cập nhật phòng ban thành công',
            'department' => $dept->fresh()->load('manager:id,first_name,last_name,job_title'),
        ]);
    }

    public function destroy($department): JsonResponse
    {
        $dept = Department::findOrFail($department);

        // Chặn xóa nếu còn phòng ban con
        if ($dept->children()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa phòng ban vì còn phòng ban con. Hãy xóa hoặc chuyển các phòng ban con trước.',
            ], 422);
        }

        // Chặn xóa nếu còn nhân viên
        if ($dept->employees()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa phòng ban vì còn nhân viên. Hãy chuyển nhân viên sang phòng ban khác trước.',
            ], 422);
        }

        $dept->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa phòng ban thành công',
        ]);
    }

    public function move(Request $request, $department): JsonResponse
    {
        $dept = Department::findOrFail($department);

        $validated = $request->validate([
            'parent_id' => 'nullable|integer|exists:departments,id',
        ]);

        // Không cho phép set parent là chính nó hoặc con cháu của nó
        if ($validated['parent_id']) {
            $descendantIds = $this->getDescendantIds($dept);
            if (in_array($validated['parent_id'], $descendantIds) || $validated['parent_id'] == $dept->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể di chuyển phòng ban vào chính nó hoặc phòng ban con của nó.',
                ], 422);
            }
        }

        $dept->update(['parent_id' => $validated['parent_id'] ?? null]);

        return response()->json([
            'success' => true,
            'message' => 'Di chuyển phòng ban thành công',
        ]);
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

    public function tree(): JsonResponse
    {
        $departments = Department::with([
            'manager:id,first_name,last_name,avatar,job_title',
            'employees:id,first_name,last_name,avatar,job_title,department_id,manager_id,is_active',
        ])
        ->whereNull('parent_id')
        ->orderBy('order')
        ->get();

        return response()->json([
            'tree' => $departments->map(fn($dept) => $this->buildDeptNode($dept)),
        ]);
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

    public function employeeChain(Employee $employee): JsonResponse
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

        return response()->json(['chain' => $chain]);
    }
}