<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;

class PolicyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Policy::factory(2)->create();
    }
}
