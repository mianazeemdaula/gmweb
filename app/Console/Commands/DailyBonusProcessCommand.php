<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DailyBonusProcessCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-bonus-process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process daily bonus for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::whereHas('deposit', function ($q) {
            $q->where('status', 'completed');
        })->get();
        $seconds = 0;
        foreach ($users as $user) {
            \App\Jobs\DailyBonusProcessJob::dispatch($user)->delay(now()->addSeconds($seconds));
            $seconds += 30;
        }  
    }
}
