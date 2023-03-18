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
        Permission::create(['name' => 'admin.team.index']);
        Permission::create(['name' => 'admin.team.store']);
        Permission::create(['name' => 'admin.team.show']);
        Permission::create(['name' => 'admin.team.update']);
        Permission::create(['name' => 'admin.team.destroy']);

        // Game permissions
        Permission::create(['name' => 'admin.game.index']);
        Permission::create(['name' => 'admin.game.store']);
        Permission::create(['name' => 'admin.game.show']);
        Permission::create(['name' => 'admin.game.update']);
        Permission::create(['name' => 'admin.game.destroy']);

        // Quiniela permissions
        Permission::create(['name' => 'admin.quiniela.index']);
        Permission::create(['name' => 'admin.quiniela.store']);
        Permission::create(['name' => 'admin.quiniela.show']);
        Permission::create(['name' => 'admin.quiniela.update']);
        Permission::create(['name' => 'admin.quiniela.destroy']);

        // Transaction permissions
        Permission::create(['name' => 'admin.transaction.index']);
        Permission::create(['name' => 'admin.transaction.store']);
        Permission::create(['name' => 'admin.transaction.show']);
        Permission::create(['name' => 'admin.transaction.update']);
        Permission::create(['name' => 'admin.transaction.destroy']);
    }
}
