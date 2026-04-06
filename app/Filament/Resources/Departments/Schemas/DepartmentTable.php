<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Tables\Table;
use Filament\Actions\{ActionGroup, EditAction, ViewAction, DeleteAction, BulkActionGroup, DeleteBulkAction};
use Filament\Tables\Columns\TextColumn;
use App\Models\Department;

class DepartmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->query(
                Department::query()->with('manager')->latest()
            )
            ->columns([
                TextColumn::make('name')
                    ->label(__('app.department_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('code')
                    ->label(__('app.department_code'))
                    ->searchable()
                    ->sortable()
                    ->limit(10),

                TextColumn::make('description')
                    ->label(__('app.description'))
                    ->limit(50),

                TextColumn::make('manager_id')
                    ->label(__('app.manager'))
                    ->formatStateUsing(fn($record) => $record->manager?->full_name ?? __('app.no_manager'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([])
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