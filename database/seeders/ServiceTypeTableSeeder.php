<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $types = [
        'Medical expenses other than in-patient expenses',
        'Hospital benefits',
        'Surgical benefits',
        'Medical benefits (medical expenses for non surgical treatments',
    ];

    public function run()
    {
        foreach($this->types as $type){
            ServiceType::create([
                'name' => $type
            ]);
        }
    }
}
