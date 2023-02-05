<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create(['name' => 'Super admin']);

        Permission::create(['name' => 'team.index']);
        Permission::create(['name' => 'team.store']);
        Permission::create(['name' => 'team.show']);
        Permission::create(['name' => 'team.update']);
        Permission::create(['name' => 'team.destroy']);
    }
}
