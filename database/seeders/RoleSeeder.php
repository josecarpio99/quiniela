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

        // Deposit permissions
        Permission::create(['name' => 'deposit.index']);
        Permission::create(['name' => 'deposit.store']);
        Permission::create(['name' => 'deposit.show']);
        Permission::create(['name' => 'deposit.update']);
        Permission::create(['name' => 'deposit.destroy']);
        Permission::create(['name' => 'deposit.change_status']);

        // Withdraw permissions
        Permission::create(['name' => 'withdraw.index']);
        Permission::create(['name' => 'withdraw.store']);
        Permission::create(['name' => 'withdraw.show']);
        Permission::create(['name' => 'withdraw.update']);
        Permission::create(['name' => 'withdraw.destroy']);
        Permission::create(['name' => 'withdraw.change_status']);

        // Payment Method permissions
        Permission::create(['name' => 'payment_method.index']);
        Permission::create(['name' => 'payment_method.store']);
        Permission::create(['name' => 'payment_method.show']);
        Permission::create(['name' => 'payment_method.update']);
        Permission::create(['name' => 'payment_method.destroy']);

        // Ticket permissions
        Permission::create(['name' => 'ticket.index']);
        Permission::create(['name' => 'ticket.store']);
        Permission::create(['name' => 'ticket.show']);
        Permission::create(['name' => 'ticket.update']);
        Permission::create(['name' => 'ticket.destroy']);
        Permission::create(['name' => 'ticket.update_points']);
    }
}
