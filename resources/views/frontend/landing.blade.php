@extends('layouts.frontend')

@section('content')
<div class="bg-slate-50">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-b from-white to-slate-50 pt-20 pb-32 sm:pt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-50 border border-primary-200 rounded-full">
                            <span class="w-2 h-2 bg-primary-600 rounded-full"></span>
                            <span class="text-sm font-medium text-primary-700"> Discover Amazing Products</span>
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-slate-900 leading-tight">
                            Shop Best Merch from<br/><span class="text-primary-600">The Artifacts</span>
                        </h1>
                        <p class="text-xl text-slate-600 leading-relaxed">
                            Discover our curated collection of high-quality products. Experience shopping like never before with exclusive deals and premium selection.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('product.index') }}" 
                           class="inline-flex items-center justify-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-slate-800 transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105 transform">
                            <i class="fas fa-shopping-bag"></i>
                            Shop Now
                        </a>
                        <button class="inline-flex items-center justify-center gap-2 border-2 border-slate-900 text-slate-900 px-8 py-3 rounded-lg font-semibold hover:bg-slate-50 transition-all duration-200">
                            <i class="fas fa-play"></i>
                            Learn More
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-8 border-t border-slate-200">
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ App\Models\Product::count() }}+</p>
                            <p class="text-sm text-slate-600">Products</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ App\Models\User::count() }}+</p>
                            <p class="text-sm text-slate-600">Customers</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-slate-900">{{ App\Models\Transaction::count() }}+</p>
                            <p class="text-sm text-slate-600">Orders</p>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="relative hidden lg:block">
                    <div class="relative w-full aspect-square">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-200 via-purple-200 to-pink-200 rounded-2xl opacity-30 blur-3xl"></div>
                        <div class="relative bg-black rounded-2xl p-8 flex items-center justify-center h-full">
                            <div class="text-center">
                                <i class="fas fa-store text-white text-9xl mb-4 block opacity-80"></i>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-white border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Browse Categories</h2>
                    <p class="text-slate-600 mt-2">Explore our most popular categories</p>
                </div>
                <a href="{{ route('product.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center gap-2">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('product.index', ['category' => $category->id]) }}"
                       class="group p-6 bg-gradient-to-br from-slate-50 to-slate-100 rounded-xl border border-slate-200 hover:border-primary-500 hover:shadow-md transition-all duration-300 text-center">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-tag text-primary-600"></i>
                        </div>
                        <h3 class="font-semibold text-slate-900 group-hover:text-primary-600 transition-colors">
                            {{ $category->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- New Products Section -->
    @if($newProducts->count() > 0)
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 border border-blue-200 rounded-full mb-4">
                            <span class="w-2 h-2 bg-blue-600 rounded-full"></span>
                            <span class="text-sm font-medium text-blue-700">New Arrivals</span>
                        </div>
                        <h2 class="text-3xl font-bold text-slate-900">Latest Products</h2>
                        <p class="text-slate-600 mt-2">Just added to our collection</p>
                    </div>
                    <a href="{{ route('product.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center gap-2 hidden sm:flex">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($newProducts as $product)
                        <div class="group bg-white rounded-xl overflow-hidden border border-slate-200 hover:border-primary-500 hover:shadow-lg transition-all duration-300">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                <img src="{{ $product->image_url ?: 'https://via.placeholder.com/400' }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                                        <i class="fas fa-star"></i>New
                                    </span>
                                </div>
                                @if($product->quantity <= 0)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <span class="text-white font-semibold">Out of Stock</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4 space-y-3">
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    <h3 class="font-semibold text-slate-900 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-bold text-primary-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    @if($product->quantity > 0)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 text-xs font-medium rounded">
                                            <i class="fas fa-check-circle"></i>In Stock
                                        </span>
                                    @endif
                                </div>

                                <div class="space-y-2 pt-2">
                                    <a href="{{ route('product.show', $product->id) }}"
                                       class="block w-full text-center border border-slate-300 text-slate-700 py-2 rounded-lg font-medium hover:border-primary-500 hover:text-primary-600 transition-colors text-sm">
                                        View Details
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Popular Products Section -->
    @if($popularProducts->count() > 0)
        <section class="py-20 bg-white border-y border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-12">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-amber-50 border border-amber-200 rounded-full mb-4">
                            <span class="w-2 h-2 bg-amber-600 rounded-full"></span>
                            <span class="text-sm font-medium text-amber-700">Best Sellers</span>
                        </div>
                        <h2 class="text-3xl font-bold text-slate-900">Popular Products</h2>
                        <p class="text-slate-600 mt-2">Customer favorites and best sellers</p>
                    </div>
                    <a href="{{ route('product.index') }}" class="text-primary-600 hover:text-primary-700 font-semibold flex items-center gap-2 hidden sm:flex">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                    @foreach($popularProducts as $product)
                        <div class="group bg-gradient-to-br from-white to-slate-50 rounded-xl overflow-hidden border border-slate-200 hover:border-primary-500 hover:shadow-lg transition-all duration-300">
                            <!-- Product Image -->
                            <div class="relative aspect-square overflow-hidden bg-slate-100">
                                <img src="{{ $product->image_url ?: 'https://via.placeholder.com/400' }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-600 text-white text-xs font-semibold rounded-full">
                                        <i class="fas fa-fire"></i>Popular
                                    </span>
                                </div>
                                @if($product->quantity <= 0)
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                        <span class="text-white font-semibold">Out of Stock</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Product Info -->
                            <div class="p-4 space-y-3">
                                <div>
                                    <p class="text-xs text-slate-500 mb-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                    <h3 class="font-semibold text-slate-900 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </div>

                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-bold text-primary-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    @if($product->quantity > 0)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 text-xs font-medium rounded">
                                            <i class="fas fa-check-circle"></i>In Stock
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-1 mb-2">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star text-amber-400 text-xs"></i>
                                    @endfor
                                    <span class="text-xs text-slate-600 ml-1">(120+ reviews)</span>
                                </div>

                                <div class="space-y-2 pt-2">
                                    <a href="{{ route('product.show', $product->id) }}"
                                       class="block w-full text-center border border-slate-300 text-slate-700 py-2 rounded-lg font-medium hover:border-primary-500 hover:text-primary-600 transition-colors text-sm">
                                        View Details
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-slate-900 text-center mb-12">Why Shop With Us</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6 rounded-xl border border-slate-200 hover:border-primary-500 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-600 transition-colors">
                        <i class="fas fa-shipping-fast text-primary-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-2">Fast Shipping</h3>
                    <p class="text-slate-600 text-sm">Quick and reliable delivery to your doorstep</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-6 rounded-xl border border-slate-200 hover:border-primary-500 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-green-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-2">Secure Payment</h3>
                    <p class="text-slate-600 text-sm">Encrypted transactions with Midtrans</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-6 rounded-xl border border-slate-200 hover:border-primary-500 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-redo text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-2">Easy Returns</h3>
                    <p class="text-slate-600 text-sm">Hassle-free returns within 30 days</p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center p-6 rounded-xl border border-slate-200 hover:border-primary-500 hover:shadow-md transition-all duration-300">
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="font-semibold text-slate-900 mb-2">24/7 Support</h3>
                    <p class="text-slate-600 text-sm">Round-the-clock customer support</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-slate-900 to-slate-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold mb-4">Ready to Start Shopping?</h2>
            <p class="text-xl text-slate-300 mb-8">Browse our collection and find exactly what you're looking for</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="{{ route('product.index') }}" 
                   class="inline-flex items-center gap-2 bg-white text-slate-900 px-8 py-3 rounded-lg font-semibold hover:bg-slate-100 transition-all duration-200 shadow-lg">
                    <i class="fas fa-shopping-bag"></i>
                    Shop Now
                </a>
                @auth
                    <a href="{{ route('cart.index') }}" 
                       class="inline-flex items-center gap-2 border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-all duration-200">
                        <i class="fas fa-cart-shopping"></i>
                        View Cart
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center gap-2 border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white/10 transition-all duration-200">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </a>
                @endauth
            </div>
        </div>
    </section>
</div>
@endsection
