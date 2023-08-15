<?php

namespace Database\Seeders\Tenancy;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CompanyFirstUserSeeder extends Seeder
{
    protected $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    public function run() {
        $user = User::create([
            'name'          => "{$this->company->name} Admin",
            'email'         => $this->company->email,
            'company_id'    => $this->company->id,
            'password'      => Hash::make('123456'),
            'level'         => 2,
        ]);

        $role = Role::query()->firstOrCreate([
            'name'          => "{$this->company->name} Admin Role",
            'company_id'    => $this->company->id,
            'level'         => 2,
        ]);

        $permissions = Permission::where(['level' => 2])->orwhere(['name'=>'home'])->pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
