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

        if (User::where('username', 'pengurus')->first() === null) {
            $user               = new User();
            $user->username     = 'pengurus';
            $user->name         = 'Pengurus';
            $user->password     = Hash::make('password');
            $user->save();

            // role attach alias
            $role = Role::where('name', 'pengurus')->first();
            $user->attachRole($role);
        }

        if (User::where('username', '12345678')->first() === null) {
            $user               = new User();
            $user->username     = '12345678';
            $user->name         = 'Alumni Satu';
            $user->password     = Hash::make('password');
            $user->save();

            // role attach alias
            $role = Role::where('name', 'alumni')->first();
            $user->attachRole($role);
        }
    }
}
