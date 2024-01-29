@extends('layouts.admin')
@section('content')

<div>
    <div class="grid grid-cols-4 gap-3">
        <div class="bg-white rounded text-center">
            <div class="p-4">
                <div class="text-2xl font-bold text-green-500">{{ $userCount }}</div>
                <div class="text-sm text-gray-500">Total Users</div>
            </div>
        </div>
        <div class="bg-white rounded text-center">
            <div class="p-4">
                <div class="text-2xl font-bold text-green-500">{{ $userDepositCount }}</div>
                <div class="text-sm text-gray-500">Deposited Users</div>
            </div>
        </div>

        <div class="bg-white rounded text-center">
            <div class="p-4">
                <div class="text-2xl font-bold text-green-500">{{ $deposit }}</div>
                <div class="text-sm text-gray-500">Total Deposit</div>
            </div>
        </div>

        <div class="bg-white rounded text-center">
            <div class="p-4">
                <div class="text-2xl font-bold text-green-500">{{ $dailyCredit }}</div>
                <div class="text-sm text-gray-500">Total Credit</div>
            </div>
        </div>

        <div class="bg-white rounded text-center">
            <div class="p-4">
                <div class="text-2xl font-bold text-green-500">{{ $activeMinnners }}</div>
                <div class="text-sm text-gray-500">Active Minners</div>
            </div>
        </div>

        

        {{-- <div class="bg-white rounded text-center">
            <div class="p-4">
                <div class="text-2xl font-bold text-green-500">{{json_encode($balance) }}</div>
                <div class="text-sm text-gray-500">Balance Crypto</div>
            </div>
        </div> --}}
    </div>
</div>
    
@endsection