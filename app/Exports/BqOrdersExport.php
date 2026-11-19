<?php

namespace App\Exports;

use App\Models\BqOrder;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BqOrdersExport implements FromQuery, WithHeadings, WithMapping
{
    protected ?string $from;
    protected ?string $to;
    protected ?Builder $query;

    public function __construct(?Builder $query = null, ?string $from = null, ?string $to = null)
    {
        $this->query = $query;
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        $query = $this->query ?? BqOrder::query();

        if ($this->from) {
            $query->whereDate('created_at', '>=', $this->from);
        }

        if ($this->to) {
            $query->whereDate('created_at', '<=', $this->to);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer Name',
            'Shipping Method',
            'Total Amount',
            'Coupon',
            'BeQuick Order ID',
            'BeQuick Amount',
            'Payment Type',
            'Date',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            ($order->billing_address['firstName'] ?? '') . ' ' .
            ($order->billing_address['lastName'] ?? ''),
            $order->shipping_option['label'] ?? 'N/A',
            $order->totals['total'] ?? 0,
            $order->coupon ?? '-',
            $order->bequick_order_id ?? '-',
            $order->bequick_order_amount ?? '-',
            $order->payment_type_id,
            $order->created_at->format('Y-m-d H:i'),
        ];
    }
}
