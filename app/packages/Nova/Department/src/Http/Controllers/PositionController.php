<?php

namespace App\packages\Nova\Department\src\Http\Controllers;

use App\packages\Nova\Department\src\Models\Position;
use App\packages\Nova\OrgChart\src\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PositionController extends Controller
{
    /**
     * Danh sách vị trí (có filter theo phòng ban, level, status)
     */
    public function index(Request $request): View
    {
        $positions = Position::with('department')
            ->when($request->search, fn($q, $s) =>
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
            )
            ->when($request->department_id, fn($q, $id) =>
                $q->where('department_id', $id)
            )
            ->when($request->level, fn($q, $l) =>
                $q->where('level', $l)
            )
            ->when($request->status, fn($q, $s) =>
                $q->where('status', $s)
            )
            ->orderBy('department_id')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        $departments = Department::active()->orderBy('name')->get();

        return view('nova-department::position.index', compact('positions', 'departments'));
    }

    /**
     * Form tạo mới
     */
    public function create(Request $request): View
    {
        $departments = Department::active()->orderBy('name')->get();
        $levels      = Position::LEVELS;

        // Hỗ trợ pre-select phòng ban nếu vào từ trang chi tiết phòng ban
        $selectedDepartmentId = $request->department_id;

        return view('nova-department::position.create', compact(
            'departments', 'levels', 'selectedDepartmentId'
        ));
    }

    /**
     * Lưu vị trí mới
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'code'           => 'required|string|max:50|unique:positions,code',
            'description'    => 'nullable|string',
            'department_id'  => 'required|exists:departments,id',
            'level'          => 'nullable|in:' . implode(',', array_keys(Position::LEVELS)),
            'salary_min'     => 'nullable|numeric|min:0',
            'salary_max'     => 'nullable|numeric|min:0|gte:salary_min',
            'headcount_plan' => 'nullable|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ]);

        Position::create($data);

        // Nếu tạo từ trang phòng ban thì quay lại đó
        $redirect = $request->from_department
            ? route('departments.show', $request->department_id)
            : route('positions.index');

        return redirect($redirect)->with('success', 'Tạo vị trí thành công.');
    }

    /**
     * Chi tiết vị trí
     */
    public function show(Position $position): View
    {
        $position->load(['department', 'employees']);

        return view('nova-department::position.show', compact('position'));
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(Position $position): View
    {
        $departments = Department::active()->orderBy('name')->get();
        $levels      = Position::LEVELS;

        return view('nova-department::position.edit', compact('position', 'departments', 'levels'));
    }

    /**
     * Cập nhật vị trí
     */
    public function update(Request $request, Position $position): RedirectResponse
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'code'           => 'required|string|max:50|unique:positions,code,' . $position->id,
            'description'    => 'nullable|string',
            'department_id'  => 'required|exists:departments,id',
            'level'          => 'nullable|in:' . implode(',', array_keys(Position::LEVELS)),
            'salary_min'     => 'nullable|numeric|min:0',
            'salary_max'     => 'nullable|numeric|min:0|gte:salary_min',
            'headcount_plan' => 'nullable|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ]);

        $position->update($data);

        return redirect()
            ->route('positions.index')
            ->with('success', 'Cập nhật vị trí thành công.');
    }

    /**
     * Xóa mềm vị trí
     */
    public function destroy(Position $position): RedirectResponse
    {
        if ($position->employees()->exists()) {
            return back()->with('error', 'Không thể xóa vị trí đang có nhân viên.');
        }

        $position->delete();

        return redirect()
            ->route('positions.index')
            ->with('success', 'Đã xóa vị trí.');
    }
}