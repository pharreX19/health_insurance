<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Plan;
use App\Models\PlanService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlanService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'limit_total'=> rand(100, 1000)

        ];
    }
}
