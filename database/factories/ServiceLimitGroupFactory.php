<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\ServiceLimitGroup;
use App\Models\ServiceLimitGroupCalculationType;
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
    // protected $items = ["OP" , "IP & OP", "Emergency" , "IP" ];
    public function definition()
    {
        return [
            'name' => $this->faker->domainWord,
            'description'=> $this->faker->sentence(),
            // 'limit_total' => $this->faker->randomNumber(4),
        ];
    }
}
