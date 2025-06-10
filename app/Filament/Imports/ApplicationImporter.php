<?php

namespace App\Filament\Imports;

use App\Models\Application;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ApplicationImporter extends Importer
{
    protected static ?string $model = Application::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('user_id'),
            ImportColumn::make('job_title'),
            ImportColumn::make('job_title'),
            ImportColumn::make('company_name'),
            ImportColumn::make('company_website'),
            ImportColumn::make('applied_date'),
            ImportColumn::make('status'),
            ImportColumn::make('job_description'),
            ImportColumn::make('salary_range'),
            ImportColumn::make('location'),
            ImportColumn::make('application_link'),
            ImportColumn::make('posted_date'),
            ImportColumn::make('application_deadline'),
        ];
    }

    public function resolveRecord(): ?Application
    {
        // return Application::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Application();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your application import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
