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
    protected $policies = ['Expat'];
    //     [
    //         'policy' =>'Expat',
    //         'plan' => 'Expat plan',
    //         'service_limit_groups' => ['Out-patient benefits', 'In-patient benefits'],
            
    //     ]
    // ];
    // protected $plans = ['Expat plan'];
    // protected $serviceLimitGroups = ['']

    public function run()
    {
        foreach($this->policies as $policy){
            Policy::create([
                'name' => $policy
            ]);
        }
    }
}
