<?php

namespace App\packages\Nova\Employee\src\Http\Controllers;

use App\Services\EmployeeService;
use App\packages\Nova\OrgChart\src\Models\Department;
use App\packages\Nova\Department\src\Models\Position;
use Nova\Auth\Models\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $service
    ) {}

    // INDEX
    public function index(Request $request): View
    {
        $filters = $request->only([
            'search', 'department_id', 'position_id',
            'status', 'employment_type', 'is_active',
            'gender', 'hire_from', 'hire_to',
            'sort', 'direction',
        ]);

        $employees   = $this->service->getList($filters, 15);
        $stats       = $this->service->getStats();
        $alerts      = $this->service->getAlerts();
        $departments = Department::active()->orderBy('name')->get();
        $positions   = Position::where('status', 'active')->orderBy('title')->get();

        return view('nova-employee::employee.index', compact(
            'employees',
            'stats',
            'alerts',
            'departments',
            'positions',
            'filters',
        ));
    }

    // CREATE
    public function create(Request $request): View
    {
        $departments    = Department::active()->orderBy('name')->get();
        $positions      = Position::where('status', 'active')->orderBy('title')->get();
        $managers       = Employee::active()->with('position')->orderBy('first_name')->get();
        $employmentTypes = Employee::EMPLOYMENT_TYPES;
        $contractTypes  = Employee::CONTRACT_TYPES;
        $statuses       = Employee::STATUSES;
        $educationLevels = Employee::EDUCATION_LEVELS;
        $genders        = Employee::GENDERS;

        // Pre-select department nếu có query param
        $preselectedDepartment = null;
        if ($request->has('department_id')) {
            $preselectedDepartment = Department::find($request->department_id);
        }

        return view('nova-employee::employee.create', compact(
            'departments',
            'positions',
            'managers',
            'employmentTypes',
            'contractTypes',
            'statuses',
            'educationLevels',
            'genders',
            'preselectedDepartment',
        ));
    }

    // STORE
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            // Thông tin cá nhân
            'first_name'                => 'required|string|max:100',
            'last_name'                 => 'required|string|max:100',
            'gender'                    => 'nullable|in:male,female,other',
            'date_of_birth'             => 'nullable|date|before:today',
            'place_of_birth'            => 'nullable|string|max:255',
            'nationality'               => 'nullable|string|max:100',
            'ethnicity'                 => 'nullable|string|max:100',
            'religion'                  => 'nullable|string|max:100',
            'national_id'               => 'nullable|string|max:20|unique:employees,national_id',
            'national_id_issued_date'   => 'nullable|date',
            'national_id_issued_place'  => 'nullable|string|max:255',
            'passport_number'           => 'nullable|string|max:30',
            'passport_expiry_date'      => 'nullable|date',

            // Liên hệ
            'email'                     => 'nullable|email|unique:employees,email',
            'work_email'                => 'nullable|email|unique:employees,work_email',
            'phone'                     => 'nullable|string|max:20',
            'phone_alt'                 => 'nullable|string|max:20',
            'emergency_contact_name'    => 'nullable|string|max:255',
            'emergency_contact_phone'   => 'nullable|string|max:20',
            'emergency_contact_relation'=> 'nullable|string|max:100',

            // Địa chỉ
            'permanent_address'         => 'nullable|string|max:255',
            'permanent_ward'            => 'nullable|string|max:100',
            'permanent_district'        => 'nullable|string|max:100',
            'permanent_province'        => 'nullable|string|max:100',
            'current_address'           => 'nullable|string|max:255',
            'current_ward'              => 'nullable|string|max:100',
            'current_district'          => 'nullable|string|max:100',
            'current_province'          => 'nullable|string|max:100',

            // Công việc
            'department_id'             => 'nullable|exists:departments,id',
            'position_id'               => 'nullable|exists:positions,id',
            'manager_id'                => 'nullable|exists:employees,id',
            'employment_type'           => 'required|in:' . implode(',', array_keys(Employee::EMPLOYMENT_TYPES)),
            'hire_date'                 => 'nullable|date',
            'probation_start_date'      => 'nullable|date',
            'probation_end_date'        => 'nullable|date|after_or_equal:probation_start_date',
            'official_start_date'       => 'nullable|date',

            // Hợp đồng
            'contract_type'             => 'nullable|in:' . implode(',', array_keys(Employee::CONTRACT_TYPES)),
            'contract_number'           => 'nullable|string|max:100',
            'contract_start_date'       => 'nullable|date',
            'contract_end_date'         => 'nullable|date|after_or_equal:contract_start_date',

            // Lương
            'basic_salary'              => 'nullable|integer|min:0',
            'salary_type'               => 'nullable|in:monthly,daily,hourly',
            'bank_name'                 => 'nullable|string|max:100',
            'bank_account'              => 'nullable|string|max:50',
            'bank_branch'               => 'nullable|string|max:150',
            'bank_account_name'         => 'nullable|string|max:150',
            'tax_code'                  => 'nullable|string|max:20|unique:employees,tax_code',
            'social_insurance_code'     => 'nullable|string|max:20|unique:employees,social_insurance_code',
            'health_insurance_code'     => 'nullable|string|max:20',
            'health_insurance_place'    => 'nullable|string|max:255',
            'social_insurance_start_date' => 'nullable|date',

            // Học vấn
            'education_level'           => 'nullable|in:' . implode(',', array_keys(Employee::EDUCATION_LEVELS)),
            'education_major'           => 'nullable|string|max:255',
            'education_school'          => 'nullable|string|max:255',

            // Trạng thái
            'status'                    => 'nullable|in:' . implode(',', array_keys(Employee::STATUSES)),
            'is_active'                 => 'boolean',

            // Media
            'avatar'                    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv_path'                   => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            // Misc
            'notes'                     => 'nullable|string',
            'bio'                       => 'nullable|string',
        ]);

        try {
            $data['avatar']  = $request->file('avatar');
            $data['cv_path'] = $request->file('cv_path');

            $employee = $this->service->create($data);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', "Đã thêm nhân viên {$employee->name} thành công.");
    }

    // SHOW
    public function show(Employee $employee): View
    {
        $employee->load([
            'department',
            'position',
            'manager',
            'subordinates.position',
            'subordinates.department',
        ]);

        return view('nova-employee::employee.show', compact('employee'));
    }

    // EDIT
    public function edit(Employee $employee): View
    {
        $employee->load(['department', 'position', 'manager']);

        $departments     = Department::active()->orderBy('name')->get();
        $positions       = Position::where('status', 'active')->orderBy('title')->get();
        $managers        = Employee::active()
            ->where('id', '!=', $employee->id) // không tự quản lý mình
            ->with('position')
            ->orderBy('first_name')
            ->get();
        $employmentTypes = Employee::EMPLOYMENT_TYPES;
        $contractTypes   = Employee::CONTRACT_TYPES;
        $statuses        = Employee::STATUSES;
        $educationLevels = Employee::EDUCATION_LEVELS;
        $genders         = Employee::GENDERS;

        return view('nova-employee::employee.edit', compact(
            'employee',
            'departments',
            'positions',
            'managers',
            'employmentTypes',
            'contractTypes',
            'statuses',
            'educationLevels',
            'genders',
        ));
    }

    // UPDATE
    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate([
            'first_name'                => 'required|string|max:100',
            'last_name'                 => 'required|string|max:100',
            'gender'                    => 'nullable|in:male,female,other',
            'date_of_birth'             => 'nullable|date|before:today',
            'place_of_birth'            => 'nullable|string|max:255',
            'nationality'               => 'nullable|string|max:100',
            'ethnicity'                 => 'nullable|string|max:100',
            'religion'                  => 'nullable|string|max:100',
            'national_id'               => 'nullable|string|max:20|unique:employees,national_id,' . $employee->id,
            'national_id_issued_date'   => 'nullable|date',
            'national_id_issued_place'  => 'nullable|string|max:255',
            'passport_number'           => 'nullable|string|max:30',
            'passport_expiry_date'      => 'nullable|date',

            'email'                     => 'nullable|email|unique:employees,email,' . $employee->id,
            'work_email'                => 'nullable|email|unique:employees,work_email,' . $employee->id,
            'phone'                     => 'nullable|string|max:20',
            'phone_alt'                 => 'nullable|string|max:20',
            'emergency_contact_name'    => 'nullable|string|max:255',
            'emergency_contact_phone'   => 'nullable|string|max:20',
            'emergency_contact_relation'=> 'nullable|string|max:100',

            'permanent_address'         => 'nullable|string|max:255',
            'permanent_ward'            => 'nullable|string|max:100',
            'permanent_district'        => 'nullable|string|max:100',
            'permanent_province'        => 'nullable|string|max:100',
            'current_address'           => 'nullable|string|max:255',
            'current_ward'              => 'nullable|string|max:100',
            'current_district'          => 'nullable|string|max:100',
            'current_province'          => 'nullable|string|max:100',

            'department_id'             => 'nullable|exists:departments,id',
            'position_id'               => 'nullable|exists:positions,id',
            'manager_id'                => 'nullable|exists:employees,id|different:id',
            'employment_type'           => 'required|in:' . implode(',', array_keys(Employee::EMPLOYMENT_TYPES)),
            'hire_date'                 => 'nullable|date',
            'probation_start_date'      => 'nullable|date',
            'probation_end_date'        => 'nullable|date|after_or_equal:probation_start_date',
            'official_start_date'       => 'nullable|date',

            'contract_type'             => 'nullable|in:' . implode(',', array_keys(Employee::CONTRACT_TYPES)),
            'contract_number'           => 'nullable|string|max:100',
            'contract_start_date'       => 'nullable|date',
            'contract_end_date'         => 'nullable|date|after_or_equal:contract_start_date',

            'basic_salary'              => 'nullable|integer|min:0',
            'salary_type'               => 'nullable|in:monthly,daily,hourly',
            'bank_name'                 => 'nullable|string|max:100',
            'bank_account'              => 'nullable|string|max:50',
            'bank_branch'               => 'nullable|string|max:150',
            'bank_account_name'         => 'nullable|string|max:150',
            'tax_code'                  => 'nullable|string|max:20|unique:employees,tax_code,' . $employee->id,
            'social_insurance_code'     => 'nullable|string|max:20|unique:employees,social_insurance_code,' . $employee->id,
            'health_insurance_code'     => 'nullable|string|max:20',
            'health_insurance_place'    => 'nullable|string|max:255',
            'social_insurance_start_date' => 'nullable|date',

            'education_level'           => 'nullable|in:' . implode(',', array_keys(Employee::EDUCATION_LEVELS)),
            'education_major'           => 'nullable|string|max:255',
            'education_school'          => 'nullable|string|max:255',

            'status'                    => 'nullable|in:' . implode(',', array_keys(Employee::STATUSES)),
            'is_active'                 => 'boolean',

            'avatar'                    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv_path'                   => 'nullable|file|mimes:pdf,doc,docx|max:5120',

            'notes'                     => 'nullable|string',
            'bio'                       => 'nullable|string',
        ]);

        try {
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

    // DESTROY
    public function destroy(Employee $employee): RedirectResponse
    {
        try {
            $name = $employee->name;
            $this->service->delete($employee);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('hr.employees.index')
            ->with('success', "Đã xóa nhân viên {$name}.");
    }

    // TERMINATE
    public function terminate(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate([
            'status'             => 'required|in:resigned,terminated,retired,deceased',
            'termination_date'   => 'required|date',
            'termination_type'   => 'required|in:' . implode(',', array_keys(Employee::TERMINATION_TYPES)),
            'termination_reason' => 'nullable|string|max:500',
        ]);

        $this->service->terminate($employee, $data);

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', "{$employee->name} đã được xử lý nghỉ việc.");
    }

    // REINSTATE
    public function reinstate(Employee $employee): RedirectResponse
    {
        $this->service->reinstate($employee);

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', "{$employee->name} đã được khôi phục trạng thái làm việc.");
    }

    // RESTORE (soft delete)
    public function restore(int $id): RedirectResponse
    {
        $employee = $this->service->restore($id);

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', "{$employee->name} đã được khôi phục.");
    }

    // TRANSFER
    public function transfer(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'position_id'   => 'nullable|exists:positions,id',
            'manager_id'    => 'nullable|exists:employees,id',
        ]);

        $this->service->transfer($employee, $data);

        return redirect()
            ->route('hr.employees.show', $employee)
            ->with('success', "{$employee->name} đã được chuyển phòng/vị trí thành công.");
    }

    // AVATAR
    public function updateAvatar(Request $request, Employee $employee): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $this->service->updateAvatar($employee, $request->file('avatar'));

        return back()->with('success', 'Đã cập nhật ảnh đại diện.');
    }

    public function deleteAvatar(Employee $employee): RedirectResponse
    {
        $this->service->deleteAvatar($employee);

        return back()->with('success', 'Đã xóa ảnh đại diện.');
    }

    // SEARCH (autocomplete JSON)
    public function search(Request $request): JsonResponse
    {
        $keyword   = $request->get('q', '');
        $employees = $this->service->search($keyword);

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

    // EXPORT
    public function export(Request $request): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $filters = $request->only(['department_id', 'status', 'is_active']);

        // Dùng Laravel Excel hoặc Spatie nếu có
        // return Excel::download(new EmployeesExport($filters), 'employees.xlsx');

        // Tạm thời export CSV đơn giản
        $employees = $this->service->getExportData($filters);
        $filename  = 'employees_' . now()->format('Ymd_His') . '.csv';
        $path      = storage_path('app/exports/' . $filename);

        $handle = fopen($path, 'w');
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

        fputcsv($handle, [
            'Mã NV', 'Họ', 'Tên', 'Email', 'SĐT',
            'Phòng ban', 'Vị trí', 'Loại HĐ', 'Ngày vào',
            'Trạng thái',
        ]);

        foreach ($employees as $emp) {
            fputcsv($handle, [
                $emp->employee_code,
                $emp->first_name,
                $emp->last_name,
                $emp->email,
                $emp->phone,
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
        $name = $employee->name;
        $employee->forceDelete();

        return redirect()
            ->route('hr.employees.index', ['tab' => 'trash'])
            ->with('success', "Đã xoá vĩnh viễn nhân viên {$name}.");
    }
}