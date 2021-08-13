<?php

namespace Database\Factories;

use App\Models\Claim;
use App\Models\Episode;
use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClaimFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Claim::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "service_provider_id"=> ServiceProvider::inRandomOrder()->first()->id,
            "episode_id" => Episode::inRandomOrder()->first()->id,
            "claimable_amount" => $this->faker->numberBetween(100, 1000),
            "status" => array_rand(["pending" => 0, "completed" => 1, "cancelled" => 2])
        ];
    }
}
