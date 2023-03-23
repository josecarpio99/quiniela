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

        // Deposit permissions
        Permission::create(['name' => 'admin.deposit.index']);
        Permission::create(['name' => 'admin.deposit.store']);
        Permission::create(['name' => 'admin.deposit.show']);
        Permission::create(['name' => 'admin.deposit.update']);
        Permission::create(['name' => 'admin.deposit.destroy']);

        // Withdraw permissions
        Permission::create(['name' => 'admin.withdraw.index']);
        Permission::create(['name' => 'admin.withdraw.store']);
        Permission::create(['name' => 'admin.withdraw.show']);
        Permission::create(['name' => 'admin.withdraw.update']);
        Permission::create(['name' => 'admin.withdraw.destroy']);

        // Payment Method permissions
        Permission::create(['name' => 'admin.payment_method.index']);
        Permission::create(['name' => 'admin.payment_method.store']);
        Permission::create(['name' => 'admin.payment_method.show']);
        Permission::create(['name' => 'admin.payment_method.update']);
        Permission::create(['name' => 'admin.payment_method.destroy']);
    }
}
