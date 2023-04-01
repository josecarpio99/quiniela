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
        $superAdmin = Role::create(['name' => 'Super admin']);
        $client = Role::create(['name' => 'Client']);

        // User permissions
        Permission::create(['name' => 'user.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'user.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'user.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'user.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'user.destroy'])->syncRoles([$superAdmin]);

        // Team permissions
        Permission::create(['name' => 'team.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'team.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'team.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'team.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'team.destroy'])->syncRoles([$superAdmin]);

        // Game permissions
        Permission::create(['name' => 'game.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'game.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'game.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'game.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'game.destroy'])->syncRoles([$superAdmin]);

        // Quiniela permissions
        Permission::create(['name' => 'quiniela.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'quiniela.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'quiniela.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'quiniela.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'quiniela.destroy'])->syncRoles([$superAdmin]);

        // Deposit permissions
        Permission::create(['name' => 'deposit.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'deposit.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'deposit.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'deposit.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'deposit.destroy'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'deposit.change_status'])->syncRoles([$superAdmin]);

        // Withdraw permissions
        Permission::create(['name' => 'withdraw.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'withdraw.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'withdraw.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'withdraw.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'withdraw.destroy'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'withdraw.change_status'])->syncRoles([$superAdmin]);

        // Payment Method permissions
        Permission::create(['name' => 'payment_method.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'payment_method.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'payment_method.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'payment_method.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'payment_method.destroy'])->syncRoles([$superAdmin]);

        // Ticket permissions
        Permission::create(['name' => 'ticket.index'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'ticket.store'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'ticket.show'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'ticket.update'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'ticket.destroy'])->syncRoles([$superAdmin]);
        Permission::create(['name' => 'ticket.update_points'])->syncRoles([$superAdmin]);

    }
}
