<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->company(),
            'registration'=> $this->faker->buildingNumber(),
            'contact'=> $this->faker->randomNumber(8),
            'street' => $this->faker->streetName,
            'address' => $this->faker->address,
            'email' => $this->faker->safeEmail
        ];
    }
}
