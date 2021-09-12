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
    protected $items = ["Inpatient Benefits" , "Outpatient Benefits" ];
    public function definition()
    {
        foreach($this->items as $item){
            ServiceLimitGroup::create([
                'name' => $item,
                "description" => $this->faker->sentence
            ]);
        }
    }
}
