<?php

namespace Database\Seeders;

use App\Models\ServiceSubscriber;
use Illuminate\Database\Seeder;

class ServiceSubscriberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceSubscriber::factory(5)->create();
    }
}
