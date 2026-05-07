<?php

namespace Nova\Employee\Services;

use Nova\Auth\Models\Employee;
use Nova\OrgChart\Models\Department;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class EmployeeService
{
    public function generateCode(): string
    {
        $year = now()->year;
        $last = Employee::whereYear('created_at', $year)
            ->orderByDesc('id')
            ->value('employee_code');

        $seq = $last ? ((int) substr($last, -4)) + 1 : 1;
        return 'NV-' . $year . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    public function create(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            $data['employee_code'] = $this->generateCode();

            if (isset($data['avatar']) && is_object($data['avatar'])) {
                $data['avatar'] = $data['avatar']->store('avatars', 'public');
            }
            if (isset($data['cv_path']) && is_object($data['cv_path'])) {
                $data['cv_path'] = $data['cv_path']->store('employees/cv', 'public');
            }
            if (isset($data['signature_path']) && is_object($data['signature_path'])) {
                $data['signature_path'] = $data['signature_path']->store('employees/signatures', 'public');
            }

            if (empty($data['status'])) {
                $data['status'] = match($data['employment_type'] ?? 'full_time') {
                    'probation', 'intern' => 'probation',
                    default               => 'active',
                };
            }

            $employee = Employee::create($data);

            if ($employee->position_id) {
                $this->syncHeadcount($employee->position_id);
            }

            return $employee;
        });
    }

    public function update(Employee $employee, array $data): Employee
    {
        return DB::transaction(function () use ($employee, $data) {
            $oldPositionId = $employee->position_id;

            if (isset($data['avatar']) && is_object($data['avatar'])) {
                $this->deleteFile($employee->avatar);
                $data['avatar'] = $data['avatar']->store('avatars', 'public');
            }
            if (isset($data['cv_path']) && is_object($data['cv_path'])) {
                $this->deleteFile($employee->cv_path);
                $data['cv_path'] = $data['cv_path']->store('employees/cv', 'public');
            }
            if (isset($data['signature_path']) && is_object($data['signature_path'])) {
                $this->deleteFile($employee->signature_path);
                $data['signature_path'] = $data['signature_path']->store('employees/signatures', 'public');
            }

            $employee->update($data);

            if ($oldPositionId !== $employee->position_id) {
                if ($oldPositionId) $this->syncHeadcount($oldPositionId);
                if ($employee->position_id) $this->syncHeadcount($employee->position_id);
            }

            return $employee->fresh();
        });
    }

    public function delete(Employee $employee): void
    {
        if ($employee->subordinates()->exists()) {
            throw new \RuntimeException(
                'Không thể xóa — nhân viên này đang quản lý ' .
                $employee->subordinates()->count() . ' người.'
            );
        }

        $this->deleteFile($employee->avatar);
        $this->deleteFile($employee->cv_path);
        $this->deleteFile($employee->signature_path);

        $employee->delete();
    }

    public function restore(int $id): Employee
    {
        $employee = Employee::withTrashed()->findOrFail($id);
        $employee->restore();
        return $employee;
    }

    public function forceDelete(Employee $employee): void
    {
        $this->deleteFile($employee->avatar);
        $this->deleteFile($employee->cv_path);
        $this->deleteFile($employee->signature_path);
        $employee->forceDelete();
    }

    public function terminate(Employee $employee, array $data): Employee
    {
        DB::transaction(function () use ($employee, $data) {
            $employee->update([
                'is_active'          => false,
                'status'             => $data['status'],
                'termination_date'   => $data['termination_date'],
                'termination_reason' => $data['termination_reason'] ?? null,
                'termination_type'   => $data['termination_type'] ?? 'voluntary',
            ]);

            Department::where('manager_id', $employee->id)->update(['manager_id' => null]);

            if ($employee->position_id) {
                $this->syncHeadcount($employee->position_id);
            }
        });

        return $employee->fresh();
    }

    public function reinstate(Employee $employee): Employee
    {
        $employee->update([
            'is_active'          => true,
            'status'             => 'active',
            'termination_date'   => null,
            'termination_reason' => null,
            'termination_type'   => null,
        ]);

        return $employee->fresh();
    }

    public function updateAvatar(Employee $employee, UploadedFile $file): Employee
    {
        $this->deleteFile($employee->avatar);
        $path = $file->store('avatars', 'public');
        $employee->update(['avatar' => $path]);
        return $employee->fresh();
    }

    public function deleteAvatar(Employee $employee): Employee
    {
        $this->deleteFile($employee->avatar);
        $employee->update(['avatar' => null]);
        return $employee->fresh();
    }

    public function transfer(Employee $employee, array $data): Employee
    {
        return DB::transaction(function () use ($employee, $data) {
            $oldPositionId = $employee->position_id;

            $employee->update([
                'department_id' => $data['department_id'] ?? $employee->department_id,
                'position_id'   => $data['position_id']   ?? $employee->position_id,
                'manager_id'    => $data['manager_id']    ?? $employee->manager_id,
            ]);

            if ($oldPositionId && $oldPositionId !== $employee->position_id) {
                $this->syncHeadcount($oldPositionId);
            }
            if ($employee->position_id) {
                $this->syncHeadcount($employee->position_id);
            }

            return $employee->fresh(['department', 'position', 'manager']);
        });
    }

    public function getStats(): array
    {
        return [
            'total'              => Employee::count(),
            'active'             => Employee::active()->count(),
            'inactive'           => Employee::inactive()->count(),
            'hired_this_month'   => Employee::hiredThisMonth()->count(),
            'contract_expiring'  => Employee::contractExpiringSoon(30)->count(),
            'probation_ending'   => Employee::probationEnding(7)->count(),
            'by_department'      => $this->getStatsByDepartment(),
            'by_employment_type' => $this->getStatsByEmploymentType(),
            'by_status'          => $this->getStatsByStatus(),
            'sparkline_total'    => $this->normalizeSparkline($this->getTotalSparkline()),
            'sparkline_active'   => $this->normalizeSparkline($this->getActiveSparkline()),
            'sparkline_hired'    => $this->normalizeSparkline($this->getHiredSparkline()),
            'sparkline_expiring' => $this->normalizeSparkline($this->getExpiringSparkline()),
        ];
    }

    public function getStatsByDepartment(): Collection
    {
        return Department::withCount([
            'employees',
            'employees as active_employees_count' => fn($q) => $q->where('is_active', true),
        ])->get();
    }

    public function getStatsByEmploymentType(): array
    {
        return Employee::selectRaw('employment_type, COUNT(*) as total')
            ->groupBy('employment_type')
            ->pluck('total', 'employment_type')
            ->toArray();
    }

    public function getStatsByStatus(): array
    {
        return Employee::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
    }

    public function getList(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Employee::with(['department', 'position', 'manager'])
            ->when($filters['search'] ?? null, fn($q, $s) =>
                $q->where(fn($q) => $q
                    ->where('first_name', 'like', "%{$s}%")
                    ->orWhere('last_name', 'like', "%{$s}%")
                    ->orWhere('employee_code', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%")
                    ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$s}%"])
                )
            )
            ->when($filters['department_id'] ?? null, fn($q, $v) => $q->where('department_id', $v))
            ->when($filters['position_id'] ?? null,   fn($q, $v) => $q->where('position_id', $v))
            ->when($filters['status'] ?? null,         fn($q, $v) => $q->where('status', $v))
            ->when($filters['employment_type'] ?? null, fn($q, $v) => $q->where('employment_type', $v))
            ->when($filters['is_active'] ?? null,      fn($q, $v) => $q->where('is_active', (bool) $v))
            ->when($filters['gender'] ?? null,         fn($q, $v) => $q->where('gender', $v))
            ->when($filters['hire_from'] ?? null,      fn($q, $v) => $q->where('hire_date', '>=', $v))
            ->when($filters['hire_to'] ?? null,        fn($q, $v) => $q->where('hire_date', '<=', $v))
            ->orderBy($filters['sort'] ?? 'created_at', $filters['direction'] ?? 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getTrashList(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return Employee::onlyTrashed()
            ->with(['department', 'position'])
            ->when($filters['search'] ?? null, fn($q, $s) =>
                $q->where(fn($q) => $q
                    ->where('first_name', 'like', "%{$s}%")
                    ->orWhere('last_name', 'like', "%{$s}%")
                    ->orWhere('employee_code', 'like', "%{$s}%")
                )
            )
            ->orderBy('deleted_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function search(string $keyword, int $limit = 10): Collection
    {
        return Employee::with(['position', 'department'])
            ->where('is_active', true)
            ->where(fn($q) => $q
                ->where('first_name', 'like', "%{$keyword}%")
                ->orWhere('last_name', 'like', "%{$keyword}%")
                ->orWhere('employee_code', 'like', "%{$keyword}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$keyword}%"])
            )
            ->limit($limit)
            ->get();
    }

    public function getAlerts(): array
    {
        return [
            'contract_expiring' => Employee::contractExpiringSoon(30)->where('is_active', true)->count(),
            'probation_ending'  => Employee::probationEnding(7)->where('is_active', true)->count(),
            'no_contract'       => Employee::where('is_active', true)->whereNull('contract_type')->whereNull('contract_start_date')->count(),
            'birthday_this_week' => Employee::where('is_active', true)
                ->whereRaw('MONTH(date_of_birth) = ?', [now()->month])
                ->whereBetween(DB::raw('DAY(date_of_birth)'), [now()->day, now()->addDays(7)->day])
                ->count(),
        ];
    }

    public function getCounts(): array
    {
        return [
            'all'     => Employee::count(),
            'active'  => Employee::where('is_active', true)->count(),
            'resigned' => Employee::where('status', 'resigned')->count(),
            'trash'   => Employee::onlyTrashed()->count(),
        ];
    }

    public function getExportData(array $filters = []): Collection
    {
        return Employee::with(['department', 'position', 'manager'])
            ->when($filters['department_id'] ?? null, fn($q, $v) => $q->where('department_id', $v))
            ->when($filters['status'] ?? null,         fn($q, $v) => $q->where('status', $v))
            ->when($filters['is_active'] ?? null,      fn($q, $v) => $q->where('is_active', (bool) $v))
            ->orderBy('employee_code')
            ->get();
    }

    public function getHiredSparkline(int $months = 6): array
    {
        $raw = Employee::selectRaw('YEAR(hire_date) as year, MONTH(hire_date) as month, COUNT(*) as total')
            ->where('hire_date', '>=', now()->subMonths($months - 1)->startOfMonth())
            ->groupByRaw('YEAR(hire_date), MONTH(hire_date)')
            ->get()->keyBy(fn($r) => $r->year . '-' . $r->month);

        return collect(range(0, $months - 1))->map(function ($i) use ($raw, $months) {
            $date = now()->subMonths(($months - 1) - $i);
            return (int) ($raw->get($date->year . '-' . $date->month)->total ?? 0);
        })->toArray();
    }

    public function getActiveSparkline(int $months = 7): array
    {
        $raw = Employee::selectRaw('YEAR(hire_date) as year, MONTH(hire_date) as month, COUNT(*) as total')
            ->where('is_active', true)
            ->where('hire_date', '>=', now()->subMonths($months - 1)->startOfMonth())
            ->groupByRaw('YEAR(hire_date), MONTH(hire_date)')
            ->get()->keyBy(fn($r) => $r->year . '-' . $r->month);

        return collect(range(0, $months - 1))->map(function ($i) use ($raw, $months) {
            $date = now()->subMonths(($months - 1) - $i);
            return (int) ($raw->get($date->year . '-' . $date->month)->total ?? 0);
        })->toArray();
    }

    public function getTotalSparkline(int $months = 7): array
    {
        $raw = Employee::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths($months - 1)->startOfMonth())
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->get()->keyBy(fn($r) => $r->year . '-' . $r->month);

        return collect(range(0, $months - 1))->map(function ($i) use ($raw, $months) {
            $date = now()->subMonths(($months - 1) - $i);
            return (int) ($raw->get($date->year . '-' . $date->month)->total ?? 0);
        })->toArray();
    }

    public function getExpiringSparkline(int $months = 7): array
    {
        $raw = Employee::selectRaw('YEAR(contract_end_date) as year, MONTH(contract_end_date) as month, COUNT(*) as total')
            ->whereNotNull('contract_end_date')
            ->where('contract_end_date', '>=', now()->subMonths($months - 1)->startOfMonth())
            ->where('contract_end_date', '<=', now()->addMonths(1)->endOfMonth())
            ->groupByRaw('YEAR(contract_end_date), MONTH(contract_end_date)')
            ->get()->keyBy(fn($r) => $r->year . '-' . $r->month);

        return collect(range(0, $months - 1))->map(function ($i) use ($raw, $months) {
            $date = now()->subMonths(($months - 1) - $i);
            return (int) ($raw->get($date->year . '-' . $date->month)->total ?? 0);
        })->toArray();
    }

    private function syncHeadcount(int $positionId): void
    {
        // Có thể mở rộng sau
    }

    private function deleteFile(?string $path): void
    {
        if ($path && !str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }

    private function normalizeSparkline(array $data): array
    {
        $max   = max($data) ?: 1;
        $min   = min($data);
        $range = $max - $min ?: 1;

        return array_map(fn($v) => (int) round((($v - $min) / $range) * 70 + 15), $data);
    }
}