<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Offer;

class CheckOfferWinJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private int $userId;
    public function __construct( int $userId )
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = \App\Models\User::find($this->userId);
        $availedOfferIds = $user->offers()->pluck('id')->toArray();
        $offers = Offer::whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now())
        ->where('active', true)->whereNotIn('id',$availedOfferIds)->get();
        foreach ($offers as $offer) {
            if($offer->offer_type == 'first_deposit'){
                $deposit = $user->deposits()->where('status', 'completed')->first();
                if($deposit && $deposit->amount >= $offer->price){
                    $amount = $offer->reward_price;
                    if($offer->reward_type == "P"){
                        $amount = ($deposit->amount * $offer->reward_price) / 100;
                    }
                    $user->offers()->attach($offer->id, ['price' => $amount]);
                    $user->updateWallet($amount, 'First Deposit Reward', true);
                    $offer->qty_sold = $offer->qty_sold + 1;
                    $offer->save();
                }
            }
            // else if($offer->offer_type == 'deposit'){
            //     $deposit = $user->deposits()->where('status', 'completed')->where('amount', '>=', $offer->price)->first();
            //     if($deposit){
            //         $amount = $offer->reward_price;
            //         if($offer->reward_type == "P"){
            //             $amount = ($deposit->amount * $offer->reward_price) / 100;
            //         }
            //         $user->offers()->attach($offer->id, ['price' => $amount]);
            //         $user->updateWallet($amount, 'Deposit Reward', true);
            //         $offer->qty_sold = $offer->qty_sold + 1;
            //         $offer->save();
            //     }
            // }else if($offer->offer_type == 'referral_deposit'){
            //     $referrals = $user->referrals()->whereHas(['deposits' => function($q){
            //         $q->where('status', 'completed');
            //     }])->get();
            //     foreach ($referrals as $referral) {

            //     }
            //     if($referrals->count() >= $offer->qty){
            //         $amount = $offer->reward_price;
            //         if($offer->reward_type == "P"){
            //             $amount = ($referrals->sum('amount') * $offer->reward_price) / 100;
            //         }
            //         $user->offers()->attach($offer->id, ['price' => $amount]);
            //         $user->updateWallet($amount, 'Referral Reward', true);
            //         $offer->qty_sold = $offer->qty_sold + 1;
            //         $offer->save();
            //     }
            // }
        }
    }
}
