<?php

namespace Nova\Department\Http\Controllers;

use Nova\Department\Http\Requests\PositionRequest;
use Nova\Department\Models\Position;
use Nova\OrgChart\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PositionController extends Controller
{
    public function index(Request $request): View
    {
        $positions = Position::with('department')
            ->when($request->search, fn($q, $s) =>
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
            )
            ->when($request->department_id, fn($q, $id) => $q->where('department_id', $id))
            ->when($request->level,         fn($q, $l)  => $q->where('level', $l))
            ->when($request->status,        fn($q, $s)  => $q->where('status', $s))
            ->orderBy('department_id')
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        $departments = Department::active()->orderBy('name')->get();
        $months      = collect(range(6, 0))->map(fn($i) => now()->subMonths($i)->startOfMonth());

        $trendTotal  = $months->map(fn($m) => Position::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count())->values();
        $trendActive = $months->map(fn($m) => Position::where('status', 'active')->whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count())->values();
        $trendDept   = $months->map(fn($m) => Department::whereYear('created_at', $m->year)->whereMonth('created_at', $m->month)->count())->values();
        $monthLabels = $months->map(fn($m) => $m->format('T/n'))->values();

        return view('nova-department::position.index', compact(
            'positions', 'departments',
            'trendTotal', 'trendActive', 'trendDept', 'monthLabels'
        ));
    }

    public function create(Request $request): View
    {
        $departments          = Department::active()->orderBy('name')->get();
        $levels               = Position::LEVELS;
        $selectedDepartmentId = $request->department_id;

        return view('nova-department::position.create', compact('departments', 'levels', 'selectedDepartmentId'));
    }

    public function store(PositionRequest $request): RedirectResponse
    {
        Position::create($request->validated());

        $redirect = $request->from_department
            ? route('hr.departments.show', $request->department_id)
            : route('hr.positions.index');

        return redirect($redirect)->with('success', 'Tạo vị trí thành công.');
    }

    public function show(Position $position): View
    {
        $position->load(['department', 'employees' => fn($q) => $q->with('department')]);

        return view('nova-department::position.show', compact('position'));
    }

    public function edit(Position $position): View
    {
        $departments = Department::active()->orderBy('name')->get();
        $levels      = Position::LEVELS;

        return view('nova-department::position.edit', compact('position', 'departments', 'levels'));
    }

    public function update(PositionRequest $request, Position $position): RedirectResponse
    {
        $position->update($request->validated());

        return redirect()->route('hr.positions.index')->with('success', 'Cập nhật vị trí thành công.');
    }

    public function destroy(Position $position): RedirectResponse
    {
        if ($position->employees()->exists()) {
            return back()->with('error', 'Không thể xóa vị trí đang có nhân viên.');
        }

        $position->delete();

        return redirect()->route('hr.positions.index')->with('success', 'Đã xóa vị trí.');
    }
}