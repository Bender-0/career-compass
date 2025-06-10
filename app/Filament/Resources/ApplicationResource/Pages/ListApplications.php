<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Exports\Models\Export;
use Filament\Tables\Actions\BulkActionGroup;
use App\Filament\Exports\ApplicationExporter;
use App\Filament\Imports\ApplicationImporter;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\ApplicationResource;
use Filament\Actions\Exports\Enums\ExportFormat;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;

    protected function getTableRecordUrlUsing(): ?\Closure
    {
        return null; // Disable click-through to edit page
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('job_title')
                        ->tooltip('Job Title')
                        ->searchable()
                        ->weight('bold')
                        ->size('lg')
                        ->extraAttributes([
                            'class' => 'items-center justify-center',
                        ]),
                    TextColumn::make('company_name')
                        ->tooltip('Company Name')
                        ->searchable()
                        ->extraAttributes([
                            'class' => 'items-center justify-center',
                        ]),
                    
                    TextColumn::make('status')
                        ->tooltip('Status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending' => 'gray',
                            'interview' => 'info',
                            'offer' => 'success',
                            'rejected' => 'danger',
                            default => 'gray',
                        })
                        ->extraAttributes([
                            'class' => 'items-center justify-center',
                        ])
                        ->columnSpanFull(),

                    TextColumn::make('applied_date')
                        ->tooltip('Applied Date')
                        ->date('d.M.Y')
                        ->sortable()
                        ->icon('heroicon-o-calendar'),
                    
                    Split::make([
                        TextColumn::make('location')
                            ->tooltip('Location')
                            ->icon('heroicon-o-map-pin')
                            ->searchable(),
                        TextColumn::make('salary_range')
                            ->tooltip('Salary Range')
                            ->icon('heroicon-o-currency-dollar')
                    ]),

                    Split::make([
                        TextColumn::make('notes_count') //notes number
                            ->icon('heroicon-o-document-text')
                            ->badge()
                            ->tooltip('Notes')
                            ->counts('notes')
                            ->extraAttributes([
                                'class' => 'justify-start',
                            ]),

                        TextColumn::make('contacts_count') //contacts number
                            ->icon('heroicon-o-user')
                            ->badge()
                            ->tooltip('Contacts')
                            ->counts('contacts')
                            ->extraAttributes([
                                'class' => 'items-center justify-center',
                            ]),
                        
                        TextColumn::make('tasks_count') //tasks number
                            ->icon('heroicon-o-check-circle')
                            ->badge()
                            ->tooltip('Tasks')
                            ->counts('tasks')
                            ->extraAttributes([
                                'class' => 'justify-end',
                            ]),
                    ])
                    ->extraAttributes([
                        'class' => 'mt-3',
                    ])
                    
                    ->columnSpanFull(),
                ]), 
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'interview' => 'Interview',
                        'offer' => 'Offer',
                        'rejected' => 'Rejected',
                    ])
            ])
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated([9, 18, 27, 'all'])
            ->searchDebounce('1000ms')
            ->headerActions([
                ExportAction::make()
                    ->exporter(ApplicationExporter::class)
                    ->formats([
                        ExportFormat::Csv,
                    ])
                    ->fileName(fn (): string => 'job_application_' . now()->format('d_m_y') . '.csv'),

                ImportAction::make()
                    ->importer(ApplicationImporter::class)
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
