<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    @stack('styles')
    <style>
        .animate-gradient {
            background: linear-gradient(270deg, #1e3a8a, #1e40af, #1d4ed8);
            background-size: 600% 600%;
            animation: gradientAnimation 8s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50% }
            50% { background-position: 100% 50% }
            100% { background-position: 0% 50% }
        }

        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 50%;
            background: #60a5fa;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .nav-item.active::after {
            width: 100%;
            background: #3b82f6;
        }

        .dropdown-animation {
            animation: dropdownSlide 0.3s ease-out;
            transform-origin: top;
        }

        @keyframes dropdownSlide {
            0% {
                transform: scaleY(0);
                opacity: 0;
            }
            100% {
                transform: scaleY(1);
                opacity: 1;
            }
        }

        .page-transition {
            animation: pageTransition 0.5s ease-out;
        }

        @keyframes pageTransition {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-900 text-white">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="animate-gradient">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white flex items-center space-x-2">
                                <i class="fas fa-graduation-cap"></i>
                                <span>TestSystem</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:ml-10 sm:flex">
                            <a href="{{ route('dashboard') }}" 
                               class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }} text-white px-3 py-2 rounded-md text-sm font-medium hover:text-blue-200 flex items-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span>{{ __('Bosh sahifa') }}</span>
                            </a>
                            
                            <a href="{{ route('tests.index') }}"
                               class="nav-item {{ request()->routeIs('tests.*') ? 'active' : '' }} text-white px-3 py-2 rounded-md text-sm font-medium hover:text-blue-200 flex items-center space-x-2">
                                <i class="fas fa-clipboard-list"></i>
                                <span>{{ __('Testlar') }}</span>
                            </a>
                            
                            <a href="{{ route('tests.results') }}"
                               class="nav-item {{ request()->routeIs('tests.results') ? 'active' : '' }} text-white px-3 py-2 rounded-md text-sm font-medium hover:text-blue-200 flex items-center space-x-2">
                                <i class="fas fa-chart-bar"></i>
                                <span>{{ __('Natijalar') }}</span>
                            </a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-blue-200 focus:outline-none transition duration-150 ease-in-out">
                                <img class="h-8 w-8 rounded-full object-cover border-2 border-blue-400" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                     alt="{{ Auth::user()->name }}">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="dropdown-animation absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-gray-800 ring-1 ring-black ring-opacity-5">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ __('Profile') }}
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 hover:bg-blue-900 focus:outline-none">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-gray-800">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-200 hover:bg-blue-900">
                        <i class="fas fa-home mr-2"></i>
                        {{ __('Dashboard') }}
                    </a>
                    
                    <a href="{{ route('tests.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-200 hover:bg-blue-900">
                        <i class="fas fa-clipboard-list mr-2"></i>
                        {{ __('Tests') }}
                    </a>
                    
                    <a href="{{ route('tests.results') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-200 hover:bg-blue-900">
                        <i class="fas fa-chart-bar mr-2"></i>
                        {{ __('Results') }}
                    </a>
                </div>

                <div class="pt-4 pb-3 border-t border-gray-700">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" 
                                 src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF" 
                                 alt="{{ Auth::user()->name }}">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-200 hover:bg-blue-900">
                            <i class="fas fa-user mr-2"></i>
                            {{ __('Profile') }}
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-white hover:text-blue-200 hover:bg-blue-900">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                {{ __('Log Out') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="page-transition">
            @yield('content')
        </main>
    </div>

    <!-- Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html>
