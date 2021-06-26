<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanSubscriber;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subscribers = Subscriber::factory(10)->create();

        $subscribers->each(function($subscriber){
            PlanSubscriber::factory(1)->create([
                'plan_id' => Plan::inRandomOrder()->first()->id,
                'subscriber_id' => $subscriber->id
            ]);
        });
    }
}
