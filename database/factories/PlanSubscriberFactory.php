<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Plan;
use App\Models\PlanSubscriber;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanSubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlanSubscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'plan_remaining'=> rand(1000, 2000),
        ];
    }
}
