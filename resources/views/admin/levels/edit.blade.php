@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        
        @foreach ($errors->all() as $error)
        <div class="text-red-500">{{ $error }}</div>
    @endforeach
        <form action="{{ route('admin.levels.update', $level->id) }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-2 md:p-4 items-end">
                <div>
                    <h3 class="p-1">Name</h3>
                    <input type="text" placeholder="Name" name="name" value="{{ $level->name }}" class="border p-1 rounded-sm  w-80 ">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Description</h3>
                    <input type="text" placeholder="Description" name="description" value="{{ $level->description }}" class="border p-1 rounded-sm  w-80 ">
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Min Price</h3>
                    <input type="number" placeholder="Min Price" name="min_price" value="{{ $level->min_price }}" class="border p-1 rounded-sm  w-80 ">
                    @error('min_price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Max Price</h3>
                    <input type="number" placeholder="Max Price" name="max_price" value="{{ $level->max_price }}" class="border p-1 rounded-sm  w-80 ">
                    @error('max_price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Return Percentage</h3>
                    <input type="number" step="0.01" placeholder="Reward Price" name="return_percentage" value="{{ $level->return_percentage }}" class="border p-1 rounded-sm  w-80 ">
                    @error('return_percentage')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <h3 class="p-1">Status</h3>
                    <select name="active" id="" class="border p-1 rounded-sm  w-80">
                        <option value="1" @if($level->active == 1)  selected @endif>Yes</option>
                        <option value="0" @if($level->active == 0)  selected @endif>No</option>
                    </select>
                    @error('is_featured')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Send
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
