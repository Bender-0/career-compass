<?php

namespace App\Filament\Resources\ApplicationResource\Pages;

use Filament\Actions;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ApplicationResource;

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
                        ->searchable()
                        ->weight('bold')
                        ->size('lg')
                        ->extraAttributes([
                            'class' => 'items-center justify-center',
                        ]),
                    TextColumn::make('company_name')
                        ->searchable()
                        ->color('primary')
                        ->extraAttributes([
                            'class' => 'items-center justify-center',
                        ]),
                    
                    TextColumn::make('status')
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
                        ->date('d.M.Y')
                        ->sortable()
                        ->icon('heroicon-o-calendar'),
                    
                    Split::make([
                        TextColumn::make('location')
                            ->icon('heroicon-o-map-pin')
                            ->searchable(),
                        TextColumn::make('salary_range')
                            ->icon('heroicon-o-currency-dollar')
                    ]),

                    Split::make([
                        TextColumn::make('contacts_count') //contacts number
                            ->icon('heroicon-o-user')
                            ->badge()
                            ->counts('contacts'),
                        TextColumn::make('notes_count') //notes number
                            ->icon('heroicon-o-document-text')
                            ->badge()
                            ->counts('notes'),
                        TextColumn::make('tasks_count') //tasks number
                            ->icon('heroicon-o-check-circle')
                            ->badge()
                            ->counts('tasks'),
                    ])
                    ->extraAttributes([
                        'class' => 'items-center justify-center',
                    ])
                    ->columnSpanFull(),
                ]), 
            ])
            ->defaultSort('applied_date', 'desc')
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
            ->searchDebounce('1000ms');
            // ->actions([
            //     Action::make('view')
            //         ->url(fn ($record) => ApplicationResource::getUrl('edit', ['record' => $record]))
            //         ->icon('heroicon-o-pencil')
            // ])
            // ->bulkActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
