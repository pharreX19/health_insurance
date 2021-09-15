<?php

namespace Database\Seeders;

use App\Models\ServiceLimitGroup;
use Illuminate\Database\Seeder;

class ServiceLimitGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceLimitGroup::factory()->create();
    }
}
