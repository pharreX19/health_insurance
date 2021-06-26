<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;
use App\Models\ServiceLimitGroup;
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
         'services',
         'plans',
         'subscribers',
         'service_subscriber',
         'plan_subscriber',
         'plan_service'
     ];

    public function run()
    {
        foreach($this->tables as $table){
            DB::statement('SET FOREIGN_KEY_CHECKS =0');
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        \App\Models\User::factory(10)->create();
        $this->call(UserTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(ServiceTypeTableSeeder::class);
        $this->call(ServiceLimitGroupTableSeeder::class);
        $this->call(ServiceTableSeeder::class);
        $this->call(PlanTableSeeder::class);
        $this->call(SubscriberTableSeeder::class);
        $this->call(ServiceSubscriberTableSeeder::class);


    }
}
