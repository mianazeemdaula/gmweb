@extends('layouts.admin')
@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between">
            <h5 class="">Deposits</h5>
        </div>
        <div class="bg-white">
            <div class="overflow-x-auto mt-6 ">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 " id="chatlist">
                        @foreach ($deposits as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->amount }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->status }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->updated_at }}
                                </td>
                                <td>
                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.users.deposit.edit',[$item->user_id, $item->id]) }}">
                                            <span class="bi bi-pencil"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            <x-web-pagination :paginator="$deposits" />
        </div>
    </div>
@endsection
