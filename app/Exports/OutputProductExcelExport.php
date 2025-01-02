<?php

namespace App\Exports;

use App\Models\OutputProduct;
use Maatwebsite\Excel\Concerns\FromCollection;

class OutputProductExcelExport implements FromCollection
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
            'id' => 'ID',
            'product_variant_title' => "Tovar nomi",
            'category_title' => "Kategoriya",
            'output_quantity' => "Miqdori",
            'output_selling_price' => "Sotish narxi",
        ]);
    }
}
