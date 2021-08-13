<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\Model;
use App\Models\Policy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Plan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->colorName(),
            'limit_total'=>$this->faker->randomNumber(6),
            'territorial_limit'=>'SAARC',
            'currency'=> $this->faker->randomElement(['MVR', 'USD']),
            'premium' => $this->faker->numberBetween(100, 10000),
            "policy_id" => Policy::inRandomOrder()->first()->id
        ];
    }
}
