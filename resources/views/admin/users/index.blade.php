@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Users</h1>
                <p class="mt-1 text-sm text-gray-500">Manage all registered users</p>
            </div>
        </div>

        <!-- Users Table Card -->
        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Referral</th>
                            <th>Level</th>
                            <th>Deposit</th>
                            <th>Joined</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->id }}</td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white font-medium text-xs">
                                            {{ strtoupper(substr($item->name, 0, 2)) }}
                                        </div>
                                        <span class="font-medium">{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td class="font-mono text-xs">{{ $item->tag }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $item->level->name }}</span>
                                </td>
                                <td class="font-semibold text-green-600">
                                    ${{ number_format($item->deposits()->sum('amount'), 2) }}</td>
                                <td class="text-xs text-gray-500">{{ $item->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if ($item->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.users.show', $item->id) }}" title="View Details">
                                            <i class="bi bi-eye action-icon"></i>
                                        </a>
                                        <a href="{{ route('admin.users.wallet.index', $item->id) }}" title="Wallet">
                                            <i class="bi bi-wallet2 action-icon"></i>
                                        </a>
                                        <a href="{{ route('admin.users.deposit.index', $item->id) }}" title="Deposits">
                                            <i class="bi bi-cash-stack action-icon"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <x-web-pagination :paginator="$users" />
        </div>
    </div>
@endsection
