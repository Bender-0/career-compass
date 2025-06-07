<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Application;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\ApplicationResource\Pages\EditApplication;
use App\Filament\Resources\ApplicationResource\Pages\ViewApplication;
use App\Filament\Resources\ApplicationResource\Pages\ListApplications;
use App\Filament\Resources\ApplicationResource\Pages\CreateApplication;
use Filament\Forms\Components\Group;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Forms\Components\TextInput::make('job_title')
                        ->required(),
                    Forms\Components\TextInput::make('company_name')
                        ->required(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])
                ->columnSpanFull(),

                Group::make([
                    Forms\Components\DatePicker::make('applied_date')
                        ->prefixIcon('heroicon-o-calendar')
                        ->native(false)
                        ->displayFormat('d M, Y')
                        ->default(now())
                        ->required(),
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'interview' => 'Interview',
                            'offer' => 'Offer',
                            'rejected' => 'Rejected',
                        ])
                        ->default('pending')
                        ->required(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])
                ->columnSpanFull(),

                Forms\Components\RichEditor::make('job_description')
                    ->columnSpanFull()
                    ->required(),

                Group::make([
                    Forms\Components\TextInput::make('salary_range')
                        ->prefixIcon('heroicon-o-currency-dollar')
                        ->required(),
                    Forms\Components\TextInput::make('location')
                        ->prefixIcon('heroicon-o-map-pin')
                        ->required(),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])
                ->columnSpanFull(),

                Forms\Components\TextInput::make('application_link')
                    ->prefixIcon('heroicon-o-link')
                    ->columnSpanFull()
                    ->required(),

                Group::make([
                    Forms\Components\DatePicker::make('posted_date')
                        ->prefixIcon('heroicon-o-calendar')
                        ->native(false)
                        ->displayFormat('d M, Y')
                        ->required(),
                    Forms\Components\DatePicker::make('application_deadline')
                        ->prefixIcon('heroicon-o-calendar')
                        ->native(false)
                        ->displayFormat('d M, Y'),
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])
                ->columnSpanFull(),

                Group::make([
                    Forms\Components\FileUpload::make('resume'),
                    Forms\Components\FileUpload::make('cover_letter'), //this can be ehter text or upload pdf?
                ])
                ->columns([
                    'sm' => 1,
                    'md' => 2,
                ])
                ->columnSpanFull(),
            ]);
            // ->actions([
            //     Action::make('view')
            //         ->url(fn ($record) => ApplicationResource::getUrl('edit', ['record' => $record]))
            //         ->icon('heroicon-o-pencil')
            // ]);
    }

    

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApplications::route('/'),
            'create' => CreateApplication::route('/create'),
            'view' => ViewApplication::route('/{record}'),
            'edit' => EditApplication::route('/{record}/edit'),
        ];
    }
}
