<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
use App\Models\Application;
use Illuminate\Support\Str;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Exports\ApplicationExporter;
use App\Filament\Imports\ApplicationImporter;
use App\Filament\Resources\ApplicationResource;
use Filament\Actions\Exports\Enums\ExportFormat;

class ListApplications extends ListRecords
{
    protected static string $resource = ApplicationResource::class;
    private const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'interview' => 'Interview',
        'offer' => 'Offer',
        'rejected' => 'Rejected',
    ];
    private const STATUS_COLORS = [
        'pending' => 'gray',
        'interview' => 'info',
        'offer' => 'success',
        'rejected' => 'danger',
    ];

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                $this->createMainInfoStack(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                $this->createStatusFilter(),
            ])
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated([9, 18, 27, 'all']) //TODO: remove ('all') on production
            ->searchDebounce('1000ms')
            ->headerActions([
                $this->createExportAction(),
                $this->createImportAction(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    private function createMainInfoStack(): Stack
    {
        return Stack::make([
            $this->createJobTitleColumn(),
            $this->createCompanyNameColumn(),
            $this->createStatusColumn(),
            $this->createJobDetailsGrid(),
            $this->createMetricsRow(),
        ]);
    }

    private function createJobTitleColumn(): TextColumn
    {
        return TextColumn::make('job_title')
            ->tooltip(fn (Application $record): string => Str::length($record->job_title) > 25
                ? "Job Title: {$record->job_title}"
                : 'Job Title'
            )
            ->searchable()
            ->weight('bold')
            ->size('lg')
            ->limit(25)
            ->extraAttributes(['class' => 'items-center justify-center']);
    }

    private function createCompanyNameColumn(): TextColumn
    {
        return TextColumn::make('company_name')
            ->tooltip('Company Name')
            ->searchable()
            ->limit(25)
            ->extraAttributes(['class' => 'items-center justify-center']);
    }

    private function createStatusColumn(): TextColumn
    {
        return TextColumn::make('status')
            ->tooltip('Status')
            ->badge()
            ->color(fn (string $state): string => self::STATUS_COLORS[$state] ?? 'gray')
            ->extraAttributes(['class' => 'items-center justify-center'])
            ->columnSpanFull();
    }

    private function createDateLocationResumeRow(): Stack
    {
        return Stack::make([
            TextColumn::make('applied_date')
                ->tooltip('Applied Date')
                ->date('d.M.Y')
                ->sortable()
                ->icon('heroicon-o-calendar'),
            TextColumn::make('location')
                ->tooltip(fn (Application $record): string => Str::length($record->location) > 13
                    ? "Location: {$record->location}"
                    : 'Location'
                )
                ->limit(13)
                ->icon('heroicon-o-map-pin')
                ->searchable(),
            $this->createDocumentColumn('resume', 'resume', 'Resume'),
        ]);
    }

    private function createSalaryTypeDocumentRow(): Stack
    {
        return Stack::make([
            TextColumn::make('salary_range')
                ->tooltip(fn (Application $record): string => Str::length($record->salary_range) > 13
                    ? "Salary Range: {$record->salary_range}"
                    : 'Salary Range'
                )
                ->limit(13)
                ->icon('heroicon-o-currency-dollar'),
            TextColumn::make('job_type')
                ->tooltip('Job Type')
                ->icon('heroicon-o-briefcase')
                ->searchable(),
            $this->createDocumentColumn('cover_letter', 'coverLetter', 'Cover Letter'),
        ]);
    }

    private function createJobDetailsGrid(): Split
    {
        return Split::make([
                $this->createDateLocationResumeRow(),
                $this->createSalaryTypeDocumentRow(),
            ]);
    }

    private function createDocumentColumn(string $column, string $relationship, string $label): TextColumn
    {
        return TextColumn::make($column)
            ->icon(fn (bool $state): string => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
            ->state(function (Application $record) use ($relationship): bool {
                $hasDocument = $record->$relationship !== null;

                return $hasDocument;
            })
            ->formatStateUsing(function (bool $state) use ($label): string {
                return $state ? $label : "<del>$label</del>";
            })
            ->html()
            // ->formatStateUsing(fn (): string => $label)
            ->color(fn (bool $state): string => $state ? 'success' : 'gray');
    }

    private function createMetricsRow(): Split
    {
        return Split::make([
            $this->createMetricColumn('notes_count', 'heroicon-o-document-text', 'Notes', 'notes', 'justify-start'),
            $this->createMetricColumn('contacts_count', 'heroicon-o-user', 'Contacts', 'contacts', 'items-center justify-center'),
            $this->createMetricColumn('tasks_count', 'heroicon-o-check-circle', 'Tasks', 'tasks', 'justify-end'),
        ])
        ->extraAttributes(['class' => 'mt-3'])
        ->columnSpanFull();
    }

    private function createMetricColumn(string $name, string $icon, string $tooltip, string $relationship, string $alignment): TextColumn
    {
        return TextColumn::make($name)
            ->icon($icon)
            ->badge()
            ->tooltip($tooltip)
            ->counts($relationship)
            ->extraAttributes(['class' => $alignment]);
    }

    private function createStatusFilter(): SelectFilter
    {
        return SelectFilter::make('status')
            ->options(self::STATUS_OPTIONS);
    }

    private function createExportAction(): ExportAction
    {
        return ExportAction::make()
            ->exporter(ApplicationExporter::class)
            ->formats([ExportFormat::Csv])
            ->fileName(fn (): string => 'job_application_' . now()->format('d_m_y'));
    }

    private function createImportAction(): ImportAction
    {
        return ImportAction::make()
            ->importer(ApplicationImporter::class);
    }
}