<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantDetailRequest;
use App\Http\Resources\ProductVariantDetailResource;
use App\Http\Resources\UniversalResource;
use App\Models\ProductVariantDetail;
use Illuminate\Http\Request;

class ProductVariantDetailsController extends Controller
{
    public function __construct(private ProductVariantDetail $productVariantDetail) {}
    public function index()
    {
        if (!($this->check('get', 'update'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        $perPage = request('per_page', 15);
        $search = request('search');
        $dates = request('dates',[]);
        $details =   $this->productVariantDetail
            ->join('product_variants', 'product_variant_details.product_variant_id',  'product_variants.id')
            ->join('products', 'product_variants.product_id', 'products.id')
            ->join('categories', 'products.product_category_id',  'categories.id')
            ->join('brends', 'products.product_brend_id',  'brends.id')
            ->when($search, function ($query) use ($search) {
                $query->where('', "LIKE", "%$search%");
            })
            ->when($dates,function($query)use($dates){
                $query->whereBetween('product_variant_details.created_at',$dates);
            })
            ->paginate($perPage);
        return ProductVariantDetailResource::collection($details);
    }
    public function update(ProductVariantDetailRequest $request, $id)
    {
        if (!($this->check('product', 'update'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        $details = $this->productVariantDetail->where('id', $id)->first();
        $details->update([
            'product_variant_id' => $request->product_variant_id ?? $details->product_variant_id,
            'selling_price' => $request->selling_price ?? $details->selling_price,
            'raise' => $request->raise ?? $details->raise,
        ]);
        return response()->json(['message' => "Amaliyot bajirildi "], 200);
    }
}
