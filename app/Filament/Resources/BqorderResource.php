<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BqorderResource\Pages;
use App\Models\BqOrder;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Colors\Color;

use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BqOrdersExport;

use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class BqorderResource extends Resource
{
    protected static ?string $model = BqOrder::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'BeQuick';
    protected static ?string $navigationLabel = 'Orders';

    public static function canCreate(): bool
    {
        return false; // Disable "Create New"
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),

                // Order ID
                TextColumn::make('id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),

                // Customer Full Name
                TextColumn::make('billing_address')
                    ->label('Customer Name')
                    ->getStateUsing(fn ($record) =>
                        ($record->billing_address['firstName'] ?? '') . ' ' .
                        ($record->billing_address['lastName'] ?? '')
                    )
                    ->sortable()
                    ->searchable(),

                // Shipping Option (NEW)
                TextColumn::make('shipping_option.label')
                    ->label('Shipping Method')
                    ->badge()
                    ->color(Color::Green)
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return $record->shipping_option['label'] ?? 'N/A';
                    }),

                // Total Amount
                TextColumn::make('totals.total')
                    ->label('Total ($)')
                    ->badge()
                    ->color(Color::Blue)
                    ->getStateUsing(function ($record) {
                        $totals = $record->totals;
                        if (is_string($totals)) {
                            $totals = json_decode($totals, true);
                        }
                        return '$' . number_format($totals['total'] ?? 0, 2);
                    })
                    ->sortable(),

                // Coupon
                TextColumn::make('coupon')
                    ->label('Coupon')
                    ->sortable()
                    ->placeholder('-'),

                // BeQuick order ID
                TextColumn::make('bequick_order_id')
                    ->label('BeQuick Order ID')
                    ->sortable()
                    ->placeholder('-'),

                // BeQuick Amount
                TextColumn::make('bequick_order_amount')
                    ->label('BeQuick Amount ($)')
                    ->formatStateUsing(fn ($state) =>
                        $state ? number_format($state, 2) : '-'
                    )
                    ->sortable(),

                // Payment Type
                TextColumn::make('payment_type_id')
                    ->label('Payment Type')
                    ->sortable(),

                // Date
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y h:i A')
                    ->sortable(),
            ])
            ->headerActions([
    Action::make('export_excel')
        ->label('Download Excel')
        ->icon('heroicon-o-arrow-down-tray')
        ->action(function ($livewire) {
            $query = $livewire->getFilteredTableQuery();

            return Excel::download(
                new BqOrdersExport(
                    $query,
                    data_get($livewire->tableFilters, 'created_at.from'),
                    data_get($livewire->tableFilters, 'created_at.to')
                ),
                'bq-orders.xlsx'
            );
        }),
])


->filters([
    Filter::make('created_at')
        ->form([
            DatePicker::make('from')->label('From Date'),
            DatePicker::make('to')->label('To Date'),
        ])
        ->query(function ($query, array $data) {
            return $query
                ->when($data['from'], fn ($q) =>
                    $q->whereDate('created_at', '>=', $data['from'])
                )
                ->when($data['to'], fn ($q) =>
                    $q->whereDate('created_at', '<=', $data['to'])
                );
        }),
])

            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBqOrders::route('/'),
            'view' => Pages\ViewBqOrder::route('/{record}'),
        ];
    }
}
