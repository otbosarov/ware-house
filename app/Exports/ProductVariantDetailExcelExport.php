<?php

namespace App\Exports;

use App\Models\ProductVariantDetail;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductVariantDetailExcelExport implements FromCollection
{
    public function __construct(private $data){
     $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        // $data =  ProductVariantDetail::select(
        //     'product_variant_id',
        //     'product_variants.product_variant_title',
        //     'product_variant_details.raise',
        //     'products.product_category_id',
        //     'products.product_brend_id',
        //     'product_variant_details.old_selling_price',
        //     'product_variant_details.selling_price',
        //     'product_variant_details.residue',
        // )
        //     ->join('product_variants', 'product_variant_details.product_variant_id', 'product_variants.id')
        //     ->join('products', 'product_variants.product_id', 'products.id')
        //     ->join('categories', 'products.product_category_id', 'categories.id')
        //     ->join('brends', 'products.product_brend_id', 'brends.id')
        //     ->get();
        return   $this->data->prepend([
            'product_variant_id' => 'ID',
            'product_variants.product_variant_title' => "Tovar nomi",
            'product_variant_details.raise' => 'Ustama',
            'products.product_category_id' => "Kategoriya",
            'products.product_brend_id' => "Brend",
            //'currency_type' => "Valyuta turi",
            //'input_price' => "Kirim narxi",
            'product_variant_details.selling_price' => "Yangi sotish narxi",
            'product_variant_details.old_selling_price' => "Eski sotish narxi",
            'product_variant_details.residue' => "Qoldiq",
        ]);
    }
}
