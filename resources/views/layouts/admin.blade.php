<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Coin Exminning - Admin</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet'>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    @yield('header')
</head>

<body class="bg-gray-50">
    @php
        $page = Route::currentRouteName();
    @endphp
    <!-- Header -->
    <header class="header">
        <div class="container mx-auto px-4">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <button class='lg:hidden hover:cursor-pointer text-gray-700 hover:text-gray-900 transition-colors'
                        onclick="toggleSidebar()">
                        <i class="bi bi-list text-[28px]"></i>
                    </button>
                    <img src="{{ asset('/images/logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-lg object-cover">
                    <span class="hidden sm:block text-lg font-semibold text-gray-800">Admin Panel</span>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 hover:bg-gray-100 rounded-full transition-colors">
                        <i class="bi bi-bell text-xl text-gray-600"></i>
                        <span class="absolute top-1 right-1 h-2 w-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div
                        class="flex justify-center items-center w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-green-600 text-white font-medium shadow-md">
                        <i class="bi-person text-lg"></i>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside aria-label="Sidebar" id='sidebar' class="sidebar">
        <!-- Mobile Close Button -->
        <div class="absolute top-3 right-3 hover:cursor-pointer lg:hidden text-white z-50" onclick="toggleSidebar()">
            <i class="bi bi-x text-[32px]"></i>
        </div>

        <!-- Mobile Logo -->
        <div class="flex justify-center items-center py-8 lg:hidden border-b border-green-700">
            <img src="{{ asset('/images/logo.jpg') }}" alt="Logo" class="w-16 h-16 rounded-lg">
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-8 px-4">
            <ul class="flex flex-col space-y-2">
                <li @if ($page == 'home') class="active" @endif>
                    <a href="{{ url('dashboard/') }}" class="nav-link">
                        <i class="bi-grid text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li @if (str_contains($page, 'admin.users')) class="active" @endif>
                    <a href="{{ route('admin.users.index') }}" class="nav-link">
                        <i class="bi-people text-lg"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li @if (str_contains($page, 'admin.levels')) class="active" @endif>
                    <a href="{{ route('admin.levels.index') }}" class="nav-link">
                        <i class="bi-bar-chart text-lg"></i>
                        <span>Levels</span>
                    </a>
                </li>
                <li @if (str_contains($page, 'admin.withdrawls')) class="active" @endif>
                    <a href="{{ route('admin.withdrawls.index') }}" class="nav-link">
                        <i class="bi-wallet2 text-lg"></i>
                        <span>Withdrawals</span>
                    </a>
                </li>
                <li @if (str_contains($page, 'admin.offers')) class="active" @endif>
                    <a href="{{ route('admin.offers.index') }}" class="nav-link">
                        <i class="bi-gift text-lg"></i>
                        <span>Offers</span>
                    </a>
                </li>
                <li class="pt-4 mt-4 border-t border-green-700">
                    <form action="{{ route('logout') }}" method="post" class="w-full">
                        @csrf
                        <button type="submit" class="nav-link w-full text-left">
                            <i class="bi-box-arrow-right text-lg"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="responsive-body">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            @yield('content')
        </div>
    </main>

    @yield('script')

    <script type="module">
        @if (Session::has('alert'))
            Swal.fire(
                "Message Alert",
                "{{ Session::get('message') }}",
                "{{ Session::get('alert') ? 'success' : 'error' }}"
            )
        @endif
    </script>

    <script>
        function toggleSidebar() {
            $("#sidebar").toggleClass("mobile");
        }

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const isClickInside = sidebar.contains(event.target) || event.target.closest(
                '[onclick*="toggleSidebar"]');

            if (!isClickInside && sidebar.classList.contains('mobile') && window.innerWidth < 1024) {
                sidebar.classList.remove('mobile');
            }
        });
    </script>
</body>

</html>
