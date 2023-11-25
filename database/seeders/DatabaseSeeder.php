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
        \App\Models\Level::create([
            'name' => 'Level 0',
            'description' => 'No Deposit yet',
            'min_price' => 0,
            'max_price' => 0,
            'return_percentage' => 0.0,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 1',
            'description' => 'Level 1',
            'min_price' => 10,
            'max_price' => 50,
            'return_percentage' => 0.1,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 2',
            'description' => 'Level 2',
            'min_price' => 51,
            'max_price' => 100,
            'return_percentage' => 0.2,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 3',
            'description' => 'Level 3',
            'min_price' => 101,
            'max_price' => 500,
            'return_percentage' => 0.3,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 4',
            'description' => 'Level 4',
            'min_price' => 501,
            'max_price' => 1000,
            'return_percentage' => 0.4,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 5',
            'description' => 'Level 5',
            'min_price' => 1001,
            'max_price' => 5000,
            'return_percentage' => 0.5,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 6',
            'description' => 'Level 6',
            'min_price' => 5001,
            'max_price' => 10000,
            'return_percentage' => 0.6,
            'active' => true,
        ]);
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
