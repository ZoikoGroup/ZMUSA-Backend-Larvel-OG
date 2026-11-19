<?php

namespace App\Filament\Resources;

use App\Models\Product;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\ProductResource\Pages;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('slug'),
                        Forms\Components\TextInput::make('sku'),
                        Forms\Components\TextInput::make('model_number'),
                        Forms\Components\TextInput::make('network'),
                        Forms\Components\Toggle::make('in_stock')->default(true),

                        Forms\Components\Select::make('product_category_id')
                            ->relationship('productCategory', 'name')
                            ->searchable(),

                        Forms\Components\Select::make('product_discount_type_id')
                            ->relationship('discountType', 'name')
                            ->searchable(),

                        Forms\Components\Select::make('plan_id')
                            ->relationship('plan', 'name')
                            ->searchable(),

                        Forms\Components\Textarea::make('short_description')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Pricing')
                    ->schema([
                        Forms\Components\TextInput::make('price_uk')->numeric(),
                        Forms\Components\TextInput::make('price_usa')->numeric(),
                        Forms\Components\TextInput::make('discount')->numeric(),
                        Forms\Components\Toggle::make('featured'),
                        Forms\Components\TextInput::make('condition_label'),
                        Forms\Components\TextInput::make('warranty'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Variants')
    ->schema([
        Forms\Components\Repeater::make('variants')
            ->label('Product Variants')
            ->schema([
                Forms\Components\MultiSelect::make('device_conditions')
                    ->label('Device Conditions')
                    ->options([
                        'A1-Flawless' => 'A1 - Flawless',
                        'A2-Excellent' => 'A2 - Excellent',
                        'B1-Good' => 'B1 - Good',
                        'C1-Fair' => 'C1 - Fair',
                    ])
                    ->placeholder('Select one or more conditions'),

                Forms\Components\TextInput::make('starting_price')
                    ->label('Starting Price ($)')
                    ->numeric(),

                Forms\Components\TextInput::make('sale_price')
                    ->label('Sale Price ($)')
                    ->numeric(),

                Forms\Components\TextInput::make('quality')
                    ->label('Quality Tag')
                    ->default('Premium Quality'),

                Forms\Components\TagsInput::make('colors')
                    ->label('Available Colors')
                    ->placeholder('e.g. Black, Silver, Blue'),

                Forms\Components\TagsInput::make('storages')
                    ->label('Storage Options')
                    ->placeholder('e.g. 64GB, 128GB, 256GB'),
            ])
            ->defaultItems(1)
            ->addActionLabel('Add Variant Combination')
            ->reorderable()
            ->cloneable()
            ->collapsed(false)
            ->columnSpanFull(),
    ]),


                Forms\Components\Section::make('Technical Specs')
                    ->schema([
                        Forms\Components\Repeater::make('technical_specs')
                            ->schema([
                                Forms\Components\TextInput::make('label'),
                                Forms\Components\Textarea::make('value'),
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Perks')
                    ->schema([
                        Forms\Components\Repeater::make('perks')
                            ->schema([
                                Forms\Components\TextInput::make('title'),
                                Forms\Components\Textarea::make('description'),
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('FAQs')
                    ->schema([
                        Forms\Components\Repeater::make('faqs')
                            ->schema([
                                Forms\Components\TextInput::make('question'),
                                Forms\Components\Textarea::make('answer'),
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make("What's Included")
                    ->schema([
                        Forms\Components\Repeater::make('whats_included')
                            ->schema([
                                Forms\Components\Textarea::make('item'),
                            ])
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->multiple()
                            ->image()
                            ->reorderable(),

                        Forms\Components\FileUpload::make('image_url')
                            ->image(),
                    ]),

                Forms\Components\Section::make('Related Products (You May Also Like)')
                    ->schema([
                        Forms\Components\Select::make('related_products')
                            ->multiple()
                            ->options(Product::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\ImageColumn::make('image_url')->label('Image'),
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('sku'),
                Tables\Columns\TextColumn::make('price_uk'),
                Tables\Columns\TextColumn::make('price_usa'),
                Tables\Columns\IconColumn::make('featured')->boolean(),
                Tables\Columns\IconColumn::make('in_stock')->boolean(),
            ])
            ->filters([]);
    }

    public static function getPages(): array
{
    return [
        'index' => Pages\ListProducts::route('/'),
        'create' => Pages\CreateProduct::route('/create'),
        'edit' => Pages\EditProduct::route('/{record}/edit'),
    ];
}

}
