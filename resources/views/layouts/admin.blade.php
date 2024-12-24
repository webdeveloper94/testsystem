<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Admin Panel' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Custom Admin Styles -->
    <style>
        .admin-bg { background-color: #1a237e; }
        .admin-sidebar { background-color: #0d1442; transition: all 0.3s ease; }
        .admin-content { background-color: #f3f4f6; }
        .nav-link { transition: all 0.3s ease; }
        .nav-link:hover { background-color: #283593; transform: translateX(10px); }
        .stats-card { background: linear-gradient(45deg, #1a237e, #283593); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="fixed left-0 top-0 h-full w-64 admin-sidebar text-white p-4">
            <div class="flex items-center justify-center mb-8">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center p-3 rounded-lg mb-2 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-home w-6"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.tests.index') }}" class="nav-link flex items-center p-3 rounded-lg mb-2 {{ request()->routeIs('admin.tests.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-clipboard-list w-6"></i>
                    <span>Tests</span>
                </a>
                
                <a href="{{ route('admin.users.index') }}" class="nav-link flex items-center p-3 rounded-lg mb-2 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-users w-6"></i>
                    <span>Users</span>
                </a>
                
                <a href="{{ route('admin.results.index') }}" class="nav-link flex items-center p-3 rounded-lg mb-2 {{ request()->routeIs('admin.results.*') ? 'bg-indigo-700' : '' }}">
                    <i class="fas fa-chart-bar w-6"></i>
                    <span>Results</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <span class="text-xl font-bold text-indigo-900">{{ $title ?? 'Dashboard' }}</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="ml-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none transition duration-150 ease-in-out">
                                            <div>{{ Auth::user()->name }}</div>

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
