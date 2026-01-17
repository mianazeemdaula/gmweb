@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Offers</h1>
                <p class="mt-1 text-sm text-gray-500">Manage promotional offers and rewards</p>
            </div>
            <a href="{{ route('admin.offers.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i>
                Add Offer
            </a>
        </div>

        <!-- Offers Table Card -->
        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Price Range</th>
                            <th>Reward</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offers as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->id }}</td>
                                <td class="font-semibold text-gray-800">{{ $item->name }}</td>
                                <td>
                                    <code class="px-2 py-1 bg-gray-100 rounded text-xs font-mono">{{ $item->code }}</code>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($item->offer_type) }}</span>
                                </td>
                                <td class="text-sm text-gray-700">
                                    ${{ number_format($item->min_price, 0) }} - ${{ number_format($item->max_price, 0) }}
                                </td>
                                <td class="font-semibold text-green-600">
                                    @if ($item->reward_type == 'P')
                                        {{ $item->reward_price }}%
                                    @else
                                        ${{ number_format($item->reward_price, 2) }}
                                    @endif
                                </td>
                                <td class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->end_date)->diffForHumans() }}
                                </td>
                                <td>
                                    @if ($item->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.offers.show', $item->id) }}" title="View">
                                            <i class="bi bi-eye action-icon"></i>
                                        </a>
                                        <a href="{{ route('admin.offers.edit', $item->id) }}" title="Edit">
                                            <i class="bi bi-pencil action-icon"></i>
                                        </a>
                                        <form action="{{ route('admin.offers.destroy', $item->id) }}" method="post"
                                            class="inline">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="bi bi-trash action-icon-danger"></i>
                                            </button>
                                        </form>
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
            <x-web-pagination :paginator="$offers" />
        </div>
    </div>
@endsection
