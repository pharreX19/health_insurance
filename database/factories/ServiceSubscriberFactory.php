<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Service;
use App\Models\ServiceSubscriber;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceSubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceSubscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscriber_id' => Subscriber::inRandomOrder()->first()->id,
            'service_id' => Service::orderByRaw('RAND()')->first()->id,
            'covered_limit'=> $this->faker->numberBetween(100, 1000)
        ];
    }
}
