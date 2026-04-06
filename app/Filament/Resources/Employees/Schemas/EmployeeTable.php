<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Tables\Table;
use App\Models\{Employee, Position, Department};
use Filament\Tables\Filters\{Filter, SelectFilter};
use Filament\Tables\Columns\{TextColumn, ToggleColumn};
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\{ActionGroup, EditAction, ViewAction, DeleteAction, BulkActionGroup, DeleteBulkAction};

class EmployeeTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Employee::query()
                    ->with(['department'])
                    ->latest()
            )
            ->filters([
                Filter::make('is_active')
                    ->label(__('app.active_employees'))
                    ->query(fn(Builder $query): Builder => $query->where('is_active', true))
                    ->default(false),
                Filter::make('is_inactive')
                    ->label(__('app.inactive_employees'))
                    ->query(fn(Builder $query): Builder => $query->where('is_active', false))
                    ->default(false),
                SelectFilter::make('department_id')
                    ->label(__('app.department'))
                    ->options(fn() => Department::all()->pluck('name', 'id'))
                    ->searchable(),
                SelectFilter::make('employment_type')
                    ->label(__('app.employment_type'))
                    ->options([
                        'Permanent' => __('app.permanent'),
                        'Contract'  => __('app.contract'),
                        'Casual'    => __('app.casual'),
                    ]),
                SelectFilter::make('position_id')
                    ->label(__('app.position'))
                    ->options(Position::all()->pluck('title', 'id'))
                    ->searchable(),
            ])
            ->columns([
                TextColumn::make('employee_code')
                    ->label(__('app.employee_code'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('app.name'))
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),
                TextColumn::make('department.name')
                    ->label(__('app.department'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position.title')
                    ->label(__('app.position'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('app.email'))
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label(__('app.phone'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_id')
                    ->label(__('app.national_id'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('kra_pin')
                    ->label(__('app.kra_pin'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('employment_type')
                    ->label(__('app.employment_type'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('app.is_active'))
                    ->sortable(),
                TextColumn::make('date_of_birth')
                    ->label(__('app.date_of_birth'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('termination_date')
                    ->label(__('app.termination_date'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('hire_date')
                    ->label(__('app.hire_date'))
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    ViewAction::make(),
                    DeleteAction::make(),
                ])
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
