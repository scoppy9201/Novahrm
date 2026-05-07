<?php

namespace Nova\Department\Observers;

use Nova\OrgChart\Models\Department;
use Filament\Notifications\Notification;

class DepartmentObserver
{
    public function created(Department $department): void
    {
        $this->sendManagerNotification($department);
    }

    public function updated(Department $department): void
    {
        $this->sendManagerNotification($department);
    }

    public function deleted(Department $department): void {}

    public function restored(Department $department): void {}

    public function forceDeleted(Department $department): void {}

    private function sendManagerNotification(Department $department): void
    {
        if (!$department->manager) {
            return;
        }

        Notification::make()
            ->title('You have been assigned a department')
            ->body($department->name)
            ->info()
            ->sendToDatabase($department->manager);
    }
}