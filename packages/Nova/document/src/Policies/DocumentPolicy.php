<?php

namespace Nova\document\Policies;

use Nova\document\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;
use Nova\Auth\Models\Employee;

class DocumentPolicy
{
    use HandlesAuthorization;

    private function isPrivileged(Employee $user): bool
    {
        return in_array($user->role, ['hr', 'admin', 'manager']);
    }

    public function viewAny(Employee $user): bool
    {
        return true;
    }

    public function view(Employee $user, Document $document): bool
    {
        if ($this->isPrivileged($user)) return true;
        if ($document->employee_id === $user->id) return true;
        if ($document->uploaded_by === $user->id) return true;
        if (is_null($document->employee_id) && !$document->is_confidential) return true;

        return false;
    }

    public function create(Employee $user): bool
    {
        return true;
    }

    public function update(Employee $user, Document $document): bool
    {
        if (in_array($user->role, ['hr', 'admin'])) return true;
        return $document->uploaded_by === $user->id;
    }

    public function delete(Employee $user, Document $document): bool
    {
        if (in_array($user->role, ['hr', 'admin'])) return true;
        return $document->uploaded_by === $user->id;
    }

    public function approve(Employee $user, Document $document): bool
    {
        return in_array($user->role, ['hr', 'admin', 'manager']);
    }
}