@extends('layouts.admin')
@section('content')
    <div class="w-full space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Levels</h1>
                <p class="mt-1 text-sm text-gray-500">Manage investment levels and packages</p>
            </div>
            <a href="{{ route('admin.levels.create') }}" class="btn-primary">
                <i class="bi bi-plus-lg mr-2"></i>
                Add Level
            </a>
        </div>

        <!-- Levels Table Card -->
        <div class="card">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Min Price</th>
                            <th>Max Price</th>
                            <th>Return %</th>
                            <th>Last Update</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($levels as $item)
                            <tr>
                                <td class="font-medium text-gray-900">{{ $item->id }}</td>
                                <td class="font-semibold text-gray-800">{{ $item->name }}</td>
                                <td class="font-medium text-gray-700">${{ number_format($item->min_price, 2) }}</td>
                                <td class="font-medium text-gray-700">${{ number_format($item->max_price, 2) }}</td>
                                <td>
                                    <span class="badge badge-success">{{ $item->return_percentage }}%</span>
                                </td>
                                <td class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}
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
                                        <a href="{{ route('admin.levels.show', $item->id) }}" title="View">
                                            <i class="bi bi-eye action-icon"></i>
                                        </a>
                                        <a href="{{ route('admin.levels.edit', $item->id) }}" title="Edit">
                                            <i class="bi bi-pencil action-icon"></i>
                                        </a>
                                        <form action="{{ route('admin.levels.destroy', $item->id) }}" method="post"
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
            <x-web-pagination :paginator="$levels" />
        </div>
    </div>
@endsection
