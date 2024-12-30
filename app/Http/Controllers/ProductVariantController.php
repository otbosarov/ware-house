<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantRequest;
use App\Http\Resources\ProductVariantResource;
use App\Models\Product_variant;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search');
        $variant = ProductVariant::where('active', true)
            ->when($search, function ($query) use ($search) {
                $query->where('product_variant_title', "LIKE", "%$search%");
            })
            ->paginate($perPage);
        return ProductVariantResource::collection($variant);
    }
    public function store(ProductVariantRequest $request)
    {
        try {
            ProductVariant::create([
                'product_variant_title' => $request->product_variant_title,
                'product_id' => $request->product_id,
                'color' => $request->color,
                'internal_memory' => $request->internal_memory,
                'weight' => $request->weight,
            ]);
            return response()->json(['message' => 'Amaliyot bajarildi'], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Dasturda xatolik",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function update(ProductVariantRequest $request, $id)
    {
        try {
            $product_variant = ProductVariant::where('id', $id)->first();
            $product_variant->update([
                'product_variant_title' => $request->product_variant_title,
                'product_id' => $request->product_id,
                'color' => $request->color,
                'internal_memory' => $request->internal_memory,
                'weight' => $request->weight
            ]);
            return response()->json(['message' => "Ma'lumot yangilandi"], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ma'lumot yangilashda xatolik yuzaga keldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ], 500);
        }
    }
}
