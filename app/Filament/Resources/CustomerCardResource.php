<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerCardResource\Pages;
use App\Models\CustomerCard;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;

class CustomerCardResource extends Resource
{
    protected static ?string $model = CustomerCard::class;
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Customer Cards';
    protected static ?string $pluralModelLabel = 'Customer Cards';
    protected static ?string $modelLabel = 'Customer Card';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('card_holder_name')
                    ->label('Card Holder Name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('exp_month')
                    ->label('Expiry Month')
                    ->required(),
                Forms\Components\TextInput::make('exp_year')
                    ->label('Expiry Year')
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->label('User Name')->sortable()->searchable(),
                TextColumn::make('last4')
                    ->label('Card Last 4 Digits')
                    ->getStateUsing(function ($record) {
                        return substr($record->card_number, -4);
                    }),
                TextColumn::make('card_holder_name')->sortable()->searchable(),
                TextColumn::make('exp_month')->label('Exp Month')->sortable(),
                TextColumn::make('exp_year')->label('Exp Year')->sortable(),
                TextColumn::make('created_at')->label('Saved At')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomerCards::route('/'),
            // Create/Edit pages optional since admin shouldn't see full card numbers
        ];
    }
}
