<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'ShopKu') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e16c014aae.js" crossorigin="anonymous"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100" x-data="{ sidebarOpen: true }">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="sidebar" :class="{ 'w-64': sidebarOpen, 'w-20': !sidebarOpen }">
            <!-- Brand -->
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-store text-white"></i>
                    </div>
                    <span class="sidebar-brand" x-show="sidebarOpen">Dashboard Admin</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-gauge"></i>
                    <span x-show="sidebarOpen">Dashboard</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" 
                   class="{{ request()->routeIs('admin.categories.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-layer-group"></i>
                    <span x-show="sidebarOpen">Categories</span>
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="{{ request()->routeIs('admin.products.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-box"></i>
                    <span x-show="sidebarOpen">Products</span>
                </a>
                <a href="{{ route('admin.shipping-options.index') }}" 
                   class="{{ request()->routeIs('admin.shipping-options.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
                    <i class="fa-solid fa-truck"></i>
                    <span x-show="sidebarOpen">Shipping Options</span>
                </a>
                <div class="border-t border-slate-700 my-4 mx-4"></div>
                
                <a href="{{ route('product.index') }}" class="sidebar-link">
                    <i class="fa-solid fa-store"></i>
                    <span x-show="sidebarOpen">View Store</span>
                </a>
            </nav>

            <!-- User Section -->
            <div class="p-4 border-t border-slate-700">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-user text-slate-300"></i>
                    </div>
                    <div x-show="sidebarOpen">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-red-400 hover:bg-red-900/30 hover:text-red-300 transition-colors text-sm">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>
                        <span x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 transition-all duration-300">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-500">{{ now()->format('l, d M Y') }}</span>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
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
                </div>

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>