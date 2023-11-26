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
            'return_percentage' => 0.15,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 3',
            'description' => 'Level 3',
            'min_price' => 101,
            'max_price' => 200,
            'return_percentage' => 0.2,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 4',
            'description' => 'Level 4',
            'min_price' => 201,
            'max_price' => 500,
            'return_percentage' => 0.3,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 5',
            'description' => 'Level 5',
            'min_price' => 501,
            'max_price' => 1000,
            'return_percentage' => 0.4,
            'active' => true,
        ]);
        \App\Models\Level::create([
            'name' => 'Level 6',
            'description' => 'Level 6',
            'min_price' => 1001,
            'max_price' => 30000,
            'return_percentage' => 0.5,
            'active' => true,
        ]);

        \App\Models\Level::create([
            'name' => 'Level 7',
            'description' => 'Level 7',
            'min_price' => 3001,
            'max_price' => 80000,
            'return_percentage' => 0.6,
            'active' => true,
        ]);

        \App\Models\Level::create([
            'name' => 'Level 8',
            'description' => 'Level 8',
            'min_price' => 8001,
            'max_price' => 10000,
            'return_percentage' => 0.7,
            'active' => true,
        ]);

        \App\Models\Level::create([
            'name' => 'Level 9',
            'description' => 'Level 9',
            'min_price' => 10001,
            'max_price' => 15000,
            'return_percentage' => 0.8,
            'active' => true,
        ]);

        \App\Models\Level::create([
            'name' => 'Level 10',
            'description' => 'Level 10',
            'min_price' => 15001,
            'max_price' => 90000,
            'return_percentage' => 1.0,
            'active' => true,
        ]);

        \App\Models\User::factory(10)->create();
        \App\Models\Package::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\PaymentMethod::create([
            'name' => 'USDT Tron',
            'code' => 'USDTTRC20',
            'description' => 'USDT',
            'logo' => 'paypal.png',
            'status' => 'active',
            'config' => [],
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'USDT Binace',
            'code' => 'USDTBSC',
            'description' => 'USDT',
            'logo' => 'paypal.png',
            'status' => 'active',
            'config' => [],
        ]);

        \App\Models\PaymentMethod::create([
            'name' => 'Wallet',
            'code' => 'WALLET',
            'description' => 'USDT',
            'logo' => 'paypal.png',
            'status' => 'active',
            'config' => [],
        ]);

        // for ($i=0; $i <5 ; $i++) { 
        //     \App\Models\Deposit::create([
        //         'user_id' => 1,
        //         'payment_method_id' => 1,
        //         'amount' => rand(10, 100),
        //         'status' => 'completed',
        //         'tx_id' => '1234567890',
        //     ]);
        // }

        \App\Models\Offer::create([
            'name' => 'First Deposit',
            'description' => 'First Deposit',
            'code' => 'FIRSTDEPOSIT',
            'offer_type' => 'first_deposit',
            'price' => 10,
            'reward_price' => 20,
            'reward_type' => 'P',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'active' => true,
            'qty' => 100,
            'qty_sold' => 0,
            'image' => 'first_deposit.png',
        ]);

    }
}
