<?php

namespace App\Jobs;

use App\Exports\OutputProductExcelExport;
use App\Models\OutputProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class OutputProductExcelUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $data) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dates = $this->data['dates'];
        $url = $this->data['url'];
        $data = OutputProduct::join('product_variants', 'output_products.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.product_category_id', '=', 'categories.id')
            ->when($dates, function ($query) use ($dates) {
                $query->whereBetween('output_products.created_at', $dates);
            })
            ->select('output_products.product_variant_id', 'product_variant_title', 'category_title', 'output_quantity', 'output_selling_price')
            ->get();
        Excel::store(new OutputProductExcelExport($data), $url);
    }
}
