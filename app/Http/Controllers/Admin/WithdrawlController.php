<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawl;

class WithdrawlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdrawls = Withdrawl::orderBy('id','desc')->paginate();
        return view('admin.withdrawls.index', compact('withdrawls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,canceled,completed',
        ]);

        $withdrawl = Withdrawl::find($id);
        $withdrawl->status = $request->status;
        $withdrawl->save();
        if($request->status == 'completed'){
            $amount = $withdrawl->amount;
            $withdrawl->user->updateWallet(-$amount , 'Withdrawl request completed');
        }
        return redirect()->back()->with('success', 'Withdrawl updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
