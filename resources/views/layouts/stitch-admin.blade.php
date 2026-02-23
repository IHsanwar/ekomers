<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&amp;family=Material+Icons+Round&amp;display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        
        // Initial check
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(255, 107, 0, 0.1) 0%, rgba(255, 107, 0, 0) 100%);
            border-left: 4px solid #FF6B00;
        }
        /* Stitch primary admin color */
        .text-primary-admin { color: #FF6B00; }
        .bg-primary-admin { background-color: #FF6B00; }
        .anime-gradient {
            background: linear-gradient(135deg, #FF6B00 0%, #FF8A00 100%);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-200">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-surface-light dark:bg-surface-dark border-r border-slate-200 dark:border-slate-800 flex flex-col hidden lg:flex">
            <div class="p-6">
                <img alt="Arkari Design Logo" class="h-12 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSt8dyFQPeRxvh8248HNLA7iTztOkIBKuDaQ_BPdJCYnU3sys82Cbkeu4KVYmMePdEd_9SaZk6ixuWe9L-hfYQu5VUJdVLcf-WqYYRmlTjXKAXWLT2OMRckV2mboC2dh1KGlwQM5yB1LH8uryeyBIxS68pBDzq4bfTXUdOgHndOd9uMx1iIlP8BWTzPDAC3lx97YlW3IkEATrr_eCCHKRsfI41Hznc9CwxBfjcGGZeFj9Ujnuta_KllhbmEmE5Qf-IwP1D34rtrOM"/>
            </div>
            <nav class="flex-1 px-4 space-y-1 mt-4">
                <a class="{{ request()->routeIs('dashboard') ? 'sidebar-item-active text-primary-admin' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} flex items-center px-4 py-3 group transition-colors rounded-lg" href="{{ route('dashboard') }}">
                    <span class="material-icons-round mr-3 {{ request()->routeIs('dashboard') ? '' : 'group-hover:text-primary-admin' }}">dashboard</span>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>
                <a class="{{ request()->routeIs('product.*') ? 'sidebar-item-active text-primary-admin' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} flex items-center px-4 py-3 group transition-colors rounded-lg" href="{{ route('product.index') }}">
                    <span class="material-icons-round mr-3 {{ request()->routeIs('product.*') ? '' : 'group-hover:text-primary-admin' }}">inventory_2</span>
                    <span class="text-sm font-medium">Inventory</span>
                </a>
                <a class="flex items-center px-4 py-3 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors group" href="#">
                    <span class="material-icons-round mr-3 group-hover:text-primary-admin">shopping_bag</span>
                    <span class="text-sm font-medium">Orders</span>
                </a>
                <a class="flex items-center px-4 py-3 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors group" href="#">
                    <span class="material-icons-round mr-3 group-hover:text-primary-admin">group</span>
                    <span class="text-sm font-medium">Customers</span>
                </a>
                <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-800">
                    <a class="{{ request()->routeIs('profile.*') ? 'sidebar-item-active text-primary-admin' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800' }} flex items-center px-4 py-3 group transition-colors rounded-lg" href="{{ route('profile.edit') }}">
                        <span class="material-icons-round mr-3 group-hover:text-primary-admin">settings</span>
                        <span class="text-sm font-medium">Settings</span>
                    </a>
                </div>
            </nav>
            <div class="p-4">
                <div class="bg-primary/10 dark:bg-primary/5 rounded-xl p-4 border border-primary/20">
                    <p class="text-xs font-bold text-primary-admin uppercase tracking-wider mb-1">Pro Plan</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400 mb-3">Upgrade for advanced analytics & tools.</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-y-auto">
            <header class="h-16 bg-surface-light/80 dark:bg-surface-dark/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 sticky top-0 z-10 px-6 flex items-center justify-between">
                <div class="flex items-center">
                    <button class="lg:hidden mr-4 text-slate-600 dark:text-slate-400">
                        <span class="material-icons-round">menu</span>
                    </button>
                    <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-admin to-orange-400">
                        @yield('header', 'Dashboard')
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="p-2 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors" onclick="toggleDarkMode()">
                        <span class="material-icons-round">dark_mode</span>
                    </button>
                    <div class="h-8 w-px bg-slate-200 dark:bg-slate-800 mx-2"></div>
                    <div class="flex items-center space-x-3 cursor-pointer group">
                        <div class="w-8 h-8 rounded-full anime-gradient flex items-center justify-center text-white font-bold text-xs ring-2 ring-primary-admin ring-offset-2 ring-offset-surface-light dark:ring-offset-surface-dark">
                            {{ substr(Auth::user()->name ?? 'A', 0, 2) }}
                        </div>
                        <span class="text-sm font-semibold hidden sm:block">{{ Auth::user()->name ?? 'Guest' }}</span>
                    </div>
                </div>
            </header>

            <div class="p-6 space-y-6">
                @yield('content')
            </div>

            <footer class="p-6 mt-auto text-center text-slate-400 text-xs border-t border-slate-200 dark:border-slate-800">
                © {{ date('Y') }} Arkari Design. All Rights Reserved. dashboard.
            </footer>
        </main>
    </div>
</body>
</html>
