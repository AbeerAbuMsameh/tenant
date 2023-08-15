<?php

namespace Database\Seeders\Tenancy;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teamNames = [
            'Developer Team',
            'Frontend Team',
            'Backend Team',
            'Design Team',
            'Server Team',
            'Quality Assurance Team',
            'Project Management Team',
            'Sales Team',
            'Marketing Team',
            'Customer Support Team',
            'Operations Team',
            'Research and Development Team',
            'Data Science Team',
            'Security Team',
            'Infrastructure Team',
        ];
        foreach ($teamNames as $name) {
            Team::create([
                'name' => $name,
            ]);
        }

    }
}
