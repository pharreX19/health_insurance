<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanServiceLimitGroup;
use App\Models\ServiceLimitGroup;
use Illuminate\Database\Seeder;

class PlanServiceLimitGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       PlanServiceLimitGroup::factory(5)->create();
    }
}
