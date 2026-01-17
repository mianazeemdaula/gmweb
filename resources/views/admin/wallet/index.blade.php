@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Wallet Transactions</h1>
                <p class="mt-1 text-sm text-gray-500">View user wallet history</p>
            </div>
            <a href="{{ url("admin/users-wallet-recalulate/$id") }}" class="btn-primary">
                <i class="bi bi-arrow-repeat mr-2"></i>
                Recalculate Balance
            </a>
        </div>

        <!-- Wallet Table Card -->
        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wallet as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->id }}</td>
                                <td class="text-gray-700">{{ $item->description }}</td>
                                <td>
                                    @if ($item->debit > 0)
                                        <span
                                            class="font-semibold text-red-600">-\${{ number_format($item->debit, 2) }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->credit > 0)
                                        <span
                                            class="font-semibold text-green-600">+\${{ number_format($item->credit, 2) }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="font-bold text-gray-900">\${{ number_format($item->balance, 2) }}</td>
                                <td class="text-xs text-gray-500">
                                    {{ $item->updated_at->format('M d, Y H:i') }}
                                </td>
                                <td>
                                    @if ($item->is_bonus)
                                        <span class="badge badge-warning">Bonus</span>
                                    @else
                                        <span class="badge badge-info">Regular</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.wallet.edit', [$item->user_id, $item->id]) }}"
                                        title="Edit">
                                        <i class="bi bi-pencil action-icon"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            <x-web-pagination :paginator="$wallet" />
        </div>
    </div>
@endsection
