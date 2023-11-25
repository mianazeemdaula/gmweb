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
        $level1Amount = ($this->user->level->return_percentage * $this->user->deposits()->sum('amount')) / 100;
        if($level1Amount > 0){
            $this->user->updateWallet($level1Amount, 'Bonus of L1');
            foreach ($this->user->paidReferrals as $userLevel1) {
                $level2Amount = (0.05 * $userLevel1->deposits()->sum('amount')) / 100;
                $this->user->updateWallet($level2Amount, 'Bonus of L2');
                foreach ($userLevel1->paidReferrals as $userLevel2) {
                    $level3Amount = (0.03 * $userLevel2->deposits()->sum('amount')) / 100;
                    $this->user->updateWallet($level3Amount, 'Bonus of L3');
                }
            }
        }
    }
}
