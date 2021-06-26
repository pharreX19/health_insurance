<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanService;
use App\Models\Service;
use Illuminate\Database\Seeder;

class PlanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = Plan::factory(3)->create();
        $services = Service::all();

        $plans->each(function($plan) use ($services){
            $services->each(function($service) use ($plan){
                PlanService::factory()->create([
                    'plan_id'=> $plan->id,
                    'service_id'=> $service->id,
                ]);
            });
        });
    }
}
