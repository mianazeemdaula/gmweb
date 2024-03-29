@extends('layouts.admin')
@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between">
            <h5 class="">Withdrawls</h5>
            <div>
                <a href="{{ route('admin.withdrawls.create') }}" class="btn-blue">Create</a>
            </div>
        </div>
        <div class="bg-white">
            <div class="overflow-x-auto mt-6 ">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                User</th>
                                <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Account</th>
                                <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount</th>
                                <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount to Send</th>
                                <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Coin</th>
                                <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date/Time</th>
                            <th scope="col"
                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 " id="chatlist">
                        @foreach ($withdrawls as $item)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->id }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->user->name }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->account }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->amount }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->amount - ($item->amount * 0.10) }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->coin }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->status}}
                                </td>
                                <td>
                                    <div class="flex space-x-3">
                                        @if($item->status == 'pending')
                                            <form action="{{ route('admin.withdrawls.update', $item->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit"><span class="bi bi-check-circle"></span></button>
                                            </form>
                                            <form action="{{ route('admin.withdrawls.update', $item->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit"><span class="bi bi-x-circle"></span></button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            <x-web-pagination :paginator="$withdrawls" />
        </div>
    </div>
@endsection
