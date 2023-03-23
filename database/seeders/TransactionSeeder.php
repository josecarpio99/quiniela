<?php

namespace Database\Seeders;

use App\Enums\TransactionTypeEnum;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'user_id' => 2,
                'created_by' => 1,
                'date' => now()->subHours(2),
                'payment_method' => 1,
                'type' => TransactionTypeEnum::Deposit->value,
                'payment_reference' => '2123213',
                'amount' => 10,
            ],
            [
                'user_id' => 2,
                'created_by' => 1,
                'date' => now()->subHours(2),
                'payment_method' => 1,
                'type' => TransactionTypeEnum::Withdraw->value,
                'payment_reference' => '4543543',
                'amount' => 10,
            ],
        ];

        Transaction::insert($data);
    }
}
