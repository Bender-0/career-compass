<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Application;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\ApplicationResource\Pages\EditApplication;
use App\Filament\Resources\ApplicationResource\Pages\ViewApplication;
use App\Filament\Resources\ApplicationResource\Pages\ListApplications;
use App\Filament\Resources\ApplicationResource\Pages\CreateApplication;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Application')
                            ->icon('heroicon-o-rectangle-stack')
                            ->schema([
                                Group::make([
                                    Forms\Components\TextInput::make('user_id')
                                        ->default(auth()->user()->id)
                                        ->hidden()
                                        ->dehydratedWhenHidden(),
                                    Forms\Components\TextInput::make('job_title')
                                        ->required(),
                                    Forms\Components\TextInput::make('company_name')
                                        ->required(),
                                    Forms\Components\TextInput::make('company_website')
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
                                        ->displayFormat('d M, Y'),
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
                                    Forms\Components\FileUpload::make('resume')
                                        ->disk('public') // Use a private disk for security 
                                        ->directory('applications/resumes') // Directory within the private disk 
                                        ->acceptedFileTypes(['application/pdf', 'application/msword']) // Allowed file types 
                                        ->visibility('public') // Add this  
                                        ->maxSize(10240) // 10MB limit 
                                        ->downloadable()
                                        ->openable()
                                        ->storeFileNamesIn('resume_original_name') // Store original filename in this column
                                        ->saveUploadedFileUsing(function (Forms\Components\FileUpload $component, TemporaryUploadedFile $file, $get) {
                                            $userName = auth()->user()->name;
                                            $sanitizedUserName = Str::of($userName)->snake()->upper();

                                            $companyName = $get('company_name');
                                            $sanitizedCompanyName = Str::of($companyName)->snake()->upper();

                                            $originalExtension = $file->getClientOriginalExtension();
                                            $filename = "{$sanitizedCompanyName}_{$sanitizedUserName}_RESUME.{$originalExtension}";
                                            // CORRECTED: Use getDiskName() to get the disk name string
                                            return $file->storeAs($component->getDirectory(), $filename, $component->getDiskName());
                                        })
                                        ->deletable(),
                                    Forms\Components\FileUpload::make('cover_letter') //TODO this can be ether text or upload pdf?
                                        ->disk('public')
                                        ->directory('applications/cover-letters')
                                        ->acceptedFileTypes(['application/pdf', 'application/msword'])
                                        ->visibility('public') // Add this  
                                        ->maxSize(10240)
                                        ->downloadable()
                                        ->openable()
                                        ->storeFileNamesIn('cover_letter_original_name') // Store original filename in this column 
                                        ->saveUploadedFileUsing(function (Forms\Components\FileUpload $component, TemporaryUploadedFile $file, $get) {
                                            $companyName = $get('company_name');
                                            $sanitizedCompanyName = Str::of($companyName)->snake()->upper();

                                            $userName = auth()->user()->name;
                                            $sanitizedUserName = Str::of($userName)->snake()->upper();

                                            $originalExtension = $file->getClientOriginalExtension();
                                            $filename = "{$sanitizedCompanyName}_{$sanitizedUserName}_Cover_Letter.{$originalExtension}";
                                            // CORRECTED: Use getDiskName() to get the disk name string
                                            return $file->storeAs($component->getDirectory(), $filename, $component->getDiskName());
                                        })
                                        ->deletable(),
                                ])
                                    ->columns([
                                        'sm' => 1,
                                        'md' => 2,
                                    ])
                                    ->columnSpanFull(),
                            ]),
                        Tabs\Tab::make('Notes')
                            ->icon('heroicon-o-document-text')
                            ->badge(fn($record) => $record?->notes()->count())
                            ->schema([
                                Repeater::make('notes')
                                    ->hiddenLabel()
                                    ->relationship('notes')
                                    ->grid(2)
                                    ->schema([
                                        Select::make('category')
                                            ->options([
                                                'personal' => 'Personal',
                                                'professional' => 'Professional',
                                                'other' => 'Other',
                                            ]),
                                        RichEditor::make('content'),
                                    ])
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array|null {
                                        // Check if both category and content are effectively empty/null
                                        $isCategoryEmpty = empty($data['category']);
                                        $isContentEmpty = empty($data['content']) || Str::of(strip_tags($data['content']))->trim()->isEmpty();
                        
                                        if ($isCategoryEmpty && $isContentEmpty) {
                                            return null; // Return null to prevent the record from being created
                                        }
                        
                                        return $data; // Otherwise, return the data to be saved
                                    }),
                            ]),
                            Tabs\Tab::make('Contacts')  
                                ->icon('heroicon-o-user-group')  
                                ->badge(fn($record) => $record?->contacts()->count())  
                                ->schema([  
                                    Repeater::make('contacts')  
                                        ->hiddenLabel()  
                                        ->relationship('contacts')  
                                        ->grid(2)
                                        ->schema([  
                                            TextInput::make('name'),  
                                            TextInput::make('email')  
                                                ->prefixIcon('heroicon-o-envelope'),  
                                            TextInput::make('phone')  
                                                ->prefixIcon('heroicon-o-phone'),  
                                            TextInput::make('linkedin_profile')  
                                                ->prefixIcon('heroicon-o-link')  
                                                ->hint(function ($state) {  
                                                    if (filled($state)) {  
                                                        return new HtmlString('<a href="' . $state . '" target="_blank" class="text-primary-600 hover:underline">View Profile</a>');  
                                                    }  
                                                    return null;  
                                                }),  
                                        ]) 
                                        ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array|null {
                                            // Check if all relevant fields are empty
                                            $isEmpty = empty($data['name']) && empty($data['email']) && empty($data['phone']) && empty($data['linkedin_profile']);
                                            if ($isEmpty) {
                                                return null;
                                            }
                                            return $data;
                                        }), 
                                ]),

                        Tabs\Tab::make('Tasks')
                            ->icon('heroicon-o-check-circle')
                            ->badge(fn($record) => $record?->tasks()->count())
                            ->schema([
                                Repeater::make('tasks')
                                    ->hiddenLabel()
                                    ->grid(2)
                                    ->relationship('tasks')
                                    ->schema([
                                        TextInput::make('title'),
                                        TextInput::make('description'),
                                        Checkbox::make('is_completed'),
                                    ])
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array|null {
                                        // If title and description are empty, don't create the task
                                        if (empty($data['title']) && empty($data['description'])) {
                                            return null;
                                        }
                                        return $data;
                                    }),
                            ]),
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
