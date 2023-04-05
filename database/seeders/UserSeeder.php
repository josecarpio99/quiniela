<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'admin',
        //     'email' => 'superadmin@test.com',
        //     'password' => bcrypt('12345678'),
        // ])->assignRole(Role::findByName('Super admin'));

        User::factory()->create([
            'username' => 'superadmin',
            'email' => 'superadmin@test.com',
        ])->assignRole(Role::findByName('Super admin'));

        User::factory()->create([
            'username' => 'user1',
            'email' => 'user1@test.com',
        ])->assignRole(Role::findByName('Client'));

        User::factory()->create([
            'username' => 'user2',
            'email' => 'user2@test.com',
        ])->assignRole(Role::findByName('Client'));
    }
}
