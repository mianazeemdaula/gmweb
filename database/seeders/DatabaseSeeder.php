<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Package::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\PaymentMethod::create([
            'name' => 'Crypto Currency',
            'description' => 'USDT',
            'logo' => 'paypal.png',
            'status' => true,
            'config' => [],
        ]);
        \App\Models\Deposit::create([
            'user_id' => 1,
            'payment_method_id' => 1,
            'amount' => 27.580,
            'status' => 'success',
            'tx_id' => '5YK92208E6619143D',
        ]);

        \App\Models\Deposit::create([
            'user_id' => 1,
            'payment_method_id' => 1,
            'amount' => 15.2506,
            'status' => 'success',
            'tx_id' => '5YK92208E6619143D',
        ]);

        \App\Models\Deposit::create([
            'user_id' => 3,
            'payment_method_id' => 1,
            'amount' => 25.0005,
            'status' => 'success',
            'tx_id' => '5YKA2208E6619143D',
        ]);

    }
}
