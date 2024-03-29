<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mining;
use App\Models\Wallet;

class MiningBonusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mining-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process mining bonus for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get all minings that are ended and not processed
        $minings = Mining::where('mining_end', '<=', now())->get();
        foreach ($minings as $mining) {
            $user = $mining->user;
            $amount = $mining->amount;                                         
            $refAmount = $mining->ref_amount;
            if($amount > 0){
                $user->updateWallet($amount, 'Earn on deposit', true);
            }
            if($refAmount > 0){
                $user->updateWallet($refAmount, 'Earn on referrals',true);
            }
            $mining->delete();

            // update wallet balance for user after mining bonus is processed
            $transactions = Wallet::where('user_id', $user->id)->orderBy('id', 'asc')->get();
            $balance = 0;
            foreach($transactions as $transaction){
                $balance += $transaction->credit;
                $balance -= $transaction->debit;
                $transaction->balance = $balance;
                $transaction->save();
            }
        }
    }
}
