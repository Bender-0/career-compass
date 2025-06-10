<?php

namespace App\Filament\Exports;

use App\Models\Application;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ApplicationExporter extends Exporter
{
    protected static ?string $model = Application::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            // ExportColumn::make('user.name'),
            ExportColumn::make('job_title'),
            ExportColumn::make('company_name'),
            ExportColumn::make('company_website'),
            ExportColumn::make('applied_date'),
            ExportColumn::make('status'),
            ExportColumn::make('job_description'),
            ExportColumn::make('salary_range'),
            ExportColumn::make('location'),
            ExportColumn::make('application_link'),
            ExportColumn::make('posted_date'),
            ExportColumn::make('application_deadline'),
            // ExportColumn::make('created_at'),
            // ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your application export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
