<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(
        	['name' => 'superadmin'],
        	['display_name' => 'Super Admin', 'description' => 'Ini adalah super admin']
        );

        Role::firstOrCreate(
        	['name' => 'pengurus'],
        	['display_name' => 'Pengurus', 'description' => 'Ini adalah pengurus']
        );

        Role::firstOrCreate(
        	['name' => 'alumni'],
        	['display_name' => 'Alumni', 'description' => 'Ini adalah alumni']
        );
    }
}
