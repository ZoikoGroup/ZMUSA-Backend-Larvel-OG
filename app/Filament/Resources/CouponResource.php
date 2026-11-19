<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Plan;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Marketing';
    protected static ?string $navigationLabel = 'Coupons';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Coupon Details')
                ->schema([
                    Forms\Components\Toggle::make('is_use_once_per_customer')
                        ->label('Use Once Per Customer')
                        ->default(true)
                        ->inline(false),
                        
                    Forms\Components\TextInput::make('name')
                        ->label('Coupon Name')
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(fn($state, callable $set) =>
                            $set('slug', Str::slug($state))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->disabled()
                        ->dehydrated()
                        ->required(),

                    Forms\Components\TextInput::make('limit')
                        ->numeric()
                        ->label('Usage Limit')
                        ->nullable(),

                    Forms\Components\Select::make('user_id')
                        ->label('User (Optional)')
                        ->options(fn () => User::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->filter(fn ($name) => !is_null($name) && $name !== '')
                            ->toArray()
                        )
                        ->searchable()
                        ->preload()
                        ->nullable(),

                    Forms\Components\TextInput::make('discount')
                        ->numeric()
                        ->label('Discount Value')
                        ->required(),

                    Forms\Components\Select::make('type')
                        ->options([
                            'flat' => 'Flat Discount',
                            'percentage' => 'Percentage',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Forms\Components\Section::make('Related Items')
                ->schema([
                    Forms\Components\Select::make('related_product')
                        ->label('Select Related Products')
                        ->multiple()
                        ->options(fn () => Product::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->map(fn($name) => $name ?? 'Unnamed Product')
                            ->toArray()
                        )
                        ->searchable()
                        ->preload(),

                    Forms\Components\Select::make('related_plan')
                        ->label('Select Related Plans')
                        ->multiple()
                        ->options(fn () => Plan::query()
                            ->orderBy('title') // ✅ correct field for plans
                            ->pluck('title', 'id')
                            ->map(fn($title) => $title ?? 'Unnamed Plan')
                            ->toArray()
                        )
                        ->searchable()
                        ->preload(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('slug')->limit(25),
            Tables\Columns\TextColumn::make('type')->badge(),
            Tables\Columns\TextColumn::make('discount')->label('Discount'),
            Tables\Columns\TextColumn::make('limit')->label('Usage Limit'),
            Tables\Columns\TextColumn::make('user.name')->label('User'),
            Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y H:i'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
