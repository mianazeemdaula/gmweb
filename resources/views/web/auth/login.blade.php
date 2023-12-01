@extends('layouts.web')
@section('content')
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="scale-100 m-16 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <div class="">
                    <div class="flex justify-center">
                        <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="email" class="text-sm font-medium text-gray-600">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="mt-1 p-2 block w-full rounded-md bg-gray-100 dark:bg-gray-800/50 border-transparent focus:border-red-500 focus:bg-white focus:ring-0"
                            placeholder="you@example.com"
                          />
                        @error('email')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
    
                    <div class="mt-2">
                        <label for="password" class="text-sm font-medium text-gray-600">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="mt-1 p-2 block w-full rounded-md bg-gray-100 dark:bg-gray-800/50 border-transparent focus:border-red-500 focus:bg-white focus:ring-0"
                            placeholder="*********"
                          />
                        @error('password')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                    </div>
    
                   <div class="flex space-x-2 justify-center items-center">
                        <input type="checkbox" name="remember" id="">
                        <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                            I accept terms & conditions and privacy policy.
                        </p>
                   </div>
                    <div class="mt-4">
                        <button type="submit" class="btn-blue  w-full block">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection