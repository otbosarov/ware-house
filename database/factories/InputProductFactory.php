<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InputProduct>
 */
class InputProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "product_variant_id" => 1,
            "input_price" => 12,
            "currency_type" => "USD",
            "amount" => 2
        ];
    }
}
