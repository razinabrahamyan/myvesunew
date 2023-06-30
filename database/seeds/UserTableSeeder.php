<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_super_admin = Role::where('name', 'superadmin')->first();
        $user = new User();
        $user->username = 'superadmin';
        $user->first_name = 'superadmin';
        $user->last_name = 'superadmin';
        $user->email = 'superadmin@gmail.com';
        $user->password = bcrypt('123456789');
        $user->save();
        $user->roles()->attach($role_super_admin);

    }
}
