<?php

namespace Nova\Employee\Http\Controllers;

use Illuminate\Routing\Controller;
use Nova\Employee\Services\EmployeeService;
use Nova\Employee\Http\Requests\EmployeeStoreRequest;
use Nova\Employee\Http\Requests\EmployeeUpdateRequest;
use Nova\OrgChart\Models\Department;
use Nova\Department\Models\Position;
use Nova\Auth\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $service
    ) {}

    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');

        $filters = $request->only([
            'search', 'department_id', 'position_id',
            'status', 'employment_type', 'is_active',
            'gender', 'hire_from', 'hire_to',
            'sort', 'direction',
        ]);

        $employees = match($tab) {
            'active'   => $this->service->getList(array_merge($filters, ['is_active' => true]), 15),
            'resigned' => $this->service->getList(array_merge($filters, ['status' => 'resigned']), 15),
            'trash'    => $this->service->getTrashList($filters, 15),
            default    => $this->service->getList($filters, 15),
        };

        $stats       = $this->service->getStats();
        $alerts      = $this->service->getAlerts();
        $counts      = $this->service->getCounts();
        $departments = Department::active()->orderBy('name')->get();
        $positions   = Position::where('status', 'active')->orderBy('title')->get();

        $data = compact('employees', 'stats', 'alerts', 'counts', 'departments', 'positions', 'filters');

        if ($request->header('X-SPA-Request')) {
            return response(view('nova-employee::employee.partials.content', $data));
        }

        return view('nova-employee::employee.index', $data);
    }

    public function create(Request $request): View
    {
        $employee        = new Employee();
        $departments     = Department::active()->orderBy('name')->get();
        $positions       = Position::where('status', 'active')->orderBy('title')->get();
        $managers        = Employee::active()->with('position')->orderBy('first_name')->get();
        $employmentTypes = Employee::EMPLOYMENT_TYPES;
        $contractTypes   = Employee::CONTRACT_TYPES;
        $statuses        = Employee::STATUSES;
        $educationLevels = Employee::EDUCATION_LEVELS;
        $genders         = Employee::GENDERS;
        $countries       = $this->getCountries();

        $preselectedDepartment = null;
        if ($request->has('department_id')) {
            $preselectedDepartment = Department::find($request->department_id);
        }

        $provincesNew    = json_decode(file_get_contents(app_path('Data/provinces_new.json')), true);
        $provincesOld    = json_decode(file_get_contents(app_path('Data/provinces_old.json')), true);
        $educationMajors = json_decode(file_get_contents(app_path('Data/education_industries.json')), true);
        $universities    = json_decode(file_get_contents(app_path('Data/vietnam_universities.json')), true);

        return view('nova-employee::employee.create', compact(
            'employee', 'departments', 'positions', 'managers',
            'employmentTypes', 'contractTypes', 'statuses', 'educationLevels',
            'genders', 'countries', 'preselectedDepartment',
            'provincesNew', 'provincesOld', 'educationMajors', 'universities',
        ));
    }

    public function store(EmployeeStoreRequest $request): RedirectResponse
    {
        try {
            $data            = $request->validated();
            $data['avatar']  = $request->file('avatar');
            $data['cv_path'] = $request->file('cv_path');

            $employee = $this->service->create($data);

            return redirect()
                ->route('hr.employees.show', $employee)
                ->with('success', "Đã thêm nhân viên {$employee->name} thành công.");

        } catch (\Illuminate\Database\QueryException $e) {
            $msg = match(true) {
                str_contains($e->getMessage(), "'email'")                  => 'Email cá nhân này đã được sử dụng.',
                str_contains($e->getMessage(), "'work_email'")             => 'Email công ty này đã được sử dụng.',
                str_contains($e->getMessage(), "'national_id'")            => 'Số CCCD này đã tồn tại.',
                str_contains($e->getMessage(), "'tax_code'")               => 'Mã số thuế này đã tồn tại.',
                str_contains($e->getMessage(), "'social_insurance_code'")  => 'Mã BHXH này đã tồn tại.',
                str_contains($e->getMessage(), 'cannot be null')           => 'Vui lòng điền đầy đủ các trường bắt buộc.',
                default                                                    => 'Đã có lỗi xảy ra khi lưu dữ liệu.',
            };

            return back()->withInput()->withErrors(['error' => $msg]);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Đã có lỗi: ' . $e->getMessage()]);
        }
    }

    public function show(Employee $employee): View
    {
        $employee->load([
            'department', 'position', 'manager',
            'subordinates.position', 'subordinates.department',
        ]);

        return view('nova-employee::employee.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $employee->load(['department', 'position', 'manager']);

        $departments     = Department::active()->orderBy('name')->get();
        $positions       = Position::where('status', 'active')->orderBy('title')->get();
        $managers        = Employee::active()->where('id', '!=', $employee->id)->with('position')->orderBy('first_name')->get();
        $employmentTypes = Employee::EMPLOYMENT_TYPES;
        $contractTypes   = Employee::CONTRACT_TYPES;
        $statuses        = Employee::STATUSES;
        $educationLevels = Employee::EDUCATION_LEVELS;
        $genders         = Employee::GENDERS;
        $countries       = $this->getCountries();

        $provincesNew    = json_decode(file_get_contents(app_path('Data/provinces_new.json')), true);
        $provincesOld    = json_decode(file_get_contents(app_path('Data/provinces_old.json')), true);
        $educationMajors = json_decode(file_get_contents(app_path('Data/education_industries.json')), true);
        $universities    = json_decode(file_get_contents(app_path('Data/vietnam_universities.json')), true);

        return view('nova-employee::employee.edit', compact(
            'employee', 'departments', 'positions', 'managers',
            'employmentTypes', 'contractTypes', 'statuses', 'educationLevels',
            'genders', 'countries', 'provincesNew', 'provincesOld',
            'educationMajors', 'universities',
        ));
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee): RedirectResponse
    {
        try {
            $data            = $request->validated();
            $data['avatar']  = $request->file('avatar');
            $data['cv_path'] = $request->file('cv_path');

            $this->service->update($employee, $data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', "Đã cập nhật thông tin {$employee->name} thành công.");
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        try {
            $name = $employee->name;
            $this->service->delete($employee);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('hr.employees.index')->with('success', "Đã xóa nhân viên {$name}.");
    }

    public function terminate(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate([
            'status'             => 'required|in:resigned,terminated,retired,deceased',
            'termination_date'   => 'required|date',
            'termination_type'   => 'required|in:' . implode(',', array_keys(Employee::TERMINATION_TYPES)),
            'termination_reason' => 'nullable|string|max:500',
        ]);

        $this->service->terminate($employee, $data);

        return redirect()->route('hr.employees.show', $employee)->with('success', "{$employee->name} đã được xử lý nghỉ việc.");
    }

    public function reinstate(Employee $employee): RedirectResponse
    {
        $this->service->reinstate($employee);

        return redirect()->route('hr.employees.show', $employee)->with('success', "{$employee->name} đã được khôi phục.");
    }

    public function restore(int $id): RedirectResponse
    {
        $employee = $this->service->restore($id);

        return redirect()->route('hr.employees.index', ['tab' => 'trash'])->with('success', "{$employee->name} đã được khôi phục.");
    }

    public function transfer(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'position_id'   => 'nullable|exists:positions,id',
            'manager_id'    => 'nullable|exists:employees,id',
        ]);

        $this->service->transfer($employee, $data);

        return redirect()->route('hr.employees.show', $employee)->with('success', "{$employee->name} đã được chuyển thành công.");
    }

    public function updateAvatar(Request $request, Employee $employee): RedirectResponse
    {
        $request->validate(['avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048']);
        $this->service->updateAvatar($employee, $request->file('avatar'));

        return back()->with('success', 'Đã cập nhật ảnh đại diện.');
    }

    public function deleteAvatar(Employee $employee): RedirectResponse
    {
        $this->service->deleteAvatar($employee);

        return back()->with('success', 'Đã xóa ảnh đại diện.');
    }

    public function search(Request $request): JsonResponse
    {
        $employees = $this->service->search($request->get('q', ''));

        return response()->json(
            $employees->map(fn($e) => [
                'id'         => $e->id,
                'name'       => $e->name,
                'code'       => $e->employee_code,
                'position'   => $e->position?->title ?? '',
                'department' => $e->department?->name ?? '',
                'avatar'     => $e->avatar_url,
            ])
        );
    }

    public function export(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filters   = $request->only(['department_id', 'status', 'is_active']);
        $employees = $this->service->getExportData($filters);
        $filename  = 'employees_' . now()->format('Ymd_His') . '.csv';
        $path      = storage_path('app/exports/' . $filename);

        $handle = fopen($path, 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($handle, ['Mã NV', 'Họ', 'Tên', 'Email', 'SĐT', 'Phòng ban', 'Vị trí', 'Loại HĐ', 'Ngày vào', 'Trạng thái']);

        foreach ($employees as $emp) {
            fputcsv($handle, [
                $emp->employee_code, $emp->first_name, $emp->last_name,
                $emp->email, $emp->phone,
                $emp->department?->name ?? '',
                $emp->position?->title ?? '',
                Employee::EMPLOYMENT_TYPES[$emp->employment_type] ?? $emp->employment_type,
                $emp->hire_date?->format('d/m/Y') ?? '',
                Employee::STATUSES[$emp->status] ?? $emp->status,
            ]);
        }

        fclose($handle);

        return response()->download($path, $filename)->deleteFileAfterSend();
    }

    public function forceDelete(int $id): RedirectResponse
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $name     = $employee->name;
        $employee->forceDelete();

        return redirect()->route('hr.employees.index', ['tab' => 'trash'])->with('success', "Đã xoá vĩnh viễn {$name}.");
    }

    private function getCountries(): array
    {
        return collect(json_decode(file_get_contents(base_path('app/Data/countries.json')), true))
            ->map(fn($c) => $c['translations']['vie']['common'] ?? $c['name']['common'])
            ->filter()->sort()->values()->toArray();
    }
}