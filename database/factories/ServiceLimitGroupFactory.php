<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\ServiceLimitGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceLimitGroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceLimitGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Annual',
            'slug'=>'annual',
            'description'=> $this->faker->sentence(),
            'limit_total' => $this->faker->randomNumber(4)
        ];
    }
}