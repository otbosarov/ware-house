<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputProductRequest;
use App\Http\Resources\InputProductResource;
use App\Models\InputProduct;
use App\Models\ProductVariant;
use App\Models\ProductVariantDetail;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InputProductsController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 15);
        $search = request('search');
        $startDate = request('start_date');
        $endDate = request('end_date');
        $dates = [
            $startDate, //array korinishda beriladi ? M: key => start_date []  value => Y-m-d formatda
            $endDate   //array korinishda beriladi ?  M: key => end_date []  value => Y-m-d formatda
        ];

        $productInput = InputProduct::where('active', true)
            ->join('product_variants', 'input_products.product_variant_id', '=', 'product_variants.id')

            ->when($search, function ($query) use ($search) {
                $query->where('product_variant_title', "LIKE", "%$search%");
            })
            ->when($startDate, function ($query) use ($dates, ) {
                $query->whereBetween('input_products.created_at', $dates);
            })
            ->paginate($perPage);
        return InputProductResource::collection($productInput);
    }
    public function store(InputProductRequest $request)
    {

        $client = new Client();
        $now = date('Y-m-d');
        $key = "USD";
        $url = "https://cbu.uz/uz/arkhiv-kursov-valyut/json/" . $key . "/" . $now . "/";
        $response = $client->get($url);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();


        if ($statusCode == 200) {
            $data = json_decode($body, true);
        }
        $currency =  $data[0]['Rate'] ?? 12909.80;

        $variant = ProductVariant::where('product_variants.id', $request->product_variant_id)
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.product_category_id', '=', 'categories.id')
            ->where('product_variants.active', true)->first();
        if (!$variant) {
            return response()->json(['message' => 'Bunday malumot topilmadi'], 404);
        }
        $categoryRaise = $variant->raise;
        DB::beginTransaction();
        try {
            $productVariantDetail = ProductVariantDetail::where('product_variant_id', $request->product_variant_id)
                ->first();

            $input = InputProduct::create([
                'product_variant_id' => $request->product_variant_id,
                'input_price' => $request->input_price,
                'currency_type' => $request->currency_type,
                'amount' => $request->amount,
            ]);

            if ($productVariantDetail) {

                $oldSellingPrice = $productVariantDetail->old_selling_price;
                $detailRaise = $productVariantDetail->raise;
                if ($input->currency_type == 'USD') {
                    $newSellingPrice = $input->input_price * $currency * (($detailRaise / 100)+1);
                } else {
                    $newSellingPrice = $input->input_price * (($detailRaise / 100)+1);
                }

                if ($newSellingPrice < $oldSellingPrice) {
                    $potensialPrice = $oldSellingPrice;
                } else {
                    $potensialPrice = $newSellingPrice;
                }

                $productVariantDetail->update([
                    'residue' => $productVariantDetail->residue + $request->amount,
                    'selling_price' => $potensialPrice,
                    'old_selling_price' => $potensialPrice,
                ]);
            } else {
                $USD = ($input->currency_type == 'USD');
                $USDPrice = (($request->input_price) * 13300) * (($categoryRaise / 100) + 1);
                $UZSPrice = ($request->input_price) * (($categoryRaise / 100) + 1);

                ProductVariantDetail::create([
                    'product_variant_id' => $request->product_variant_id,
                    'selling_price' => $USD ? $USDPrice : $UZSPrice,
                    'residue' => $request->amount,
                    'raise' => $categoryRaise,
                    'old_selling_price' => $USD ? $USDPrice : $UZSPrice,
                ]);
            }
            DB::commit();
            return response()->json(['message' => 'Amaliyot bajarildi'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "message" => "dasturda xatolik",
                "error" => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }
    public function update(InputProductRequest $request, $id)
    {
        try {
            $input_product = InputProduct::where('id', $id)->first();
            $input_product->update([
                'product_variant_id' => $request->product_variant_id,
                'input_price' => $request->input_price,
                'currency_type' => $request->currency_type,
                'amount' => $request->amount
            ]);
            return response()->json(['message' => 'Amaliyot bajarildi'], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => "Ma'lumot yangilanishda xatolik sodir bo'ldi",
                'error' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
            ], 500);
        }
    }
}
