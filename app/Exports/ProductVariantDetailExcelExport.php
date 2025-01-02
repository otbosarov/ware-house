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
