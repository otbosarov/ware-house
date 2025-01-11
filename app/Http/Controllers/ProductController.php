<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\UniversalResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        if (!($this->check('products', 'show'))) return response()->json(['message' => "Amaliyotga huquq yo'q"], 403);
        $perPage = request('per_page', 15);
        $search = request('search');
        $product = Product::with('productBrend:id,brend_title', 'productCategory:id,category_title', 'productUser:id,full_name')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'LIKE', "%$search%");
            })
            ->paginate($perPage);
        return ProductResource::collection($product);
    }
    public function store(ProductRequest $request)
    {
        if (!($this->check('products', 'add'))) return response()->json(['message' => "Amaliyotga huquq yo'q"], 403);
        try {
            Product::create([
                'title' => $request->title,
                'product_category_id' => $request->product_category_id,
                'product_brend_id' => $request->product_brend_id,
                'user_id' => auth()->id()
            ]);
            return response()->json(['message' => 'Amaliyot muvaffaqiyatli bajarildi'], 201);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Dasturda kutilmagan xatolik",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
    public function update(ProductRequest $request, $id)
    {
        if (!($this->check('products', 'edit'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        try {
            $product = Product::where('id', $id)->first();
            $product->update([
                'title' => $request->title,
                'product_category_id' => $request->product_category_id,
                'product_brend_id' => $request->product_brend_id,
            ]);
            return response()->json(['message' => "Ma'lumot muvaffaqiyatli yangilandi"], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ma'lomot yangilanishda xatolik yuzaga keldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile()
            ], 500);
        }
    }
}
