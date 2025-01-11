<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class TestExport implements FromCollection
{
    public function __construct(private $data){
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  $this->data->prepend([
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
