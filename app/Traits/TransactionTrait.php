<?php

namespace App\Traits;

use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

trait TransactionTrait
{
    public function updateWallet(float $amount, string $description = null, bool $isBonus = false)
    {
        $wallet =  $this->wallet;
        $balance = 0;
        if($wallet){
            $balance = $wallet->balance;
        }
        $debit = $credit = 0;
        if($amount > 0){
            $balance = $balance + $amount;
            $credit = $amount;
        }else{
            $balance = $balance - abs($amount);
            $debit = abs($amount);
        }
        $transaction = new Wallet([
            'debit' => $debit,
            'credit' => $credit,
            'balance' =>  $balance,
            'description' => $description,
            'is_bonus' => $isBonus,
            'user_id' => $this->id,
        ]);

        // Associate the transaction with the user
        $this->transactions()->save($transaction);
    }
}
