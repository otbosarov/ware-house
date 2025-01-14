<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductVariantDetailRequest;
use App\Http\Resources\ProductVariantDetailResource;
use App\Http\Resources\UniversalResource;
use App\Models\ProductVariantDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductVariantDetailsController extends Controller
{
    public function __construct(public ProductVariantDetail $productVariantDetail) {}
    public function index()
    {
        if (!($this->check('products', 'show'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        $perPage = request('per_page', 15);
        $search = request('search');
        $dates = request('dates', []);
        $details =   $this->productVariantDetail
            ->join('product_variants', 'product_variant_details.product_variant_id',  'product_variants.id')
            ->join('products', 'product_variants.product_id', 'products.id')
            ->join('input_products', 'input_products.product_variant_id', 'product_variants.id')
            ->join('categories', 'products.product_category_id',  'categories.id')
            ->join('brends', 'products.product_brend_id',  'brends.id')
            ->when($search, function ($query) use ($search) {
                $query->where('', "LIKE", "%$search%");
            })
            ->when($dates, function ($query) use ($dates) {
                $query->whereBetween('product_variant_details.created_at', $dates);
            })
            ->paginate($perPage);
        return ProductVariantDetailResource::collection($details);
    }
    public function update(ProductVariantDetailRequest $request, $id)
    {
        if (!($this->check('products', 'edit'))) return response()->json(['message' => 'Amaliyotga huquq yo\'q'], 403);
        $details = ProductVariantDetail::where('product_variant_details.id', $id)
            ->join('input_products', 'input_products.product_variant_id', 'product_variant_details.product_variant_id')
            ->first();
            if(!$details){
                return response()->json(['message' => "Bunday ma'lumot mavjud emas"],200);
            }
            $client = new Client();
            $key = 'USD';
            $now = date('Y-m-d');
            $url = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/" . $key . "/" . $now . "/";
            $response = $client->get($url);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();

            if ($statusCode == 200) {
                $data = json_decode($body, true);
            }
            $currency =  $data[0]['Rate'] ?? 12909.80;

        if ($details->currency_type == 'USD') {
            $percent = (($details->input_price * $currency) / 100) * $request->raise;
            $newPrice = $percent + $details->input_price * 13300;
        }else{
            $percent =(($details->input_price)/100) * $request->raise;
            $newPrice = $percent + $details->input_price;
        }
        $details->update([
            'raise' => $request->raise ?? $details->raise,
            'selling_price' => $newPrice
        ]);
        return response()->json(['message' => "Amaliyot bajirildi "], 200);
    }
}
