<?php

namespace App\Http\Controllers;

use App\Jobs\InputProductExcelUploadJob;
use App\Jobs\OutputProductExcelUploadJob;
use App\Jobs\ProductVariantDetailExcelUploadJob;
use App\Models\ProductVariantDetail;

class UploadToExcelController extends Controller
{
    public function InputProductsExcel()
    {
        if (!($this->check('hisobot_excel', 'hisobot'))) {
            return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        }
        $dates = request('dates', []);

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $url = "public/" . $now . "_" . $userId . "_input_products_excel.xlsx";
        // $data = [
        //     'dates' => $dates,
        //     'url' => $url
        // ];

        dispatch(new InputProductExcelUploadJob($dates, $url));

        // dispatch(new InputProductExcelUploadJob($data));
        return response()->json([
            'message' => "Kirim tovarlar excalga yuklandi",
            'file_url' => "storage/" . $url
        ], 200);
    }
    public function OutputProductsExcel()
    {
        if (!($this->check('hisobot_excel', 'hisobot'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        $dates = request('dates', []);

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $url = "public/" . $now . "_" . $userId . "_output_products_excel.xlsx";

        $data = [
            'dates' => $dates,
            'url' => $url
        ];

        dispatch(new OutputProductExcelUploadJob($data));
        return response()->json([
            'message' => "Chiqim tovarlar excalga yuklandi",
            'file_url' => "storage/" . $url
        ], 200);
    }
    public function ProductVariantDetailsExcel()
    {
        if (!($this->check('hisobot_excel', 'hisobot'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);

        $dates = request('dates', []);

        $now = date("Y_m_d_H_i_s");
        $userId = auth()->id();
        $url = "public/" . $now . "_" . $userId .  "_product_variant_details_excel.xlsx";

        $data = [
            'dates' => $dates,
            'url' => $url
        ];

        dispatch(new ProductVariantDetailExcelUploadJob($data));
        return response()->json([
            'message' => "Tovar qoldig'i excalga yuklandi",
            'file_url' => "storage/" . $url
        ], 200);
    }
}
