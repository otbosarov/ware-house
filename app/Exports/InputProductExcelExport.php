<?php

namespace App\Exports;

use App\Models\InputProduct;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InputProductExcelExport implements FromCollection
{
    public function __construct(private $data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        Log::info($this->data);
        return  $this->data->prepend([
                'input_products.product_variant_id' => 'ID',
                'product_variants.product_variant_title' => "Tovar nomi",
                'categories.category_title' => "Kategoriya",
                'brends.brend_title' => "Brend",
                'input_products.currency_type'=> "Valyuta turi",
                'input_products.input_price'=> "Kirim narxi",
                'product_variant_details.selling_price' => "Sotish narxi",
                'input_products.amount'=> "Miqdori",
        ]);
    }
}
