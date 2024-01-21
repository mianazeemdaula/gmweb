<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offer;
use Illuminate\Support\Str;
class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offers = Offer::orderBy('id', 'desc')->paginate();
        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'offer_type' => 'required',
            'reward_type' => 'required',
            'reward_price' => 'required',
            'min_price' => 'required',
            'max_price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'qty' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $image = '';
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/offers');
            $image->move($destinationPath, $name);
            $image = $name;
        }
        $offer = new Offer();
        $offer->name = $request->name;
        $offer->description = $request->description;
        $offer->offer_type = $request->offer_type;
        $offer->reward_price = $request->reward_price;
        $offer->reward_type = $request->reward_type;
        $offer->min_price = $request->min_price;
        $offer->max_price = $request->max_price;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->qty = $request->qty;
        $offer->image = $image;
        $offer->code = strtoupper(Str::random(10));
        $offer->save();
        return redirect()->route('admin.offers.index')->with('success', 'Offer created successfully');
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
        $offer = Offer::findOrFail($id);
        return view('admin.offers.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'offer_type' => 'required',
            'reward_type' => 'required',
            'reward_price' => 'required',
            'min_price' => 'required',
            'max_price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'qty' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $offer = Offer::findOrFail($id);
        $image = $offer->image;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension(); 
            $destinationPath = public_path('/offers');
            $image->move($destinationPath, $name);
            $image = $name;
        }
        $offer->name = $request->name;
        $offer->description = $request->description;
        $offer->offer_type = $request->offer_type;
        $offer->reward_price = $request->reward_price;
        $offer->reward_type = $request->reward_type;
        $offer->min_price = $request->min_price;
        $offer->max_price = $request->max_price;
        $offer->start_date = $request->start_date;
        $offer->end_date = $request->end_date;
        $offer->qty = $request->qty;
        $offer->image = $image;
        $offer->save();
        return redirect()->route('admin.offers.index')->with('success', 'Offer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
