<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company,
            "contact" => $this->faker->phoneNumber,
            "address" => $this->faker->address,
            "street" => $this->faker->streetName
        ];
    }
}
