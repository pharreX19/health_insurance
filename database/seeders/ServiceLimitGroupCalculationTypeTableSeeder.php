<?php

namespace Database\Seeders;

use App\Models\ServiceLimitGroupCalculationType;
use Illuminate\Database\Seeder;

class ServiceLimitGroupCalculationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $types = [
        "annually", "monthly", "daily", "per-event"
    ];

    public function run()
    {
        foreach($this->types as $type){
            ServiceLimitGroupCalculationType::create([
                'name'  => $type,
            ]);
        }
    }
}
