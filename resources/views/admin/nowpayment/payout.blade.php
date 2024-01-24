@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        @foreach ($errors->all() as $error)
        <div class="text-red-500">{{ $error }}</div>
    @endforeach
        <form action="{{ url('admin/nowpayment/payout') }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-2 md:p-4 items-end">
                <div>
                    <h3 class="p-1">Email</h3>
                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('email')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Password</h3>
                    <input type="password" placeholder="Password" name="password" value="{{ old('password') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('password')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Currency (Token)</h3>
                    <input type="text" placeholder="Token" name="currency" value="{{ old('currency') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('currency')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Amount</h3>
                    <input type="number" placeholder="Amount" name="amount" value="{{ old('amount') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('amount')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Address</h3>
                    <input type="text" step="0.01" placeholder="address" name="address" value="{{ old('address') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('address')
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
