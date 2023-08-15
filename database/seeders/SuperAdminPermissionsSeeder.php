<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SuperAdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            //Home
            ['name' => 'home'],
            //UserManagement
            //Roles
            ['name' => 'role-list'],
            ['name' => 'role-create'],
            ['name' => 'role-edit'],
            ['name' => 'role-delete'],
            //Users
            ['name' => 'user-list'],
            ['name' => 'user-create'],
            ['name' => 'user-edit'],
            ['name' => 'user-delete'],

            //Companies
            ['name' => 'company-list'],
            ['name' => 'company-create'],
            ['name' => 'company-edit'],
            ['name' => 'company-delete'],
            ['name' => 'company-chart'],

            //payments
            ['name' => 'payment-list'],
            ['name' => 'payment-create'],
            ['name' => 'payment-edit'],
            ['name' => 'payment-delete'],
            ['name' => 'payment-chart'],

            //Rating
            ['name' => 'ratings-list'],

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 1]);
        }
    }

}
