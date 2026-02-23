<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0">
                    <a href="{{ route('product.index') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-slate-900 rounded-lg flex items-center justify-center">
                            <i class="fa-solid fa-store text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-slate-900">ShopKu</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('product.index') }}" 
                       class="inline-flex items-center px-1 pt-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all duration-200 {{ request()->routeIs('product.*') ? 'text-slate-900 border-b-2 border-primary-500' : '' }}">
                        <i class="fa-solid fa-store mr-2"></i>Store
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-1 pt-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all duration-200 {{ request()->routeIs('dashboard') ? 'text-slate-900 border-b-2 border-primary-500' : '' }}">
                        <i class="fa-solid fa-gauge mr-2"></i>Dashboard
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900 transition-all duration-200">
                        <div class="w-8 h-8 bg-slate-200 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user text-slate-600"></i>
                        </div>
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs" :class="{ 'rotate-180': open }"></i>
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
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fa-solid fa-user mr-2"></i>Profile
                        </a>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item-danger w-full text-left">
                                <i class="fa-solid fa-right-from-bracket mr-2"></i>Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <i class="fa-solid" :class="{ 'fa-xmark': open, 'fa-bars': !open }"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('product.index') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100 transition-all duration-200">
                <i class="fa-solid fa-store mr-2"></i>Store
            </a>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100 transition-all duration-200">
                <i class="fa-solid fa-gauge mr-2"></i>Dashboard
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            <div class="px-4 mb-3">
                <div class="font-medium text-base text-slate-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1 px-4">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-slate-600 hover:bg-slate-100 transition-all duration-200">
                    <i class="fa-solid fa-user mr-2"></i>Profile
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-red-600 hover:bg-red-50 transition-all duration-200">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
