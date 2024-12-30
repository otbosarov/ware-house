<?php

namespace App\Http\Controllers;

use App\Exports\InputProductExcelExport;
use App\Exports\OutputProductExcelExport;
use App\Exports\ProductVariantDetailExcelExport;
use App\Models\ProductVariantDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


new UploadToExcelController($data);
class UploadToExcelController extends Controller
{
    public function __construct(private $data) {}
    public function InputProductsExcel()
    {
        Excel::store(new InputProductExcelExport, 'public/input_products_excel.xlsx');
        return response()->json([
            'message' => "Kirim tovarlar excalga yuklandi",
            'file_url' => "storage/input_products_excel.xlsx"
        ], 200);
    }
    public function OutputProductsExcel()
    {
        Excel::store(new OutputProductExcelExport, 'public/output_products_excel.xlsx');
        return response()->json([
            'message' => "Chiqim tovarlar excalga yuklandi",
            'file_url' => "storage/output_products_excel.xlsx'"
        ], 200);
    }
    public function ProductVariantDetailsExcel()
    {

        Excel::store(new ProductVariantDetailExcelExport, 'public/product_variant_details_excel.xlsx');
        return response()->json([
            'message' => "Tovar qoldig'i excalga yuklandi",
            'file_url' => 'storage/product_variant_details_excel.xlsx'
        ], 200);
    }
}
