<?php

namespace App\Exports;

use App\Models\InputProduct;
use Maatwebsite\Excel\Concerns\FromCollection;

class InputProductExcelExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $data = [
            'start_date' => request()->start_date,
            'end_date' => request()->end_date,
        ];
        $data =   InputProduct::join('product_variants', 'input_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.product_category_id', '=', 'categories.id')
            ->join('brends', 'products.product_brend_id', '=', 'brends.id')
            ->join('product_variant_details', 'product_variants.id', '=', 'product_variant_details.product_variant_id')
            ->select(
                'input_products.id',
                'product_variant_title',
                'category_title',
                'brend_title',
                'currency_type',
                'input_price',
                'selling_price',
                'amount'
            )
            ->get();
        return   $data->prepend([
            'id' => 'ID',
            'product_variant_title' => "Tovar nomi",
            'category_title' => "Kategoriya",
            'brend_title' => "Brend",
            'currency_type' => "Valyuta turi",
            'input_price' => "Kirim narxi",
            'selling_price' => "Sotish narxi",
            'amount' => "Miqdori",
        ]);
    }
}
