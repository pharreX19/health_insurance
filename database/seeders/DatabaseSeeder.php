<?php

namespace Database\Seeders;

use App\Models\PlanServiceLimitGroup;
use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use App\Models\ServiceLimitGroup;
use App\Models\ServiceLimitGroupCalculationType;
use App\Models\ServiceSubscriber;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

     protected $tables = [
         'users',
         'companies',
         'service_types',
         'service_limit_groups',
         'service_limit_group_calculation_types',
         'services',
         'plans',
         'subscribers',
        //  'service_subscriber',
         'claims',
         'plan_service',
         'policies',
         'episodes',
         'episode_service',
         'countries'
     ];

    public function run()
    {
        // foreach($this->tables as $table){
            // DB::statement('SET FOREIGN_KEY_CHECKS =0');
            // DB::table($table)->truncate();
        // }
        // DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        // $this->call(RoleTableSeeder::class);
        // $this->call(ServiceProviderTableSeeder::class);
        // $this->call(ServiceLimitGroupCalculationTypeTableSeeder::class);
        // $this->call(PolicyTableSeeder::class);
        // $this->call(UserTableSeeder::class);
        // $this->call(CompanyTableSeeder::class);
        // $this->call(ServiceTypeTableSeeder::class);
        // $this->call(ServiceLimitGroupTableSeeder::class);
        // $this->call(ServiceTableSeeder::class);
        // $this->call(PlanTableSeeder::class);
        // $this->call(SubscriberTableSeeder::class);
        $this->call(EpisodeTableSeeder::class);
        // $this->call(ClaimTableSeeder::class);
        // $this->call(SubscriptionTableSeeder::class);
        // $this->call(EpisodeTableSeeder::class);
        // $this->call(PlanServiceLimitGroupTableSeeder::class);
        $this->call(EpisodeServiceTableSeeder::class);
        // $this->call(CountryTableSeeder::class);
        // \App\Models\User::factory(10)->create();

    }
}
