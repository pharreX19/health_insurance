<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "subscriber_id" => Subscriber::orderByRaw("RAND()")->first(),
            // "plan_id" => Plan::inRandomOrder()->first()->id,
            "plan_remaining" => $this->faker->numberBetween(1000, 10000),
            "begin_date"=> Carbon::now()->subDays($this->faker->numberBetween(0, 20))->toDateString(),
            "expiry_date" => Carbon::now()->addDays(3)->toDateString()
        ];
    }
}
