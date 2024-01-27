@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        
        @foreach ($errors->all() as $error)
        <div class="text-red-500">{{ $error }}</div>
    @endforeach
        <form action="{{ route('admin.users.wallet.update', [$wallet->user_id,$wallet->id]) }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-2 md:p-4 items-end">
                <div>
                    <h3 class="p-1">Description</h3>
                    <input type="text" placeholder="Description" name="description" value="{{ $wallet->description }}" class="border p-1 rounded-sm  w-80 ">
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Debit</h3>
                    <input step="any" type="number" placeholder="Debit" name="debit" value="{{ $wallet->debit }}" class="border p-1 rounded-sm  w-80 ">
                    @error('debit')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Credit</h3>
                    <input step="any" type="number" placeholder="Credit" name="credit" value="{{ $wallet->credit }}" class="border p-1 rounded-sm  w-80 ">
                    @error('credit')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Balance</h3>
                    <input type="number" step="any" placeholder="Balance" name="balance" value="{{ $wallet->balance }}" class="border p-1 rounded-sm  w-80 ">
                    @error('balance')
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
