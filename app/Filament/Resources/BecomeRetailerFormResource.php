<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BecomeRetailerFormResource\Pages;
use App\Filament\Resources\BecomeRetailerFormResource\RelationManagers;
use App\Models\BecomeRetailerForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BecomeRetailerFormResource extends Resource
{
    protected static ?string $model = BecomeRetailerForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Affeliate Requests';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('companyName')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('job')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('countrycode')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('street')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('state')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('zip')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('businessTypes')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('marketingChannels')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('planToPromotes')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('monthlyTraffic')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('promotoBrands')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('monthlyActivations')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('agreeEligibility')
                    ->required(),
                Forms\Components\Toggle::make('agreeTerms')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('companyName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('countrycode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monthlyTraffic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('promotoBrands')
                    ->searchable(),
                Tables\Columns\TextColumn::make('monthlyActivations')
                    ->searchable(),
                Tables\Columns\IconColumn::make('agreeEligibility')
                    ->boolean(),
                Tables\Columns\IconColumn::make('agreeTerms')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListBecomeRetailerForms::route('/'),
            'create' => Pages\CreateBecomeRetailerForm::route('/create'),
            'edit' => Pages\EditBecomeRetailerForm::route('/{record}/edit'),
        ];
    }
}
