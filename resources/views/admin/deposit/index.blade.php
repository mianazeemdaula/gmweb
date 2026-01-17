@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Deposits</h1>
                <p class="mt-1 text-sm text-gray-500">User deposit transactions</p>
            </div>
        </div>

        <!-- Deposits Table Card -->
        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deposits as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->id }}</td>
                                <td class="text-gray-700">{{ $item->description }}</td>
                                <td class="font-semibold text-green-600">${{ number_format($item->amount, 2) }}</td>
                                <td>
                                    @if ($item->status == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($item->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-danger">{{ ucfirst($item->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-xs text-gray-500">
                                    {{ $item->updated_at->format('M d, Y H:i') }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.deposit.edit', [$item->user_id, $item->id]) }}"
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
            <x-web-pagination :paginator="$deposits" />
        </div>
    </div>
@endsection
