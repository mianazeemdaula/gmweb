<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Offer;
use App\Models\Deposit;

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
                $firstDepositOffers =  $user->offers()->where('offer_type', 'first_deposit')->count();
                if($firstDepositOffers == 0){
                    $deposit = $user->deposits()->where('status', 'completed')->first();
                    if($deposit && $deposit->amount >= $offer->min_price  && $deposit->amount <= $offer->max_price){
                        $amount = 0;
                        $amount = ($deposit->amount * $offer->reward_price) / 100;
                        $user->offers()->attach($offer->id, ['price' => $amount]);
                        // $user->updateWallet($amount, 'First Deposit Reward', true);
                        $dep = new Deposit();
                        $dep->user_id = $user->id;
                        $dep->payment_method_id = 1;
                        $dep->amount = $amount;
                        $dep->tx_id = '0000000';
                        $dep->status = 'completed';
                        $dep->description = 'First Deposit Reward';
                        $dep->save();
                        $offer->qty_sold = $offer->qty_sold + 1;
                        $offer->save();
                    }
                }
            }else if($offer->offer_type == 'welcome_bonus'){
                $welcomeBonusCount =  $user->offers()->where('offer_type', 'welcome_bonus')->count();
                if($welcomeBonusCount == 0){
                    $deposit = $user->deposits()->where('status', 'completed')->first();
                    if($deposit && $deposit->amount >= $offer->min_price  && $deposit->amount <= $offer->max_price){
                        $amount = $offer->reward_price;
                        if($offer->reward_type == "P"){
                            $amount = ($deposit->amount * $offer->reward_price) / 100;
                        }
                        $user->offers()->attach($offer->id, ['price' => $amount]);
                        $user->updateWallet($amount, 'Welcome Reward', true);
                        $offer->qty_sold = $offer->qty_sold + 1;
                        $offer->save();
                    }
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
