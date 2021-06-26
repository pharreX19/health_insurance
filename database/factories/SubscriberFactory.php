<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Model;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=> $this->faker->name(),
            'passport' => $this->faker->creditCardNumber(),
            'national_id' => $this->faker->swiftBicNumber(),
            'nationality'=> 'Maldives',
            'contact' => $this->faker->phoneNumber,
            'company_id'=> Company::inRandomOrder()->first()->id
        ];
    }
}
