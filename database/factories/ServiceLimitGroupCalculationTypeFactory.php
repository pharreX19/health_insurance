<?php

namespace Database\Factories;

use App\Models\ServiceLimitGroupCalculationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceLimitGroupCalculationTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceLimitGroupCalculationType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => array_rand(["annually" => 0, "monthly" => 1, "daily" => 2, "per-event" => 3]),
            'slug'=> array_rand(["annually" => 0, "monthly" => 1, "daily" => 2, "per-event" => 3]),

        ];
    }
}
