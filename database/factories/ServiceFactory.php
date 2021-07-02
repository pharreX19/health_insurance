<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Service;
use App\Models\ServiceLimitGroup;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->userName(),
            'description' => $this->faker->sentence(),
            // 'patient_type' => $this->faker->randomElement(['inpatient', 'outpatient', 'emergency']),
            'service_type_id' => ServiceType::inRandomOrder()->first()->id,
            "service_limit_group_id" => ServiceLimitGroup::inRandomOrder()->first()->id
        ];
    }
}
