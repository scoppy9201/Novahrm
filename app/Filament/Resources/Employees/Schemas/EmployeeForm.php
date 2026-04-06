<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\{TextInput, DatePicker, Select, Toggle, TextArea};
use Filament\Schemas\Schema;
use App\Models\{Position, Department};
use Filament\Schemas\Components\{Section, Grid};
use Illuminate\Database\Eloquent\Builder;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('app.basic_information'))
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('employee_code')
                                ->required()
                                ->maxLength(50)
                                ->label(__('app.employee_code'))
                                ->placeholder(__('app.employee_code_placeholder'))
                                ->columnSpan(1),
                            TextInput::make('first_name')
                                ->required()
                                ->label(__('app.first_name')),
                            TextInput::make('last_name')
                                ->required()
                                ->label(__('app.last_name')),
                            DatePicker::make('date_of_birth')
                                ->label(__('app.date_of_birth')),
                            Select::make('gender')
                                ->label(__('app.gender'))
                                ->options([
                                    'Male'   => __('app.male'),
                                    'Female' => __('app.female'),
                                ]),
                            Select::make('marital_status')
                                ->label(__('app.marital_status'))
                                ->options([
                                    'Single'   => __('app.single'),
                                    'Married'  => __('app.married'),
                                    'Divorced' => __('app.divorced'),
                                    'Widowed'  => __('app.widowed'),
                                ]),
                        ])
                    ])
                    ->columnSpanFull(),

                Section::make(__('app.contact_information'))
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('email')
                                ->email()
                                ->required()
                                ->label(__('app.email_note'))
                                ->unique(ignoreRecord: true)
                                ->copyable(),
                            TextInput::make('phone')
                                ->tel()
                                ->required()
                                ->label(__('app.phone'))
                                ->unique(ignoreRecord: true),
                            TextInput::make('national_id')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->integer()
                                ->label(__('app.national_id')),
                            TextInput::make('kra_pin')
                                ->label(__('app.kra_pin')),
                        ])
                    ])
                    ->columnSpanFull(),

                Section::make(__('app.emergency_contact'))
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('emergency_contact_name')
                                ->label(__('app.emergency_contact_name')),
                            TextInput::make('emergency_contact_phone')
                                ->label(__('app.emergency_contact_phone')),
                        ])
                    ])
                    ->columnSpanFull(),

                Section::make(__('app.next_of_kin'))
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('next_of_kin_name')
                                ->label(__('app.name'))
                                ->required(),
                            TextInput::make('next_of_kin_relationship')
                                ->label(__('app.relationship'))
                                ->required(),
                            TextInput::make('next_of_kin_phone')
                                ->required()
                                ->tel()
                                ->label(__('app.phone')),
                            TextInput::make('next_of_kin_email')
                                ->label(__('app.email'))
                                ->email(),
                        ])
                    ])
                    ->columnSpanFull(),

                Section::make(__('app.employment_details'))
                    ->collapsible()
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('department_id')
                                ->relationship(
                                    name: 'department',
                                    titleAttribute: 'name',
                                    modifyQueryUsing: fn(Builder $query) => $query->select('id', 'name')->orderBy('name', 'asc')
                                )
                                ->label(__('app.department'))
                                ->searchable()
                                ->placeholder(__('app.department_placeholder'))
                                ->preload()
                                ->nullable(),
                            Select::make('position_id')
                                ->options(Position::all()->pluck('title', 'id'))
                                ->label(__('app.position'))
                                ->searchable()
                                ->placeholder(__('app.position_placeholder'))
                                ->preload()
                                ->nullable()
                                ->createOptionForm([
                                    TextInput::make('title')
                                        ->required()
                                        ->label(__('app.position_title')),
                                    Select::make('department_id')
                                        ->label(__('app.department'))
                                        ->options(Department::all()->pluck('name', 'id')),
                                    Grid::make(2)->schema([
                                        TextInput::make('code')
                                            ->label(__('app.position_code'))
                                            ->unique(ignoreRecord: true)
                                            ->nullable(),
                                        TextInput::make('salary')
                                            ->label(__('app.salary'))
                                            ->numeric()
                                            ->nullable(),
                                    ]),
                                    Textarea::make('description')
                                        ->label(__('app.description'))
                                        ->nullable()
                                        ->maxLength(255),
                                ])
                                ->createOptionUsing(function (array $data) {
                                    return Position::create([
                                        'title'         => $data['title'],
                                        'department_id' => $data['department_id'],
                                        'code'          => $data['code'] ?? null,
                                        'salary'        => $data['salary'] ?? null,
                                        'description'   => $data['description'] ?? null,
                                    ])->id;
                                })
                                ->native(false),
                            Select::make('employment_type')
                                ->label(__('app.employment_type'))
                                ->options([
                                    'Permanent' => __('app.permanent'),
                                    'Contract'  => __('app.contract'),
                                    'Casual'    => __('app.casual'),
                                ])
                                ->required(),
                            DatePicker::make('hire_date')
                                ->label(__('app.hire_date'))
                                ->required(),
                            DatePicker::make('termination_date')
                                ->label(__('app.termination_date')),
                            Toggle::make('is_active')
                                ->label(__('app.is_active'))
                                ->default(true),
                        ])
                    ])
                    ->columnSpanFull(),
            ]);
    }
}