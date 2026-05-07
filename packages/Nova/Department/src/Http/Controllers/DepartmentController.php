<?php

namespace Nova\Department\Http\Controllers;

use Nova\Department\Http\Requests\DepartmentRequest;
use Nova\Department\Services\DepartmentService;
use Nova\OrgChart\Models\Department;
use Nova\Auth\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service
    ) {}

    public function index(Request $request): View
    {
        $departments = Department::with(['parent', 'manager'])
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
            )
            ->when($request->status, fn($q, $s) =>
                $q->where('status', $s)
            )
            ->orderBy('order')
            ->paginate(15)
            ->withQueryString();

        $totalAll       = Department::whereNull('deleted_at')->count();
        $totalActive    = Department::whereNull('deleted_at')->where('status', 'active')->count();
        $totalNoManager = Department::whereNull('deleted_at')->whereNull('manager_id')->count();

        $rawTotal = Department::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->whereNull('deleted_at')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . $row->month);

        $totalSparkline = collect(range(0, 5))->map(function ($i) use ($rawTotal) {
            $date = now()->subMonths(5 - $i);
            return (int) ($rawTotal->get($date->year . '-' . $date->month)->total ?? 0);
        });

        $activeByMonth = collect(range(0, 5))->map(fn($i) =>
            Department::whereNull('deleted_at')
                ->where('status', 'active')
                ->where('created_at', '<=', now()->subMonths(5 - $i)->endOfMonth())
                ->count()
        );

        $noManagerByMonth = collect(range(0, 5))->map(fn($i) =>
            Department::whereNull('deleted_at')
                ->whereNull('manager_id')
                ->where('created_at', '<=', now()->subMonths(5 - $i)->endOfMonth())
                ->count()
        );

        return view('nova-department::department.index', compact(
            'departments', 'totalAll', 'totalActive', 'totalNoManager',
            'totalSparkline', 'activeByMonth', 'noManagerByMonth',
        ));
    }

    public function create(Request $request): View
    {
        $parentOptions     = $this->service->getFlatList();
        $preselectedParent = $request->has('parent_id')
            ? Department::find($request->parent_id)
            : null;

        return view('nova-department::department.create', compact('parentOptions', 'preselectedParent'));
    }

    public function store(DepartmentRequest $request): RedirectResponse
    {
        try {
            $this->service->create($request->validated());
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['name' => $e->getMessage()])->withInput();
        }

        return redirect()->route('hr.departments.index')->with('success', 'Tạo phòng ban thành công.');
    }

    public function show(Department $department): View
    {
        $department->load([
            'parent', 'manager', 'children.manager',
            'employees' => fn($q) => $q->active()->with('position'),
            'positions',
        ]);

        return view('nova-department::department.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        $parentOptions = $this->service->getFlatList();

        return view('nova-department::department.edit', compact('department', 'parentOptions'));
    }

    public function update(DepartmentRequest $request, Department $department): RedirectResponse
    {
        try {
            $this->service->update($department, $request->validated());
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['name' => $e->getMessage()])->withInput();
        }

        return redirect()->route('hr.departments.index')->with('success', 'Cập nhật phòng ban thành công.');
    }

    public function destroy(Department $department): RedirectResponse
    {
        try {
            $this->service->delete($department);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('hr.departments.index')->with('success', 'Đã xóa phòng ban.');
    }

    public function searchManagers(Request $request): \Illuminate\Http\JsonResponse
    {
        $keyword = $request->get('q', '');

        $employees = Employee::with('position')
            ->whereHas('position', fn($q) =>
                $q->whereIn('level', ['lead', 'manager', 'director'])
                  ->where('status', 'active')
            )
            ->where('is_active', true)
            ->where(fn($q) => $q
                ->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"])
            )
            ->limit(10)
            ->get()
            ->map(fn($e) => [
                'id'       => $e->id,
                'name'     => $e->name,
                'position' => $e->position?->title ?? '',
                'avatar'   => $e->avatar_url,
            ]);

        return response()->json($employees);
    }
}