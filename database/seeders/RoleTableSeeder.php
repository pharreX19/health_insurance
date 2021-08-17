<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory(1)->create();

        // $roles = ['User', 'Receptionist', 'Admin', 'Accountant', 'Employee'];
        // foreach($roles as $role){
        //     Role::factory(1)->create([
        //         'name' => $role
        //     ]);
        // }
    }
}
