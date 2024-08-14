<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Stock;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Stock::class;

    public function definition()
    {
        return [
            'fabric_type' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 1000),
            'location' => $this->faker->word,
        ];
    }
}
