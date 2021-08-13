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
    public function run()
    {
        ServiceLimitGroupCalculationType::factory(3)->create();
    }
}
