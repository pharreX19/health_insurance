<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\EpisodeService;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EpisodeService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "episode_id" => Episode::inRandomOrder()->first()->id,
            "service_id" => Service::inRandomOrder()->first()->id,
            "insurance_covered_limit" => $this->faker->numberBetween(100, 1000),
            "aasandha_covered_limit" => $this->faker->numberBetween(100, 1000),
            "self_covered_limit" => $this->faker->numberBetween(100, 1000),
        ];
    }
}
