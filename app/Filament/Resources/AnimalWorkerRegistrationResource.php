<?php

namespace App\Filament\Resources;

use App\Models\AnimalWorkerRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\AnimalWorkerRegistrationResource\Pages;

class AnimalWorkerRegistrationResource extends Resource
{
    protected static ?string $model = AnimalWorkerRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Animal Management';
    protected static ?string $navigationLabel = 'Animal Workers Registrations';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Personal Information')
                ->schema([
                    Forms\Components\TextInput::make('fname')->label('Full Name')->required(),
                    Forms\Components\TextInput::make('email')->label('Email')->required(),
                    Forms\Components\DatePicker::make('dob')->label('Date of Birth')->required(),
                    Forms\Components\TextInput::make('orgname')->label('Organisation Name')->required(),
                    Forms\Components\TextInput::make('jobtitle')->label('Job Title')->required(),
                    Forms\Components\TextInput::make('street')->label('Street')->required(),
                    Forms\Components\TextInput::make('city')->label('City')->required(),
                    Forms\Components\TextInput::make('state')->label('State')->required(),
                    Forms\Components\TextInput::make('zipcode')->label('Zip Code')->required(),
                ])->columns(2),

            Forms\Components\Section::make('Family & Friends (Up to 5)')
                ->schema([
                    Forms\Components\Repeater::make('family_members')
                        ->label('Add Your Family and Friends')
                        ->schema([
                            Forms\Components\TextInput::make('famname')->label('Full Name')->required(),
                            Forms\Components\TextInput::make('relation')->label('Relation')->required(),
                            Forms\Components\TextInput::make('famphone')->label('Phone Number'),
                            Forms\Components\TextInput::make('famemail')->label('Email')->email(),
                        ])
                        ->columns(2)
                        ->maxItems(5)
                        ->addActionLabel('Add Person')
                        ->reorderable(false),
                ])
                ->collapsible(),

            Forms\Components\Section::make('Documents & Consent')
                ->schema([
                    Forms\Components\Toggle::make('concent')->label('Consent')->required(),
                    Forms\Components\Toggle::make('terms')->label('Accept Terms')->required(),
                    Forms\Components\Toggle::make('updates')->label('Receive Updates')->required(),
                    Forms\Components\FileUpload::make('statusproof')
                        ->label('Upload Proof or Photo')
                        ->disk('public')
                        ->directory('animal_worker_photos')
                        ->downloadable()
                        ->openable(),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID')->sortable(),
                Tables\Columns\TextColumn::make('fname')->label('Full Name')->sortable(),
                Tables\Columns\TextColumn::make('orgname')->label('Organisation'),
                Tables\Columns\TextColumn::make('jobtitle')->label('Job Title'),
                Tables\Columns\ImageColumn::make('statusproof')
                    ->disk('public')
                    ->label('Status Proof')
                    ->height(50)
                    ->circular(),
                Tables\Columns\TextColumn::make('created_at')->label('Registered At')->dateTime(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnimalWorkerRegistrations::route('/'),
            'create' => Pages\CreateAnimalWorkerRegistration::route('/create'),
            'edit' => Pages\EditAnimalWorkerRegistration::route('/{record}/edit'),
        ];
    }
}
