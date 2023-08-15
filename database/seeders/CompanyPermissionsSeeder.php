<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CompanyPermissionsSeeder extends Seeder
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
            ['name' => 'c-home'],
            //CompanyManagement
            //Systems
            ['name' => 'system-list'],
            ['name' => 'system-create'],
            ['name' => 'system-edit'],
            ['name' => 'system-delete'],
            //Members
            ['name' => 'member-list'],
            ['name' => 'member-create'],
            ['name' => 'member-edit'],
            ['name' => 'member-delete'],

            //Teams
            ['name' => 'team-list'],
            ['name' => 'team-create'],
            ['name' => 'team-edit'],
            ['name' => 'team-delete'],

            //Tiers
            ['name' => 'tier-list'],
            ['name' => 'tier-create'],
            ['name' => 'tier-edit'],
            ['name' => 'tier-delete'],

            //Ticket
            ['name' => 'ticket-list'],
            ['name' => 'ticket-create'],
            ['name' => 'ticket-edit'],
            ['name' => 'ticket-show'],
            ['name' => 'ticket-close'],
            ['name' => 'ticket-assign'],
            ['name' => 'ticket-resolve'],
            ['name' => 'ticket-open'],
            ['name' => 'ticket-delete'],
            ['name' => 'ticket-chart'],

            //Rule
            ['name' => 'rule-create'],
            ['name' => 'rule-edit'],
            ['name' => 'rule-delete'],
            ['name' => 'rule-list'],

            //Conjunction
            ['name' => 'conjunction-create'],
            ['name' => 'conjunction-edit'],
            ['name' => 'conjunction-delete'],
            ['name' => 'conjunction-list'],

            //Tag
            ['name' => 'tag-create'],
            ['name' => 'tag-edit'],
            ['name' => 'tag-delete'],
            ['name' => 'tag-list'],

            //Service
            ['name' => 'service-create'],
            ['name' => 'service-edit'],
            ['name' => 'service-delete'],
            ['name' => 'service-list'],

            //service-system
            ['name' => 'service-system-create'],
            ['name' => 'service-system-edit'],
            ['name' => 'service-system-delete'],
            ['name' => 'service-system-list'],

            //troubleshoot
            ['name' => 'troubleshoot'],
            ['name' => 'troubleshootRequest'],

            //Rating
            ['name' => 'rating-create'],
            ['name' => 'rating-edit'],
            ['name' => 'rating-delete'],
            ['name' => 'rating-list'],


        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission['name'], 'level' => 2]);
        }
    }
}
