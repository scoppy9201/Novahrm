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
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function __construct(
        protected EmployeeService $service
    ) {}

    // INDEX
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'all');
        
        $filters = $request->only([
            'search', 'department_id', 'position_id',
            'status', 'employment_type', 'is_active',
            'gender', 'hire_from', 'hire_to',
            'sort', 'direction',
        ]);

        // Lọc theo tab
        $employees = match($tab) {
            'active'  => $this->service->getList(array_merge($filters, ['is_active' => true]), 15),
            'resigned' => $this->service->getList(array_merge($filters, ['status' => 'resigned']), 15),
            'trash'   => $this->service->getTrashList($filters, 15),
            default   => $this->service->getList($filters, 15),
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

    // CREATE
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

        $provincesNew = json_decode(file_get_contents(app_path('Data/provinces_new.json')), true);
        $provincesOld = json_decode(file_get_contents(app_path('Data/provinces_old.json')), true);
        $educationMajors = json_decode(file_get_contents(app_path('Data/education_industries.json')), true);
        $universities    = json_decode(file_get_contents(app_path('Data/vietnam_universities.json')), true);

        return view('nova-employee::employee.create', compact(
            'employee',
            'departments',
            'positions',
            'managers',
            'employmentTypes',
            'contractTypes',
            'statuses',
            'educationLevels',
            'genders',
            'countries',            
            'preselectedDepartment',
            'provincesNew',
            'provincesOld',
            'educationMajors',
            'universities',
        ));
    }

    // STORE
    public function store(Request $request): RedirectResponse
    {
        $request->merge(
            collect($request->all())
                ->map(fn($v) => $v === '' ? null : $v)
                ->toArray()
        );

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

            // CCCD — đúng 12 số
            'national_id'               => 'nullable|digits:12|unique:employees,national_id',
            'national_id_issued_date'   => 'nullable|date',
            'national_id_issued_place'  => 'nullable|string|max:255',

            // Hộ chiếu — 6-20 ký tự chữ + số
            'passport_number'           => 'nullable|string|min:6|max:20|regex:/^[A-Z0-9]+$/i',
            'passport_expiry_date'      => 'nullable|date',

            // Liên hệ — email chỉ @gmail.com
            'email'                     => 'nullable|email|regex:/^[a-zA-Z0-9._]+@gmail\.com$/|unique:employees,email',
            'work_email'                => 'nullable|email|regex:/^[a-zA-Z0-9._]+@gmail\.com$/|unique:employees,work_email',

            // SĐT — bắt đầu 0, đủ 10 số
            'phone'                     => 'nullable|regex:/^0[0-9]{9}$/',
            'phone_alt'                 => 'nullable|regex:/^0[0-9]{9}$/',
            'emergency_contact_name'    => 'nullable|string|max:255',
            'emergency_contact_phone'   => 'nullable|regex:/^0[0-9]{9}$/',
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
        ], [
            'first_name.required'               => 'Vui lòng nhập họ của nhân viên.',
            'last_name.required'                => 'Vui lòng nhập tên của nhân viên.',
            'employment_type.required'          => 'Vui lòng chọn loại nhân viên.',

            'national_id.digits'                => 'Số CCCD phải đúng 12 chữ số.',
            'national_id.unique'                => 'Số CCCD này đã tồn tại trong hệ thống.',

            'passport_number.min'               => 'Số hộ chiếu tối thiểu 6 ký tự.',
            'passport_number.max'               => 'Số hộ chiếu tối đa 20 ký tự.',
            'passport_number.regex'             => 'Số hộ chiếu chỉ được chứa chữ cái và chữ số.',

            'email.email'                       => 'Email cá nhân không đúng định dạng.',
            'email.regex'                       => 'Email cá nhân phải có đuôi @gmail.com.',
            'email.unique'                      => 'Email cá nhân này đã được sử dụng.',

            'work_email.email'                  => 'Email công ty không đúng định dạng.',
            'work_email.regex'                  => 'Email công ty phải có đuôi @gmail.com.',
            'work_email.unique'                 => 'Email công ty này đã được sử dụng.',

            'phone.regex'                       => 'Số điện thoại phải bắt đầu bằng 0 và đủ 10 chữ số.',
            'phone_alt.regex'                   => 'SĐT phụ phải bắt đầu bằng 0 và đủ 10 chữ số.',
            'emergency_contact_phone.regex'     => 'SĐT liên hệ khẩn cấp phải bắt đầu bằng 0 và đủ 10 chữ số.',

            'date_of_birth.before'              => 'Ngày sinh không hợp lệ.',
            'probation_end_date.after_or_equal' => 'Ngày kết thúc thử việc phải sau ngày bắt đầu.',
            'contract_end_date.after_or_equal'  => 'Ngày kết thúc hợp đồng phải sau ngày bắt đầu.',

            'tax_code.unique'                   => 'Mã số thuế này đã tồn tại trong hệ thống.',
            'social_insurance_code.unique'      => 'Mã BHXH này đã tồn tại trong hệ thống.',

            'avatar.max'                        => 'Ảnh đại diện không được vượt quá 2MB.',
            'avatar.mimes'                      => 'Ảnh đại diện phải là JPG, PNG hoặc WEBP.',
            'cv_path.max'                       => 'File CV không được vượt quá 5MB.',
            'cv_path.mimes'                     => 'File CV phải là PDF, DOC hoặc DOCX.',
        ]);

        try {
            $data['avatar']  = $request->file('avatar');
            $data['cv_path'] = $request->file('cv_path');

            $employee = $this->service->create($data);

            return redirect()
                ->route('hr.employees.show', $employee)
                ->with('success', "Đã thêm nhân viên {$employee->name} thành công.");

        } catch (\Illuminate\Database\QueryException $e) {

            $msg = match(true) {
                str_contains($e->getMessage(), "'email'")
                    => 'Email cá nhân này đã được sử dụng bởi nhân viên khác.',
                str_contains($e->getMessage(), "'work_email'")
                    => 'Email công ty này đã được sử dụng bởi nhân viên khác.',
                str_contains($e->getMessage(), "'national_id'")
                    => 'Số CCCD này đã tồn tại trong hệ thống.',
                str_contains($e->getMessage(), "'tax_code'")
                    => 'Mã số thuế này đã tồn tại trong hệ thống.',
                str_contains($e->getMessage(), "'social_insurance_code'")
                    => 'Mã BHXH này đã tồn tại trong hệ thống.',
                str_contains($e->getMessage(), 'cannot be null')
                    => 'Vui lòng điền đầy đủ các trường bắt buộc trước khi lưu.',
                default
                    => 'Đã có lỗi xảy ra khi lưu dữ liệu. Vui lòng thử lại hoặc liên hệ quản trị viên.',
            };

            return back()->withInput()->withErrors(['error' => $msg]);

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Đã có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
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
            ->where('id', '!=', $employee->id)
            ->with('position')
            ->orderBy('first_name')
            ->get();
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
            'employee',
            'departments',
            'positions',
            'managers',
            'employmentTypes',
            'contractTypes',
            'statuses',
            'educationLevels',
            'genders',
            'countries',
            'provincesNew',
            'provincesOld',
            'educationMajors',
            'universities',
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
            ->route('hr.employees.index', ['tab' => 'trash'])
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

    private function getCountries(): array
    {
        return collect(json_decode(
            file_get_contents(base_path('app/Data/countries.json')),
            true
        ))
        ->map(fn($c) => $c['translations']['vie']['common'] ?? $c['name']['common'])
        ->filter()
        ->sort()
        ->values()
        ->toArray();
    }
}