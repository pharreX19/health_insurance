<?php

namespace Database\Seeders;

use App\Models\EpisodeService;
use Illuminate\Database\Seeder;

class EpisodeServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EpisodeService::factory(10)->create();
    }
}
