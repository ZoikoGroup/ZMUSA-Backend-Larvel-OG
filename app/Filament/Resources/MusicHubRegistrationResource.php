<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicHubRegistrationResource\Pages;
use App\Models\MusicHubRegistration;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MusicHubRegistrationResource extends Resource
{
    protected static ?string $model = MusicHubRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';
    protected static ?string $navigationGroup = 'Forms';
    protected static ?string $navigationLabel = 'Music Hub Forms';

    // ✅ FULL FORM (Create + Edit)
    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Applicant Info')
                ->schema([
                    Forms\Components\TextInput::make('fname')
                        ->label('First Name')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required(),

                    Forms\Components\TextInput::make('countrycode')
                        ->label('Country Code')
                        ->placeholder('+91'),

                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->required(),

                    Forms\Components\Select::make('desc')
                        ->label('User Type')
                        ->options([
                            'Student' => 'Student',
                            'Artist' => 'Artist',
                            'Producer' => 'Producer',
                            'Other' => 'Other',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Benefits Selected')
                ->schema([
                    Forms\Components\Toggle::make('perks'),
                    Forms\Components\Toggle::make('discount'),
                    Forms\Components\Toggle::make('tools'),
                    Forms\Components\Toggle::make('storage'),
                    Forms\Components\Toggle::make('access'),
                ])
                ->columns(3),

            Forms\Components\FileUpload::make('statusproof')
                ->label('Student ID / Proof')
                ->directory('music-hub-proofs')
                ->disk('public')
                ->downloadable()
                ->openable(),

            Forms\Components\Textarea::make('other')
                ->rows(3)
                ->columnSpanFull(),

            Forms\Components\Textarea::make('musicjourney')
                ->label('Music Journey')
                ->rows(4)
                ->columnSpanFull(),

            Forms\Components\Section::make('Consent')
                ->schema([
                    Forms\Components\Toggle::make('concent')
                        ->label('Consent Given')
                        ->required(),

                    Forms\Components\Toggle::make('terms')
                        ->label('Accepted Terms')
                        ->required(),
                ])
                ->columns(2),
        ]);
    }

    // ✅ TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),

                Tables\Columns\TextColumn::make('fname')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('phone'),

                Tables\Columns\TextColumn::make('desc')
                    ->label('User Type')
                    ->badge()
                    ->color('info'),

                Tables\Columns\IconColumn::make('perks')->boolean(),
                Tables\Columns\IconColumn::make('discount')->boolean(),
                Tables\Columns\IconColumn::make('tools')->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('desc')
                    ->label('User Type')
                    ->options([
                        'Student' => 'Student',
                        'Artist' => 'Artist',
                        'Producer' => 'Producer',
                        'Other' => 'Other',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    // ✅ ENABLE ALL PAGES
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMusicHubRegistrations::route('/'),
            'create' => Pages\CreateMusicHubRegistration::route('/create'),
            'edit'   => Pages\EditMusicHubRegistration::route('/{record}/edit'),
            'view'   => Pages\ViewMusicHubRegistration::route('/{record}'),
        ];
    }
}