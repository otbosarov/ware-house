<?php

namespace App\Jobs;

use App\Exports\InputProductExcelExport;
use App\Models\InputProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class InputProductExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public function __construct(private $dates, private $url) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dates = $this->dates;
        $url = $this->url;
        $data =  InputProduct::join('product_variants', 'input_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.product_category_id', '=', 'categories.id')
            ->join('brends', 'products.product_brend_id', '=', 'brends.id')
            ->join('product_variant_details', 'product_variants.id', '=', 'product_variant_details.product_variant_id')
            ->when($dates, function ($query) use ($dates) {
                $query->whereBetween('input_products.created_at', $dates);
            })
            ->select(
                'input_products.product_variant_id',
                'product_variants.product_variant_title',
                'categories.category_title',
                'brends.brend_title',
                'input_products.currency_type',
                'input_products.input_price',
                'product_variant_details.selling_price',
                'input_products.amount'
            )
            ->get();
        Excel::store(new InputProductExcelExport($data), $url);
    }
}
