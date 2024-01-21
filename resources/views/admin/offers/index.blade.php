@extends('layouts.admin')
@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between">
            <h5 class="">Offers</h5>
            <a href="{{ route('admin.offers.create') }}">
                <div class="px-4 bg-green-700 text-white rounded-xl">
                    Add Offer
                </div>
            </a>
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
                                Name</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Code</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reward</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Expire On</th>
                                <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Active</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 " id="chatlist">
                        @foreach ($offers as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->code }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->offer_type }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    ${{ $item->min_price }} - ${{ $item->max_price }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    @if ($item->reward_type == 'P')
                                        {{ $item->reward_price }}%
                                    @else
                                        ${{ $item->reward_price }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->end_date)->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500">
                                    {{ $item->active ? 'Active' : 'inactive' }}
                                </td>
                                <td>
                                    <div class="flex space-x-3">

                                        <a href="{{ route('admin.offers.show', $item->id) }}">
                                            <span class="bi bi-eye"></span>
                                        </a>
                                        <a href="{{ route('admin.offers.edit', $item->id) }}">
                                            <span class="bi bi-pencil"></span>
                                        </a>
                                        <form action="{{ route('admin.offers.destroy', $item->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"><span class="bi bi-trash"></span></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            <x-web-pagination :paginator="$offers" />
        </div>
    </div>
@endsection
