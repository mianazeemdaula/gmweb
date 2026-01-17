@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Withdrawals</h1>
                <p class="mt-1 text-sm text-gray-500">Manage user withdrawal requests</p>
            </div>
            <a href="{{ route('admin.withdrawls.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i>
                Create Withdrawal
            </a>
        </div>

        <!-- Withdrawals Table Card -->
        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Account</th>
                            <th>Amount</th>
                            <th>To Send</th>
                            <th>Coin</th>
                            <th>Date/Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($withdrawls as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->id }}</td>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="font-medium text-gray-800">{{ $item->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $item->user->email }}</span>
                                    </div>
                                </td>
                                <td class="font-mono text-xs max-w-xs truncate" title="{{ $item->account }}">
                                    {{ $item->account }}
                                </td>
                                <td class="font-semibold text-gray-800">\${{ number_format($item->amount, 2) }}</td>
                                <td class="font-semibold text-green-600">
                                    \${{ number_format($item->amount - $item->amount * 0.1, 2) }}
                                    <span class="text-xs text-gray-500">(10% fee)</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ strtoupper($item->coin) }}</span>
                                </td>
                                <td class="text-xs text-gray-500">
                                    {{ $item->created_at->format('M d, Y H:i') }}
                                </td>
                                <td>
                                    @if ($item->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($item->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @else
                                        <span class="badge badge-danger">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center space-x-2">
                                        @if ($item->status == 'pending')
                                            <form action="{{ route('admin.withdrawls.update', $item->id) }}" method="post"
                                                class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" title="Approve"
                                                    onclick="return confirm('Approve this withdrawal?')">
                                                    <i class="bi bi-check-circle action-icon-success"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.withdrawls.update', $item->id) }}" method="post"
                                                class="inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit" title="Cancel"
                                                    onclick="return confirm('Cancel this withdrawal?')">
                                                    <i class="bi bi-x-circle action-icon-danger"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">No actions</span>
                                        @endif
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
            <x-web-pagination :paginator="$withdrawls" />
        </div>
    </div>
@endsection
