<?php

namespace App\Jobs;

use App\Exports\ProductVariantDetailExcelExport;
use App\Models\ProductVariantDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProductVariantDetailExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $data) {}

    /**
     * Execute the job.
     */
    public function handle()
    {
        $dates = $this->data['dates'];
        $url = $this->data['url'];

         $data = ProductVariantDetail::
         join('product_variants', 'product_variant_details.product_variant_id', 'product_variants.id')
        ->join('products', 'product_variants.product_id', 'products.id')
        ->join('input_products', 'product_variants.id', 'input_products.product_variant_id')
        ->join('categories', 'products.product_category_id', 'categories.id')
        ->join('brends', 'products.product_brend_id', 'brends.id')
        ->when($dates, function ($query) use ($dates) {
            $query->whereBetween('product_variant_details.created_at', $dates);
        })
        ->select(
            'product_variant_details.product_variant_id',
            'product_variants.product_variant_title',
            'categories.category_title',
            'brends.brend_title',
            'product_variant_details.raise',
            'input_products.currency_type',
            'input_products.input_price',
            'product_variant_details.old_selling_price',
            'product_variant_details.selling_price',
            'product_variant_details.residue',
        )
        ->get();
        Excel::store(new ProductVariantDetailExcelExport($data), $url);
    }
}
