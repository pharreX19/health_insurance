<?php

namespace Database\Seeders;

use App\Models\Claim;
use Illuminate\Database\Seeder;

class ClaimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Claim::factory(10)->create();
    }
}
