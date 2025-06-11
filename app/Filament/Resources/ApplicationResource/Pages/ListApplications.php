<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
use App\Models\Application;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Grid;
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

    // Cache status options to avoid duplication
    private const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'interview' => 'Interview',
        'offer' => 'Offer',
        'rejected' => 'Rejected',
    ];

    // Cache status colors
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
                $this->buildMainStack(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                $this->buildStatusFilter(),
            ])
            ->contentGrid([
                'sm' => 1,
                'md' => 2,
                'xl' => 3,
            ])
            ->paginated([9, 18, 27, 'all'])
            ->searchDebounce('1000ms')
            ->headerActions([
                $this->buildExportAction(),
                $this->buildImportAction(),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    private function buildMainStack(): Stack
    {
        return Stack::make([
            $this->buildJobTitleColumn(),
            $this->buildCompanyNameColumn(),
            $this->buildStatusColumn(),
            $this->buildAppliedDateColumn(),
            $this->buildLocationSalaryRow(),
            $this->buildDocumentsGrid(),
            $this->buildCountsRow(),
        ]);
    }

    private function buildJobTitleColumn(): TextColumn
    {
        return TextColumn::make('job_title')
            ->tooltip(fn (Application $record): string => 'Job Title: ' . $record->job_title)
            ->searchable()
            ->weight('bold')
            ->size('lg')
            // ->description(fn (Application $record): string => $record->job_title)
            ->limit(30)
            ->extraAttributes(['class' => 'items-center justify-center']);
    }

    private function buildCompanyNameColumn(): TextColumn
    {
        return TextColumn::make('company_name')
            ->tooltip('Company Name')
            ->searchable()
            ->limit(30)
            ->extraAttributes(['class' => 'items-center justify-center']);
    }

    private function buildStatusColumn(): TextColumn
    {
        return TextColumn::make('status')
            ->tooltip('Status')
            ->badge()
            ->color(fn (string $state): string => self::STATUS_COLORS[$state] ?? 'gray')
            ->extraAttributes(['class' => 'items-center justify-center'])
            ->columnSpanFull();
    }

    private function buildAppliedDateColumn(): TextColumn
    {
        return TextColumn::make('applied_date')
            ->tooltip('Applied Date')
            ->date('d.M.Y')
            ->sortable()
            ->icon('heroicon-o-calendar');
    }

    private function buildLocationSalaryRow(): Split
    {
        return Split::make([
            TextColumn::make('location')
                ->tooltip('Location')
                ->icon('heroicon-o-map-pin')
                ->searchable(),
            TextColumn::make('salary_range')
                ->tooltip('Salary Range')
                ->icon('heroicon-o-currency-dollar'),
        ]);
    }

    private function buildDocumentsGrid(): Grid
    {
        return Grid::make()
            ->schema([
                $this->buildDocumentColumn('resume', 'Resume'),
                $this->buildDocumentColumn('cover_letter', 'Cover Letter'),
            ])
            ->extraAttributes(['class' => 'items-center justify-center']);
    }

    private function buildDocumentColumn(string $documentType, string $label): TextColumn
    {
        return TextColumn::make("has_{$documentType}")
            ->icon('heroicon-o-document-text')
            ->badge()
            ->tooltip($label)
            ->state(function (Application $record) use ($documentType, $label): string {
                $hasDocument = $record->document?->{$documentType} !== null;
                return "{$label}: " . ($hasDocument ? 'Yes' : 'No');
            })
            ->color(function (string $state) use ($label): string {
                return str_contains($state, "{$label}: Yes") ? 'success' : 'gray';
            });
    }

    private function buildCountsRow(): Split
    {
        return Split::make([
            $this->buildCountColumn('notes_count', 'heroicon-o-document-text', 'Notes', 'notes', 'justify-start'),
            $this->buildCountColumn('contacts_count', 'heroicon-o-user', 'Contacts', 'contacts', 'items-center justify-center'),
            $this->buildCountColumn('tasks_count', 'heroicon-o-check-circle', 'Tasks', 'tasks', 'justify-end'),
        ])
        ->extraAttributes(['class' => 'mt-3'])
        ->columnSpanFull();
    }

    private function buildCountColumn(string $name, string $icon, string $tooltip, string $relationship, string $alignment): TextColumn
    {
        return TextColumn::make($name)
            ->icon($icon)
            ->badge()
            ->tooltip($tooltip)
            ->counts($relationship)
            ->extraAttributes(['class' => $alignment]);
    }

    private function buildStatusFilter(): SelectFilter
    {
        return SelectFilter::make('status')
            ->options(self::STATUS_OPTIONS);
    }

    private function buildExportAction(): ExportAction
    {
        return ExportAction::make()
            ->exporter(ApplicationExporter::class)
            ->formats([ExportFormat::Csv])
            ->fileName(fn (): string => 'job_application_' . now()->format('d_m_y'));
    }

    private function buildImportAction(): ImportAction
    {
        return ImportAction::make()
            ->importer(ApplicationImporter::class);
    }
}