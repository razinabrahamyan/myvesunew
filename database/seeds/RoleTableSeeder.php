<?php

use App\Role;
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
        $role_employee = new Role();
        $role_employee->name = "superadmin";
        $role_employee->description = "A Superadmin";
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = "admin";
        $role_manager->description = "A Admin";
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = "driver";
        $role_manager->description = "A Driver";
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = "passenger";
        $role_manager->description = "A Passenger";
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = "company";
        $role_manager->description = "A Company";
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = "user";
        $role_manager->description = "A User";
        $role_manager->save();
    }
}
