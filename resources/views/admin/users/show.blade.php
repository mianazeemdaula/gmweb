@extends('layouts.admin')
@section('content')
    <div class="w-full bg-white p-6 rounded-sm">
        <div class="flex items-center justify-between">
            <img src="{{ $user->image }}" alt="User Avatar" srcset="" class="w-40 h-40">
            <div>
                <div>{{ $user->name }}</div>
                <div>{{ $user->email }}</div>
                <div>{{ $user->phone }}</div>
                <div>{{ $user->tag }}</div>
            </div>
            <div>
                <div>Deposits: {{ $user->deposits->sum('amount') }}</div>
                <div>Wallet: {{ $user->wallet->balance ?? 0 }}</div>
                <div>Withdrawls: {{ $user->withdrawls->sum('amount') }}</div>
                <div>Referrals: {{ $user->referrals->count() }}</div>
                <div>Level: {{ $user->level->name }}</div>
            </div>
        </div>

        <table class="w-full divide-y divide-gray-200  mt-4">
            <thead class="bg-gray-50 p-2">
                <tr class="text-left">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Deposits</th>
                    <th>Withdrawls</th>
                    <th>Referrals</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach ($user->referrals as $referal)
                    <tr class="">
                        <td>{{ $referal->name }}</td>
                        <td>{{ $referal->email }}</td>
                        <td>{{ $referal->deposits->sum('amount') }}</td>
                        <td>{{ $referal->withdrawls->sum('amount') }}</td>
                        <td>{{ $referal->referrals->count() }}</td>
                        <td><a href="{{ route('admin.users.show', $referal->id) }}"><span class="bi bi-eye"></span></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
