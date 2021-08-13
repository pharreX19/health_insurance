<?php

namespace Database\Seeders;

use App\Models\Episode;
use Illuminate\Database\Seeder;

class EpisodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Episode::factory(5)->create();
    }
}
