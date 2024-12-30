<?php

namespace App\Exports;

use App\Models\OutputProduct;
use Maatwebsite\Excel\Concerns\FromCollection;

class OutputProductExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = OutputProduct::
        join('product_variants','output_products.product_variant_id','=','product_variants.id')
        ->join('products','product_variants.product_id','=','products.id')
        ->join('categories','products.product_category_id','=','categories.id')
        ->select('output_products.id', 'product_variant_title','category_title','output_quantity','output_selling_price')
        ->get();
        return   $data->prepend([
            'id' => 'ID',
            'product_variant_title' => "Tovar nomi",
            'category_title' => "Kategoriya",
            'output_quantity' => "Miqdori",
            'output_selling_price' => "Sotish narxi",
        ]);
    }
}
