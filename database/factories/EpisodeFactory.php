<?php

namespace Database\Factories;

use App\Models\Episode;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "memo_number" => $this->faker->biasedNumberBetween(1000, 10000),
            "subscriber_id" => Subscriber::inRandomOrder()->first()->id,
            // "service_id" => Service::inRandomOrder()->first()->id,
            "service_provider_id" => ServiceProvider::inRandomOrder()->first()->id,
            "activity_at" => Carbon::now()
        ];
    }
}
