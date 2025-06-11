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
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\ApplicationResource\Pages\EditApplication;
use App\Filament\Resources\ApplicationResource\Pages\ViewApplication;
use App\Filament\Resources\ApplicationResource\Pages\ListApplications;
use App\Filament\Resources\ApplicationResource\Pages\CreateApplication;

class ApplicationResource extends Resource
{
    protected static ?string $model = Application::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Constants for better maintainability
    private const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'interview' => 'Interview',
        'offer' => 'Offer',
        'rejected' => 'Rejected',
    ];

    private const NOTE_CATEGORIES = [
        'personal' => 'Personal',
        'professional' => 'Professional',
        'other' => 'Other',
    ];

    private const ACCEPTED_FILE_TYPES = ['application/pdf', 'application/msword'];
    private const MAX_FILE_SIZE = 10240; // 10MB

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('Tabs')
                ->tabs([
                    self::buildApplicationTab(),
                    self::buildNotesTab(),
                    self::buildContactsTab(),
                    self::buildTasksTab(),
                ])
                ->columnSpanFull(),
        ]);
    }

    private static function buildApplicationTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Application')
            ->icon('heroicon-o-rectangle-stack')
            ->schema([
                self::buildBasicInfoGroup(),
                self::buildStatusDateGroup(),
                self::buildJobDescriptionField(),
                self::buildLocationSalaryGroup(),
                self::buildApplicationLinkField(),
                self::buildDatesGroup(),
                self::buildDocumentsGroup(),
            ]);
    }

    private static function buildBasicInfoGroup(): Group
    {
        return Group::make([
            Forms\Components\TextInput::make('user_id')
                ->default(auth()->user()->id)
                ->hidden()
                ->dehydratedWhenHidden(),
            Forms\Components\TextInput::make('job_title')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('company_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('company_website')
                ->required()
                ->url()
                ->maxLength(255),
        ])
        ->columns(['sm' => 1, 'md' => 2])
        ->columnSpanFull();
    }

    private static function buildStatusDateGroup(): Group
    {
        return Group::make([
            Forms\Components\DatePicker::make('applied_date')
                ->prefixIcon('heroicon-o-calendar')
                ->native(false)
                ->displayFormat('d M, Y')
                ->default(now())
                ->required(),
            Forms\Components\Select::make('status')
                ->options(self::STATUS_OPTIONS)
                ->default('pending')
                ->required(),
        ])
        ->columns(['sm' => 1, 'md' => 2])
        ->columnSpanFull();
    }

    private static function buildJobDescriptionField(): Forms\Components\RichEditor
    {
        return Forms\Components\RichEditor::make('job_description')
            ->columnSpanFull()
            ->required();
    }

    private static function buildLocationSalaryGroup(): Group
    {
        return Group::make([
            Forms\Components\TextInput::make('salary_range')
                ->prefixIcon('heroicon-o-currency-dollar')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('location')
                ->prefixIcon('heroicon-o-map-pin')
                ->required()
                ->maxLength(255),
        ])
        ->columns(['sm' => 1, 'md' => 2])
        ->columnSpanFull();
    }

    private static function buildApplicationLinkField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('application_link')
            ->prefixIcon('heroicon-o-link')
            ->columnSpanFull()
            ->required()
            ->url()
            ->maxLength(500);
    }

    private static function buildDatesGroup(): Group
    {
        return Group::make([
            Forms\Components\DatePicker::make('posted_date')
                ->prefixIcon('heroicon-o-calendar')
                ->native(false)
                ->displayFormat('d M, Y'),
            Forms\Components\DatePicker::make('application_deadline')
                ->prefixIcon('heroicon-o-calendar')
                ->native(false)
                ->displayFormat('d M, Y')
                ->after('posted_date'),
        ])
        ->columns(['sm' => 1, 'md' => 2])
        ->columnSpanFull();
    }

    private static function buildDocumentsGroup(): Group
    {
        return Group::make([
            self::buildFileUpload('resume', 'Resume'),
            self::buildFileUpload('cover_letter', 'Cover Letter'),
        ])
        ->relationship('document')
        ->columns(['sm' => 1, 'md' => 2])
        ->columnSpanFull();
    }

    private static function buildFileUpload(string $type, string $label): FileUpload
    {
        $originalNameField = $type === 'resume' ? 'resume_original_name' : 'cover_letter_original_name';
        
        return FileUpload::make($type)
            ->label($label)
            ->disk('public')
            ->directory(fn ($get) => self::getUploadDirectory($get('company_name'), $type))
            ->acceptedFileTypes(self::ACCEPTED_FILE_TYPES)
            ->visibility('public')
            ->maxSize(self::MAX_FILE_SIZE)
            ->downloadable()
            ->openable()
            ->storeFileNamesIn($originalNameField)
            ->saveUploadedFileUsing(fn ($component, $file, $get) => 
                self::saveUploadedFile($component, $file, $get, $type)
            )
            ->deletable()
            ->deleteUploadedFileUsing(fn (string $file) => Storage::disk('public')->delete($file));
    }

    private static function getUploadDirectory(string $companyName, string $type): string
    {
        $sanitizedCompanyName = Str::of($companyName)->snake()->lower();
        return "applications/{$sanitizedCompanyName}/{$type}";
    }

    private static function saveUploadedFile(
        FileUpload $component, 
        TemporaryUploadedFile $file, 
        $get, 
        string $type
    ): string {
        $userName = auth()->user()->name;
        $sanitizedUserName = Str::of($userName)->snake()->upper();
        
        $companyName = $get('company_name');
        $sanitizedCompanyName = Str::of($companyName)->snake()->upper();
        
        $originalExtension = $file->getClientOriginalExtension();
        $typeLabel = $type === 'cover_letter' ? 'Cover_Letter' : strtoupper($type);
        $filename = "{$sanitizedCompanyName}_{$sanitizedUserName}_{$typeLabel}.{$originalExtension}";
        
        return $file->storeAs($component->getDirectory(), $filename, $component->getDiskName());
    }

    private static function buildNotesTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Notes')
            ->icon('heroicon-o-document-text')
            ->badge(fn($record) => $record?->notes()->count())
            ->schema([
                Repeater::make('notes')
                    ->hiddenLabel()
                    ->relationship('notes')
                    ->grid(2)
                    ->schema([
                        Select::make('category')
                            ->options(self::NOTE_CATEGORIES)
                            ->required(),
                        RichEditor::make('content')
                            ->required(),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(
                        fn (array $data) => self::filterEmptyNoteData($data)
                    )
                    ->itemLabel(fn (array $state): ?string => 
                        $state['category'] ?? 'New Note'
                    ),
            ]);
    }

    private static function buildContactsTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Contacts')
            ->icon('heroicon-o-user-group')
            ->badge(fn($record) => $record?->contacts()->count())
            ->schema([
                Repeater::make('contacts')
                    ->hiddenLabel()
                    ->relationship('contacts')
                    ->grid(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->prefixIcon('heroicon-o-envelope')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->prefixIcon('heroicon-o-phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('linkedin_profile')
                            ->prefixIcon('heroicon-o-link')
                            ->url()
                            ->maxLength(500)
                            ->hint(function ($state) {
                                if (filled($state)) {
                                    return new HtmlString(
                                        '<a href="' . $state . '" target="_blank" class="text-primary-600 hover:underline">View Profile</a>'
                                    );
                                }
                                return null;
                            }),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(
                        fn (array $data) => self::filterEmptyContactData($data)
                    )
                    ->itemLabel(fn (array $state): ?string => 
                        $state['name'] ?? 'New Contact'
                    ),
            ]);
    }

    private static function buildTasksTab(): Tabs\Tab
    {
        return Tabs\Tab::make('Tasks')
            ->icon('heroicon-o-check-circle')
            ->badge(fn($record) => $record?->tasks()->count())
            ->schema([
                Repeater::make('tasks')
                    ->hiddenLabel()
                    ->grid(2)
                    ->relationship('tasks')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('description')
                            ->maxLength(500),
                        Checkbox::make('is_completed')
                            ->default(false),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(
                        fn (array $data) => self::filterEmptyTaskData($data)
                    )
                    ->itemLabel(fn (array $state): ?string => 
                        $state['title'] ?? 'New Task'
                    ),
            ]);
    }

    // Data filtering methods
    private static function filterEmptyNoteData(array $data): ?array
    {
        $isCategoryEmpty = empty($data['category']);
        $isContentEmpty = empty($data['content']) || 
            Str::of(strip_tags($data['content']))->trim()->isEmpty();

        return ($isCategoryEmpty && $isContentEmpty) ? null : $data;
    }

    private static function filterEmptyContactData(array $data): ?array
    {
        $isEmpty = empty($data['name']) && 
                  empty($data['email']) && 
                  empty($data['phone']) && 
                  empty($data['linkedin_profile']);

        return $isEmpty ? null : $data;
    }

    private static function filterEmptyTaskData(array $data): ?array
    {
        return (empty($data['title']) && empty($data['description'])) ? null : $data;
    }

    public static function getRelations(): array
    {
        return [];
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