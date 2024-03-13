<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deposit;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $deposits = Deposit::where('user_id', $id)->orderBy('id', 'desc')->paginate();
        return view('admin.deposit.index', compact('deposits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($userId)
    {
        return view('admin.deposit.create',compact('userId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $userId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);
        $deposit = new Deposit();
        $deposit->user_id = $userId;
        $deposit->payment_method_id = 1;
        $deposit->amount =  $request->amount;
        $deposit->tx_id = Str::random(10);
        $deposit->status = 'completed';
        $deposit->description = 'Deposit from Crypto';
        $deposit->save();
        \App\Jobs\CheckOfferWinJob::dispatch($userId);
        return redirect()->route('admin.users.deposit.index', $userId)->with('success', 'Deposit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($userId,string $id)
    {
        $wallet = Wallet::findOrFail($id);
        return view('admin.wallet.edit', compact('wallet', 'userId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$userId, string $id)
    {
        $request->validate([
            'description' => 'required',
            'debit' => 'required',
            'credit' => 'required',
            'balance' => 'required',
        ]);
        $wallet = Wallet::findOrFail($id);
        $wallet->description = $request->description;
        $wallet->debit = $request->debit;
        $wallet->credit = $request->credit;
        $wallet->balance = $request->balance;
        $wallet->save();
        return redirect()->route('admin.users.wallet.index',$userId)->with('success', 'Wallet updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
