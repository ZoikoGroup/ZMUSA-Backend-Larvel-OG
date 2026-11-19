<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BecomeAffiliateFormResource\Pages;
use App\Filament\Resources\BecomeAffiliateFormResource\RelationManagers;
use App\Models\BecomeAffiliateForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BecomeAffiliateFormResource extends Resource
{
    protected static ?string $model = BecomeAffiliateForm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Retailer Requests';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('company_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('business_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('job')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('countrycode')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('street')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('city')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('state')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('zip')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('years_in_business')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('monthly_sales')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('business_types')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sale_other_carriers')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('plan_to_sell')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('estimated_monthly_purchase')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('bank_transfer')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('billing_contact')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('billing_email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('preferred_shipping_method')
                    ->maxLength(255)
                    ->default(null),
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
                Tables\Columns\TextColumn::make('business_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('preferred_shipping_method')
                    ->searchable(),
                Tables\Columns\IconColumn::make('agree_eligibility')
                    ->boolean(),
                Tables\Columns\IconColumn::make('agree_terms')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListBecomeAffiliateForms::route('/'),
            'create' => Pages\CreateBecomeAffiliateForm::route('/create'),
            'edit' => Pages\EditBecomeAffiliateForm::route('/{record}/edit'),
        ];
    }
}
