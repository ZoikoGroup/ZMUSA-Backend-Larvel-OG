<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerWithUsFormResource\Pages;
use App\Filament\Resources\PartnerWithUsFormResource\RelationManagers;
use App\Models\PartnerWithUsForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerWithUsFormResource extends Resource
{
    protected static ?string $model = PartnerWithUsForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('website')
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
                Forms\Components\TextInput::make('countrycode')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('years_in_business')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('monthly_sales')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('business_types')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('solutions')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sale_other_carriers')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('target_market')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('preferred_partnership_model')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_transfer')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('billing_contact')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('billing_email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('preferred_shipping_method')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('agree_eligibility')
                    ->required(),
                Forms\Components\Toggle::make('agree_terms')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('company_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->searchable(),
                Tables\Columns\TextColumn::make('street')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->searchable(),
                Tables\Columns\TextColumn::make('state')
                    ->searchable(),
                Tables\Columns\TextColumn::make('zip')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('countrycode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),               
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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

    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()
        ->orderByDesc('id'); // or ->latest() to sort by created_at
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartnerWithUsForms::route('/'),
            'create' => Pages\CreatePartnerWithUsForm::route('/create'),
            'edit' => Pages\EditPartnerWithUsForm::route('/{record}/edit'),
        ];
    }
}
