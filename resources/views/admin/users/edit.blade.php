@extends('layouts.admin')
@section('content')
    <div class="bg-white rounded-lg">
        @foreach ($errors->all() as $error)
            <div class="text-red-500">{{ $error }}</div>
        @endforeach
        <form action="{{ route('admin.users.update', $user->id) }}" method="post" class="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-2 md:p-4 items-end">
                <div>
                    <h3 class="p-1">Name</h3>
                    <input type="text" placeholder="Name" name="name" value="{{ $user->name }}" class="border p-1 rounded-sm  w-80 ">
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <h3 class="p-1">Level</h3>
                    <select name="level" id="" class="border p-1 rounded-sm  w-80">
                        @foreach ($levels as $item)
                        <option value="{{$item->id}}" @if($item->id == $user->lavel_id)  selected @endif>{{ $item->name}}</option>
                            
                        @endforeach
                    </select>
                    @error('level')
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
