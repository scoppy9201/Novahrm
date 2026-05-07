<?php

namespace Nova\OrgChart\Http\Controllers;

use Illuminate\Routing\Controller;
use Nova\Auth\Models\Employee;
use Nova\OrgChart\Models\Department;
use Nova\OrgChart\Http\Requests\OrgChartRequest;
use Nova\OrgChart\Services\OrgChartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrgChartController extends Controller
{
    public function __construct(private OrgChartService $service) {}

    public function index()
    {
        return view('org-chart::OrgChart');
    }

    public function tree(): JsonResponse
    {
        return response()->json([
            'tree' => $this->service->getTree(),
        ]);
    }

    public function store(OrgChartRequest $request): JsonResponse
    {
        $dept = $this->service->create($request->validated());

        return response()->json([
            'success'    => true,
            'message'    => 'Tạo phòng ban thành công',
            'department' => $dept->load('manager:id,first_name,last_name,job_title'),
        ], 201);
    }

    public function update(OrgChartRequest $request, Department $department): JsonResponse
    {
        $dept = $this->service->update($department, $request->validated());

        return response()->json([
            'success'    => true,
            'message'    => 'Cập nhật phòng ban thành công',
            'department' => $dept->load('manager:id,first_name,last_name,job_title'),
        ]);
    }

    public function destroy(Department $department): JsonResponse
    {
        try {
            $this->service->delete($department);
        } catch (\RuntimeException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['success' => true, 'message' => 'Xóa phòng ban thành công']);
    }

    public function move(Request $request, Department $department): JsonResponse
    {
        try {
            $this->service->move($department, $request->validate([
                'parent_id' => 'nullable|integer|exists:departments,id',
            ]));
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }

        return response()->json(['success' => true, 'message' => 'Di chuyển phòng ban thành công']);
    }

    public function employeeChain(Employee $employee): JsonResponse
    {
        return response()->json([
            'chain' => $this->service->getEmployeeChain($employee),
        ]);
    }
}