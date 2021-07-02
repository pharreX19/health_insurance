<?php

namespace Database\Seeders;

use App\Models\ServiceProvider;
use Illuminate\Database\Seeder;

class ServiceProviderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceProvider::factory(5)->create();
    }
}
