@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        
        @foreach ($errors->all() as $error)
        <div class="text-red-500">{{ $error }}</div>
    @endforeach
        <form action="{{ route('admin.offers.store') }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-2 md:p-4 items-end">
                <div>
                    <h3 class="p-1">Name</h3>
                    <input type="text" placeholder="Name" name="name" value="{{ old('name') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Description</h3>
                    <input type="text" placeholder="Description" name="description" value="{{ old('description') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Offer Type</h3>
                    <select name="offer_type" id="" class="border p-1 rounded-sm  w-80">
                        <option value="first_deposit">First Deposit</option>
                        <option value="welcome_bonus">Welcome Bonus</option>
                    </select>
                    @error('offer_type')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Min Price</h3>
                    <input type="number" placeholder="Min Price" name="min_price" value="{{ old('min_price') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('min_price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Max Price</h3>
                    <input type="number" placeholder="Max Price" name="max_price" value="{{ old('max_price') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('max_price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Reward Price</h3>
                    <input type="number" step="0.01" placeholder="Reward Price" name="reward_price" value="{{ old('reward_price') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('reward_price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <h3 class="p-1">Reward Type</h3>
                    <select name="reward_type" id="" class="border p-1 rounded-sm  w-80">
                        <option value="P">Percent</option>
                        <option value="F">Fixed</option>
                    </select>
                    @error('offer_type')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Start Date</h3>
                    <input type="date" placeholder="Start Date" name="start_date" value="{{ old('start_date') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('start_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">End Date</h3>
                    <input type="date" placeholder="End Date" name="end_date" value="{{ old('end_date') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('end_date')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <h3 class="p-1">Qty</h3>
                    <input type="number" placeholder="Quantity" name="qty" value="{{ old('qty') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('qty')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Is Featured</h3>
                    <select name="is_featured" id="" class="border p-1 rounded-sm  w-80">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    @error('is_featured')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Image</h3>
                    <input type="file" placeholder="Ad Image" name="image" value="{{ old('image') }}" class="w-80">
                    @error('image')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Send
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
