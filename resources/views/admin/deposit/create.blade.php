@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        
        {{-- @foreach ($errors->all() as $error)
            <div class="text-red-500">{{ $error }}</div>
        @endforeach --}}
        <form action="{{ route('admin.users.deposit.store',$userId) }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-2 md:p-4 items-end">
                <div>
                    <h3 class="p-1">Amount</h3>
                    <input type="number" placeholder="Amount" name="amount" value="{{ old('amount') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('amount')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Deposit Money
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
