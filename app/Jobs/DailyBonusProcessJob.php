<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class DailyBonusProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private User $user;
    public function __construct( User $user )
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $userEarn = ($this->user->level->return_percentage * $this->user->deposits()->sum('amount')) / 100;
        // 8% of level 1 referrals earning with reference to level percentage
        // 5% of level 2 referrals earning with reference to level percentage
        // 3% of level 3 referrals earning with reference to level percentage
        if($userEarn > 0) {
            $this->user->updateWallet($userEarn, 'Earn on Deposit', true);
        }
        $referralEarnings = 0;
        // Level 1 Referrals
        foreach ($this->user->paidReferrals as $referral) {
            $referralEarnL1 = ($referral->level->return_percentage * $referral->deposits()->sum('amount')) / 100;
            $earnOnL1 = ($referralEarnL1 * 8) / 100;
            $referralEarnings += $earnOnL1;
            // Level 2 Referrals
            foreach ($referral->paidReferrals as $referralL2) {
                $referralEarnL2 = ($referralL2->level->return_percentage * $referralL2->deposits()->sum('amount')) / 100;
                $earnOnL2 = ($referralEarnL2 * 5) / 100;
                $referralEarnings += $earnOnL2;
                // Level 3 Referrals
                foreach ($referralL2->paidReferrals as $referralL3) {
                    $referralEarnL3 = ($referralL3->level->return_percentage * $referralL3->deposits()->sum('amount')) / 100;
                    $earnOnL3 = ($referralEarnL3 * 3) / 100;
                    $referralEarnings += $earnOnL3;
                }
            }
        }
        if($referralEarnings > 0) {
            $this->user->updateWallet($referralEarnings, 'Earn on referrals', true);
        }
    }
}
