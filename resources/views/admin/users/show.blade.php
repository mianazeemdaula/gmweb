@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex items-center space-x-4 mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900">
                <i class="bi bi-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
                <p class="mt-1 text-sm text-gray-500">View user information and referrals</p>
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="card">
            <div class="card-body">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Avatar -->
                    <div class="flex justify-center lg:justify-start">
                        <div class="relative">
                            <img src="{{ $user->image }}" alt="User Avatar"
                                class="w-32 h-32 rounded-full object-cover border-4 border-green-100 shadow-lg">
                            <div
                                class="absolute bottom-0 right-0 h-8 w-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                <i class="bi bi-check text-white text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="space-y-3">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Name</label>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Email</label>
                            <p class="text-sm text-gray-700">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Phone</label>
                            <p class="text-sm text-gray-700">{{ $user->phone }}</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase">Referral Code</label>
                            <code class="px-2 py-1 bg-gray-100 rounded text-sm font-mono">{{ $user->tag }}</code>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4">
                            <p class="text-xs font-semibold text-green-700 uppercase">Deposits</p>
                            <p class="text-2xl font-bold text-green-600">
                                ${{ number_format($user->deposits->sum('amount'), 2) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
                            <p class="text-xs font-semibold text-blue-700 uppercase">Wallet</p>
                            <p class="text-2xl font-bold text-blue-600">
                                ${{ number_format($user->wallet->balance ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4">
                            <p class="text-xs font-semibold text-purple-700 uppercase">Withdrawals</p>
                            <p class="text-2xl font-bold text-purple-600">
                                ${{ number_format($user->withdrawls->sum('amount'), 2) }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4">
                            <p class="text-xs font-semibold text-orange-700 uppercase">Referrals</p>
                            <p class="text-2xl font-bold text-orange-600">{{ $user->referrals->count() }}</p>
                        </div>
                        <div class="col-span-2 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-4">
                            <p class="text-xs font-semibold text-gray-700 uppercase">Level</p>
                            <p class="text-xl font-bold text-gray-800">{{ $user->level->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referrals Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-lg font-semibold text-gray-900">Referrals</h3>
                <span class="badge badge-info">{{ $user->referrals->count() }} Total</span>
            </div>
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Deposits</th>
                            <th>Withdrawals</th>
                            <th>Referrals</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->referrals as $referal)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $referal->name }}</td>
                                <td class="text-gray-700">{{ $referal->email }}</td>
                                <td class="font-semibold text-green-600">
                                    ${{ number_format($referal->deposits->sum('amount'), 2) }}</td>
                                <td class="font-semibold text-purple-600">
                                    ${{ number_format($referal->withdrawls->sum('amount'), 2) }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $referal->referrals->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $referal->id) }}" class="action-icon"
                                        title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    <i class="bi bi-inbox text-4xl mb-2"></i>
                                    <p>No referrals found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
