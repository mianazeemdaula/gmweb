@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        @foreach ($errors->all() as $error)
        <div class="text-red-500">{{ $error }}</div>
    @endforeach
        <form action="{{ url('admin/nowpayment/payoutverify') }}" method="post" class="" enctype="multipart/form-data">
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
                    <h3 class="p-1">Batch ID</h3>
                    <input type="text" placeholder="Batch ID" name="batch" value="{{ old('batch') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('batch')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Mail Code</h3>
                    <input type="text" placeholder="mail_code" name="mail_code" value="{{ old('mail_code') }}" class="border p-1 rounded-sm  w-80 ">
                    @error('mail_code')
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
