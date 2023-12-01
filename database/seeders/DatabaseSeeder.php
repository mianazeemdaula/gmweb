<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'max_price' => 3000,
            'return_percentage' => 0.5,
            'active' => true,
        ]);

        \App\Models\Level::create([
            'name' => 'Level 7',
            'description' => 'Level 7',
            'min_price' => 3001,
            'max_price' => 8000,
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
        \App\Models\User::factory(1)->state([
            'email' => 'admin@goldminner.gold',
            'tag' => 'admin',
            'phone_verified_at' => now(),
            'phone' => '1234567890',
        ])->create();
        // \App\Models\User::factory(7)->state([
        //     'referral' => 1,
        // ])->create();
        // for ($i=1; $i <= 7; $i++) {
        //     \App\Models\User::factory(7)->state([
        //         'referral' => $i + 1,
        //     ])->create();
        // }
        // $users = \App\Models\User::where('id','>',8)->get();
        // foreach($users as $user){
        //     \App\Models\User::factory(7)->state([
        //         'referral' => $user->id,
        //     ])->create();
        // }

        // \App\Models\User::query()->update(['level_id' => 2]);

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

        \App\Models\PaymentMethod::create([
            'name' => 'Deposit',
            'code' => 'Deposit',
            'description' => 'USDT',
            'logo' => 'paypal.png',
            'status' => 'active',
            'config' => [],
        ]);

        \App\Models\Offer::create([
            'name' => 'First Deposit',
            'description' => 'First Deposit',
            'code' => 'FIRSTDEPOSIT',
            'offer_type' => 'first_deposit',
            'min_price' => 10,
            'max_price' => 10000,
            'reward_price' => 1,
            'reward_type' => 'P',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'active' => true,
            'qty' => 100,
            'qty_sold' => 0,
            'image' => 'first_deposit.jpg',
        ]);
        // $userCount = \App\Models\User::count();
        // for ($i=1; $i <= $userCount; $i++) { 
        //     $deposit = new \App\Models\Deposit();
        //     $deposit->user_id = $i;
        //     $deposit->payment_method_id = 1;
        //     $deposit->amount = 10;
        //     $deposit->tx_id = Str::random(10);
        //     $deposit->status = 'completed';
        //     $deposit->description = 'Deposit from Crypto';
        //     $deposit->save();
        // }
    }
}
