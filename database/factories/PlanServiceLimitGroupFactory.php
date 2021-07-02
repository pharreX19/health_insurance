<?php

namespace Database\Factories;

use App\Models\Plan;
use App\Models\ServiceLimitGroup;
use App\Models\PlanServiceLimitGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanServiceLimitGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlanServiceLimitGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "service_limit_group_id" => ServiceLimitGroup::inRandomOrder()->first()->id,
            "plan_id" => Plan::inRandomOrder()->first()->id,
            "limit_total" => $this->faker->numberBetween(1000, 5000)
        ];
    }
}
