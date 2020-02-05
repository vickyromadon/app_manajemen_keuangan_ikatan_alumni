<?php

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'superadmin')->first();
        $role->perms()->detach();

        $permission = Permission::firstOrCreate(
            ['name' => 'profile'],
            [
                'display_name' => 'Menu Profile',
                'description' => ' Mengelola data pribadi / biodata.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'dataset'],
            [
                'display_name' => 'Menu Dataset',
                'description' => ' Mengelola data alumni.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'news'],
            [
                'display_name' => 'Menu Berita',
                'description' => ' Mengelola data berita.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'galery'],
            [
                'display_name' => 'Menu Galeri',
                'description' => ' Mengelola data galeri.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'event'],
            [
                'display_name' => 'Menu Event',
                'description' => ' Mengelola data event.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'donation'],
            [
                'display_name' => 'Menu Donasi',
                'description' => ' Mengelola data donasi.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'message'],
            [
                'display_name' => 'Menu Kritik dan Saran',
                'description' => ' Mengelola data kritik dan saran.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'slider'],
            [
                'display_name' => 'Menu Slider',
                'description' => ' Mengelola data slider.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'bank'],
            [
                'display_name' => 'Menu Bank',
                'description' => ' Mengelola data bank.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'dana-event'],
            [
                'display_name' => 'Menu Dana Event',
                'description' => ' Mengelola data dana event.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'dana-donation'],
            [
                'display_name' => 'Menu Dana Donasi',
                'description' => ' Mengelola data dana donasi.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'contribution'],
            [
                'display_name' => 'Menu Iuran',
                'description' => ' Mengelola data iuran.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'dana-contribution'],
            [
                'display_name' => 'Menu Dana iuran',
                'description' => ' Mengelola data dana iuran.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'income-report'],
            [
                'display_name' => 'Menu Laporan Masuk',
                'description' => ' Mengelola data laporan masuk.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'expense-report'],
            [
                'display_name' => 'Menu Laporan Keluar',
                'description' => ' Mengelola data laporan keluar.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'accountancy'],
            [
                'display_name' => 'Menu Pembukuan',
                'description' => ' Mengelola data pembukuan.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'role'],
            [
                'display_name' => 'Menu Peranan',
                'description' => ' Mengelola data peranan.'
            ]
        );
        $role->attachPermission($permission);

        $permission = Permission::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'Menu Pengguna',
                'description' => ' Mengelola data pengguna.'
            ]
        );
        $role->attachPermission($permission);
    }
}
