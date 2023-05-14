<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $all_order;

    public function __construct($all_order)
    {
        $this->all_order = $all_order;
    }

    public function collection()
    {
        return collect($this->all_order);
    }

    public function headings(): array
    {
        return [
            'Order No',
            'Name',
            'Sub Total',
            'Discount Amount',
            'Shipping Charge',
            'Grand Total',
            'Payment Method',
            'Payment Status',
            'Order Status',
            'Created At',
        ];
    }

    public function map($all_order): array
    {
        return [
            $all_order->id,
            $all_order->name,
            $all_order->sub_total,
            $all_order->discount_amount,
            $all_order->shipping_charge,
            $all_order->grand_total,
            $all_order->payment_method,
            $all_order->payment_status,
            $all_order->order_status,
            $all_order->created_at,
        ];
    }
}
