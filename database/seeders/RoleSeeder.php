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
        Role::create(['name' => 'Super admin']);
        Role::create(['name' => 'Client']);

        // Team permissions
        Permission::create(['name' => 'team.index']);
        Permission::create(['name' => 'team.store']);
        Permission::create(['name' => 'team.show']);
        Permission::create(['name' => 'team.update']);
        Permission::create(['name' => 'team.destroy']);

        // Game permissions
        Permission::create(['name' => 'game.index']);
        Permission::create(['name' => 'game.store']);
        Permission::create(['name' => 'game.show']);
        Permission::create(['name' => 'game.update']);
        Permission::create(['name' => 'game.destroy']);

        // Quiniela permissions
        Permission::create(['name' => 'quiniela.index']);
        Permission::create(['name' => 'quiniela.store']);
        Permission::create(['name' => 'quiniela.show']);
        Permission::create(['name' => 'quiniela.update']);
        Permission::create(['name' => 'quiniela.destroy']);
    }
}
