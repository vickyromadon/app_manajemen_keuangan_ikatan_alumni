<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('username', 'superadmin')->first() === null) {
            $user               = new User();
            $user->username     = 'superadmin';
            $user->name         = 'Super Admin';
            $user->password     = Hash::make('password');
            $user->save();

            // role attach alias
            $role = Role::where('name', 'superadmin')->first();
            $user->attachRole($role);
        }
    }
}
