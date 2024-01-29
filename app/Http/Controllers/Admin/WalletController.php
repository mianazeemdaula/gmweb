<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $wallet = Wallet::where('user_id', $id)->orderBy('id', 'desc')->paginate();
        return view('admin.wallet.index', compact('wallet', 'id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'return_percentage' => 'required',
            'min_price' => 'required',
            'max_price' => 'required',
            'active' => 'required',
        ]);
        $level = new Level();
        $level->name = $request->name;
        $level->description = $request->description;
        $level->return_percentage = $request->return_percentage;
        $level->min_price = $request->min_price;
        $level->max_price = $request->max_price;
        $level->active = $request->active;
        $level->save();
        return redirect()->route('admin.levels.index')->with('success', 'Level created successfully');
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

    public function recalculate($id){
        $transactions = Wallet::where('user_id', $id)->orderBy('id', 'asc')->get();
        $balance = 0;
        foreach($transactions as $transaction){
            $balance += $transaction->credit;
            $balance -= $transaction->debit;
            $transaction->balance = $balance;
            $transaction->save();
        }
        return redirect()->route('admin.users.wallet.index',$id)->with('success', 'Wallet recalculated successfully');
    }
}
