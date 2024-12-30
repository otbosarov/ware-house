<?php

namespace App\Http\Controllers;

use App\Exports\InputProductExcelExport;
use App\Exports\OutputProductExcelExport;
use App\Exports\ProductVariantDetailExcelExport;
use App\Models\InputProduct;
use App\Models\OutputProduct;
use App\Models\ProductVariantDetail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

//new UploadToExcelController($data);
class UploadToExcelController extends Controller
{
    // public function __construct(private $data) {}
    public function InputProductsExcel()
    {
        $startData = request('start_date');
        $endData = request('end_date');
        $data =   InputProduct::join('product_variants', 'input_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.product_category_id', '=', 'categories.id')
            ->join('brends', 'products.product_brend_id', '=', 'brends.id')
            ->join('product_variant_details', 'product_variants.id', '=', 'product_variant_details.product_variant_id')
            ->where('input_products.created_at', '>=', $startData)
            ->where('input_products.created_at', '<=', $endData)
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
        $now = date("Y_m_d_H_i_s");
        $url = "public/" . $now . "input_products_excel.xlsx";
        Excel::store(new InputProductExcelExport($data), $url);
        return response()->json([
            'message' => "Kirim tovarlar excalga yuklandi",
            'file_url' => "storage/input_products_excel.xlsx"
        ], 200);
    }
    public function OutputProductsExcel()
    {
        $startData = request('start_date');
        $endData = request('end_date');
        $data = OutputProduct::join('product_variants', 'output_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.product_category_id', '=', 'categories.id')
            ->where('output_products.created_at', '>=', $startData)
            ->where('output_products.created_at', '<=', $endData)
            ->select('output_products.id', 'product_variant_title', 'category_title', 'output_quantity', 'output_selling_price')
            ->get();
        $now = date("Y_m_d_H_i_s");
        $url = "public/" . $now . "output_products_excel.xlsx";

        Excel::store(new OutputProductExcelExport($data), $url);
        return response()->json([
            'message' => "Chiqim tovarlar excalga yuklandi",
            'file_url' => "storage/output_products_excel.xlsx"
        ], 200);
    }
    public function ProductVariantDetailsExcel()
    {
        $startData = request('start_date');
        $endData = request('end_date');
        $data =  ProductVariantDetail::join('product_variants', 'product_variant_details.product_variant_id', 'product_variants.id')
            ->join('products', 'product_variants.product_id', 'products.id')
            ->join('categories', 'products.product_category_id', 'categories.id')
            ->join('brends', 'products.product_brend_id', 'brends.id')
            ->where('product_variant_details.created_at', '>=', $startData)
            ->where('product_variant_details.created_at', '<=', $endData)
            ->select(
                'product_variant_id',
                'product_variants.product_variant_title',
                'product_variant_details.raise',
                'products.product_category_id',
                'products.product_brend_id',
                'product_variant_details.old_selling_price',
                'product_variant_details.selling_price',
                'product_variant_details.residue',
            )
            ->get();
            $now = date("Y_m_d_H_i_s");
            $url = "public/" . $now . "product_variant_details_excel.xlsx";
        Excel::store(new ProductVariantDetailExcelExport($data), $url);
        return response()->json([
            'message' => "Tovar qoldig'i excalga yuklandi",
            'file_url' => 'storage/product_variant_details_excel.xlsx'
        ], 200);
    }
}
