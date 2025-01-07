<?php

namespace App\Http\Controllers;

use App\Http\Requests\OutputProductRequest;
use App\Http\Resources\OutputProductResource;
use App\Models\OutputProduct;
use App\Models\ProductVariant;
use App\Models\ProductVariantDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OutputProductController extends Controller
{
    public function index()
    {
        $parPage = request('par_page', 15);
        $search = request('search');
        $dates = request('dates',[]);  // array korinishda beriladi ?  M: key => dates []  value => Y-m-d

        $data = OutputProduct::join('product_variants', 'output_products.product_variant_id', '=', 'product_variants.id')

            ->when($dates, function ($query) use ($dates) {
                $query->whereBetween('output_products.created_at', $dates);
             })
            ->when($search, function ($query) use ($search) {
                $query->where('product_variant_title', "LIKE", "$$search$");
            })
            ->paginate($parPage);
        return OutputProductResource::collection($data);
    }
    public function store(OutputProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $productVariantId = $request->product_variant_id;
            $productQuantity = $request->output_quantity;

            $product_variant_detail = ProductVariantDetail::where('product_variant_id', $productVariantId)->first();

            if (!$product_variant_detail) {
                return response()->json(['message' => "Bunday ma'lumot topilmadi!"], 404);
            }
            $resuide_detail = $product_variant_detail->residue;

            if ($productQuantity > $resuide_detail) {
                return response()->json(['message' => 'Qoldiq yetarli emas'], 409);
            }
            $totalResuide = $resuide_detail - $productQuantity;

            OutputProduct::create([
                'product_variant_id' => $productVariantId,
                'output_quantity' => $productQuantity,
                'output_selling_price' => $product_variant_detail->selling_price
            ]);
            $product_variant_detail->update(['residue' => $totalResuide]);
            DB::commit();
            return response()->json(['message' => 'Maxsulot chiqim qilindi'], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'message' => "Ma'lumot chiqim qilishda xatolik yuzaga keldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ], 500);
        }
    }
}
