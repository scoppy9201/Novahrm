<?php

namespace App\packages\Nova\Department\src\Http\Controllers;

use App\Services\DepartmentService;
use App\packages\Nova\OrgChart\src\Models\Department;
use App\packages\Nova\Department\src\Models\Position;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service
    ) {}

    /**
     * Danh sách phòng ban (dạng bảng phẳng + filter)
     */
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

        // Stat cards (đếm toàn bộ, không phụ thuộc pagination) 
        $totalAll     = Department::whereNull('deleted_at')->count();
        $totalActive  = Department::whereNull('deleted_at')->where('status', 'active')->count();
        $totalNoManager = Department::whereNull('deleted_at')->whereNull('manager_id')->count();

        // Sparkline 1: phòng ban tạo mới theo tháng 
        $rawTotal = Department::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->whereNull('deleted_at')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get()
            ->keyBy(fn($row) => $row->year . '-' . $row->month);

        $totalSparkline = collect(range(0, 5))->map(function ($i) use ($rawTotal) {
            $date = now()->subMonths(5 - $i);
            $key  = $date->year . '-' . $date->month;
            return (int) ($rawTotal->get($key)->total ?? 0);
        });

        // Sparkline 2: phòng ban active lũy kế 
        $activeByMonth = collect(range(0, 5))->map(function ($i) {
            $endOfMonth = now()->subMonths(5 - $i)->endOfMonth();
            return Department::whereNull('deleted_at')
                ->where('status', 'active')
                ->where('created_at', '<=', $endOfMonth)
                ->count();
        });

        // Sparkline 3: phòng ban không có trưởng phòng lũy kế 
        $noManagerByMonth = collect(range(0, 5))->map(function ($i) {
            $endOfMonth = now()->subMonths(5 - $i)->endOfMonth();
            return Department::whereNull('deleted_at')
                ->whereNull('manager_id')
                ->where('created_at', '<=', $endOfMonth)
                ->count();
        });

        return view('nova-department::department.index', compact(
            'departments',
            'totalAll',
            'totalActive',
            'totalNoManager',
            'totalSparkline',
            'activeByMonth',
            'noManagerByMonth',
        ));
    }

    /**
     * Form tạo mới
     */
    public function create(Request $request): View
    {
        $parentOptions = $this->service->getFlatList();
        $preselectedParent = null;

        if ($request->has('parent_id')) {
            $preselectedParent = Department::find($request->parent_id);
        }

        return view('nova-department::department.create', compact(
            'parentOptions',
            'preselectedParent',
        ));
    }

    /**
     * Lưu phòng ban mới
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:departments,code',
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:departments,id',
            'manager_id'  => 'nullable|exists:employees,id',
            'color'       => 'nullable|string|max:7',
            'order'       => 'nullable|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        try {
            $this->service->create($data);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['name' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('hr.departments.index')
            ->with('success', 'Tạo phòng ban thành công.');
    }

    /**
     * Chi tiết phòng ban
     */
    public function show(Department $department): View
    {
        $department->load([
            'parent',
            'manager',
            'children.manager',
            'employees' => fn($q) => $q->active()->with('position'),
            'positions',
        ]);

        return view('nova-department::department.show', compact('department'));
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(Department $department): View
    {
        $parentOptions = $this->service->getFlatList();

        return view('nova-department::department.edit', compact('department', 'parentOptions'));
    }

    /**
     * Cập nhật phòng ban
     */
    public function update(Request $request, Department $department): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:departments,id',
            'manager_id'  => 'nullable|exists:employees,id',
            'color'       => 'nullable|string|max:7',
            'order'       => 'nullable|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ]);

        try {
            $this->service->update($department, $data);
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['name' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('hr.departments.index')
            ->with('success', 'Cập nhật phòng ban thành công.');
    }

    /**
     * Xóa mềm phòng ban
     */
    public function destroy(Department $department): RedirectResponse
    {
        try {
            $this->service->delete($department);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('hr.departments.index')
            ->with('success', 'Đã xóa phòng ban.');
    }

    /**
     * Autocomplete tìm trưởng phòng (level: lead, manager, director)
     */
    public function searchManagers(Request $request): \Illuminate\Http\JsonResponse
    {
        $keyword = $request->get('q', '');

        $employees = \Nova\Auth\Models\Employee::with('position')
            ->whereHas('position', fn($q) =>
                $q->whereIn('level', ['lead', 'manager', 'director'])
                ->where('status', 'active')
            )
            ->where('is_active', true)
            ->where(fn($q) => $q
                ->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name',  'like', "%{$keyword}%")
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