<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ShopKu') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e16c014aae.js" crossorigin="anonymous"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation -->
    <nav class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-store text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-slate-900">ShopKu</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('product.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        <i class="fa-solid fa-grid-2 mr-1.5"></i>Products
                    </a>

                    @auth
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative text-slate-600 hover:text-slate-900 transition-colors">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-medium">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">
                                <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center">
                                    <i class="fa-solid fa-user text-slate-600"></i>
                                </div>
                                <span>{{ auth()->user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="dropdown-menu">
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <i class="fa-solid fa-gauge mr-2"></i>Admin Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="fa-solid fa-user mr-2"></i>Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item-danger w-full text-left">
                                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="btn-outline btn-sm">
                            <i class="fa-solid fa-right-to-bracket mr-1.5"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary btn-sm">
                            Get Started
                        </a>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative text-slate-600 hover:text-slate-900 mr-4">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-primary-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-medium">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endauth
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-600 hover:text-slate-900">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="md:hidden border-t border-slate-200 bg-white">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('product.index') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100">
                    <i class="fa-solid fa-grid-2 mr-2"></i>Products
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100">
                            <i class="fa-solid fa-gauge mr-2"></i>Admin Dashboard
                        </a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100">
                        <i class="fa-solid fa-user mr-2"></i>Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-red-600 hover:bg-red-50">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Logout
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-primary-600 hover:bg-primary-50">
                        <i class="fa-solid fa-user-plus mr-2"></i>Register
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Toast Notifications -->
    <div class="toast-container">
        @if(session('success'))
            <x-toast type="success">
                <span class="toast-title">{{ session('success') }}</span>
            </x-toast>
        @endif
        @if(session('error'))
            <x-toast type="error">
                <span class="toast-title">{{ session('error') }}</span>
            </x-toast>
        @endif
        @if(session('warning'))
            <x-toast type="warning">
                <span class="toast-title">{{ session('warning') }}</span>
            </x-toast>
        @endif
        @if(session('info'))
            <x-toast type="info">
                <span class="toast-title">{{ session('info') }}</span>
            </x-toast>
        @endif
    </div>

    <!-- Main Content -->
    <main class="min-h-[calc(100vh-200px)]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-store text-white text-sm"></i>
                    </div>
                    <span class="font-bold text-slate-900">ShopKu</span>
                </div>
                <p class="text-sm text-slate-500">
                    &copy; {{ date('Y') }} ShopKu. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>