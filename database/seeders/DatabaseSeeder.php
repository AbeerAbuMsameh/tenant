<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SuperAdminPermissionsSeeder::class,
            SuperAdminSeeder::class,
            CompanyPermissionsSeeder::class,
            PaymentPackageSeeder::class,
        ]);

    }
}
