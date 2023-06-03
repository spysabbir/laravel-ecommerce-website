<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Product_inventoriesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $product_inventories;

    public function __construct($product_inventories)
    {
        $this->product_inventories = $product_inventories;
    }

    public function collection()
    {
        return collect($this->product_inventories);
    }

    public function headings(): array
    {
        return [
            'Sl No',
            'Category Name',
            'Subcategory Name',
            'Childcategory Name',
            'Brand Name',
            'Product Name',
            'Color Name',
            'Size Name',
            'Quantity',
        ];
    }

    public function map($product_inventories): array
    {
        return [
            $product_inventories->id,
            $product_inventories->relationtocategory->category_name,
            $product_inventories->relationtosubcategory->subcategory_name,
            $product_inventories->relationtochildcategory->childcategory_name,
            $product_inventories->relationtobrand->brand_name,
            $product_inventories->product_name,
            $product_inventories->color_name,
            $product_inventories->size_name,
            $product_inventories->quantity,
        ];
    }
}
