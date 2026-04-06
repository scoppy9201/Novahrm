<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use App\Models\Employee;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('app.department_name'))
                    ->placeholder(__('app.department_name_placeholder')),

                TextInput::make('code')
                    ->maxLength(50)
                    ->label(__('app.department_code'))
                    ->placeholder(__('app.department_code_placeholder')),

                Textarea::make('description')
                    ->maxLength(500)
                    ->label(__('app.description'))
                    ->placeholder(__('app.description_placeholder')),

                Select::make('manager_id')
                    ->options(fn() => Employee::all()->pluck('name', 'id'))
                    ->label(__('app.manager'))
                    ->placeholder(__('app.manager_placeholder'))
                    ->preload()
                    ->searchable()
                    ->nullable(),
            ]);
    }
}