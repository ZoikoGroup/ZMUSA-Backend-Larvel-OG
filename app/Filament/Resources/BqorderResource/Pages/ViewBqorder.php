<?php

namespace App\Filament\Resources\BqorderResource\Pages;

use App\Filament\Resources\BqorderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ViewBqorder extends ViewRecord
{
    protected static string $resource = BqorderResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolists\Infolist $infolist): Infolists\Infolist
    {
        return $infolist->schema([

            /* ===============================
                🧾 ORDER SUMMARY
            =============================== */
            Section::make('🧾 Order Summary')
                ->description('Order details and identifiers')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('id')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Order ID:</strong> " . ($this->record->id ?? '-'))
                            ->html(),

                        TextEntry::make('billing_address')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Customer:</strong> " .
                                (($this->record->billing_address['firstName'] ?? '') . ' ' . ($this->record->billing_address['lastName'] ?? ''))
                            )
                            ->html(),

                        TextEntry::make('subscriber_id')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Subscriber ID:</strong> " . ($this->record->subscriber_id ?? '-'))
                            ->html(),

                        TextEntry::make('payment_type_id')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Payment Type:</strong> " . ($this->record->payment_type_id ?? '-'))
                            ->html(),

                        TextEntry::make('payment_method_id')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Payment Method ID:</strong> " . ($this->record->payment_method_id ?? '-'))
                            ->html(),

                        TextEntry::make('coupon')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Coupon:</strong> " . ($this->record->coupon ?? '-'))
                            ->html(),

                        TextEntry::make('bequick_order_id')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>BeQuick Order ID:</strong> " . ($this->record->bequick_order_id ?? '-'))
                            ->html(),

                        TextEntry::make('bequick_order_amount')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>BeQuick Amount:</strong> " .
                                (isset($this->record->bequick_order_amount) ? '$'.number_format($this->record->bequick_order_amount, 2) : '-')
                            )
                            ->html(),

                        TextEntry::make('created_at')
                            ->label('')
                            ->formatStateUsing(fn() => "<strong>Order Date:</strong> " .
                                optional($this->record->created_at)->format('d M Y, h:i A')
                            )
                            ->html(),
                    ]),
                ])
                ->columns(3)
                ->extraAttributes([
                    'class' => 'bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),

            /* ===============================
                🚚 SHIPPING OPTION
            =============================== */
            Section::make('🚚 Shipping Option')
                ->description('Selected shipping method')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('shipping_option.label')
                            ->label('')
                            ->formatStateUsing(fn() =>
                                "<strong>Shipping Method:</strong> " . ($this->record->shipping_option['label'] ?? '-')
                            )
                            ->html(),

                        TextEntry::make('shipping_option.value')
                            ->label('')
                            ->formatStateUsing(fn() =>
                                "<strong>Shipping Cost:</strong> $" . number_format($this->record->shipping_option['value'] ?? 0, 2)
                            )
                            ->html(),
                    ])
                ])
                ->extraAttributes([
                    'class' => 'bg-white border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),

            /* ===============================
                🛍️ CART ITEMS (UPDATED)
            =============================== */
            Section::make('🛍️ Cart Items')
                ->description('All purchased plans or products')
                ->schema([
                    RepeatableEntry::make('cart')
                        ->schema([
                            Grid::make(4)->schema([
                                // Common fields
                                $this->styledField('Type', 'type'),
                                $this->styledField('PlanTitle', 'planTitle'),

                                

                                TextEntry::make('planSlug')
                                    ->label('')
                                    ->html()
                                    ->formatStateUsing(fn($state) =>
                                        "<strong style='color:#000;'>Slug:</strong> <span style='color:#111827;'>$state</span>"
                                    ),

                                TextEntry::make('planPrice')
                                    ->label('')
                                    ->html()
                                    ->formatStateUsing(fn($state) =>
                                        "<strong style='color:#000;'>Price:</strong> <span style='color:#111827;'>$" .
                                        number_format((float)$state, 2) .
                                        "</span>"
                                    ),

                                    

                                
                                $this->styledField('Line Type', 'lineType'),
                                $this->styledField('SIM Type', 'simType'),
                                    // Duration (Plan only)
                                $this->styledField('Duration', 'planDuration'),

                                // Device-specific attributes
                                $this->styledField('Color', 'color'),
                                $this->styledField('Storage', 'storage'),
                                $this->styledField('Condition', 'condition'),

                                

                                // SIM and Line type
                                
                                

                                // Quantity (supports both qty and formData.priceQty)
                                TextEntry::make('qty')
                                    ->label('')
                                    ->html()
                                    ->formatStateUsing(fn($state, $record) =>
                                        "<strong style='color:#000;'>Qty:</strong> <span style='color:#111827;'>" .
                                        ($state ?? $record['formData']['priceQty'] ?? 1) .
                                        "</span>"
                                    ),
                            ]),
                        ])
                        ->columns(1),
                ])
                ->extraAttributes([
                    'class' => 'bg-white border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),

            /* ===============================
                🏠 BILLING ADDRESS
            =============================== */
            Section::make('🏠 Billing Address')
                ->schema(self::addressSection('billing_address'))
                ->extraAttributes([
                    'class' => 'bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),

            /* ===============================
                🚚 SHIPPING ADDRESS
            =============================== */
            Section::make('🚚 Shipping Address')
                ->schema(self::addressSection('shipping_address'))
                ->extraAttributes([
                    'class' => 'bg-white border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),

            /* ===============================
                💳 CARD ADDRESS
            =============================== */
            Section::make('💳 Card Address')
                ->schema(self::addressSection('card_address'))
                ->extraAttributes([
                    'class' => 'bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),

            /* ===============================
                💰 TOTALS
            =============================== */
            Section::make('💰 Totals')
                ->schema([
                    TextEntry::make('totals')
                        ->label('')
                        ->formatStateUsing(fn() =>
                            $this->record->totals
                                ? collect(array_reverse($this->record->totals))
                                    ->map(function ($value, $key) {
                                        $displayKey = ucwords(str_replace('_',' ',$key));
                                        $displayValue = is_numeric($value) ? '$'.number_format($value,2) : $value;
                                        return "<strong style='color:#000;'>$displayKey:</strong> 
                                                <span style='color:#111827; font-weight:500;'>$displayValue</span>";
                                    })
                                    ->join(' &nbsp;&nbsp; | &nbsp;&nbsp; ')
                                : '<em style="color:#9ca3af;">No totals data available.</em>'
                        )
                        ->html(),
                ])
                ->extraAttributes([
                    'class' => 'bg-white border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->columns(1)
                ->collapsible(),

            /* ===============================
                📌 OTHER DETAILS
            =============================== */
            Section::make('📌 BeQuick Details')
                ->schema([
                    TextEntry::make('address_id')
                        ->label('')
                        ->formatStateUsing(fn() => "<strong>Address ID:</strong> " . ($this->record->address_id ?? '-'))
                        ->html(),

                    TextEntry::make('service_address_id')
                        ->label('')
                        ->formatStateUsing(fn() => "<strong>Service Address ID:</strong> " . ($this->record->service_address_id ?? '-'))
                        ->html(),

                    TextEntry::make('shipping_address_id')
                        ->label('')
                        ->formatStateUsing(fn() => "<strong>Shipping Address ID:</strong> " . ($this->record->shipping_address_id ?? '-'))
                        ->html(),

                    TextEntry::make('line_id')
                        ->label('')
                        ->formatStateUsing(fn() => "<strong>Line ID:</strong> " . ($this->record->line_id ?? '-'))
                        ->html(),
                ])
                ->extraAttributes([
                    'class' => 'bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm',
                ])
                ->collapsible(),
        ]);
    }

    private function styledField(string $label, string $path, bool $isDate = false): TextEntry
    {
        return TextEntry::make($path)
            ->label('')
            ->html()
            ->formatStateUsing(function ($state) use ($label, $isDate) {
                if ($isDate && $state) {
                    $state = \Carbon\Carbon::parse($state)->format('d M Y, h:i A');
                }
                return "<strong style='color:#000;'>$label:</strong> 
                        <span style='color:#111827;'>$state</span>";
            });
    }

    private static function addressSection(string $key): array
    {
        $fields = [
            'firstName' => 'First Name',
            'lastName' => 'Last Name',
            'companyName' => 'Company',
            'street' => 'Street',
            'houseNumber' => 'House No.',
            'city' => 'City',
            'state' => 'State',
            'region' => 'Region',
            'zip' => 'ZIP Code',
            'phone' => 'Phone',
            'email' => 'Email',
        ];

        $schema = [];
        foreach ($fields as $field => $label) {
            $schema[] = TextEntry::make("$key.$field")
                ->label('')
                ->formatStateUsing(fn($state) => "<strong>$label:</strong> " . ($state ?? '-'))
                ->html();
        }

        return [Grid::make(3)->schema($schema)];
    }
}
