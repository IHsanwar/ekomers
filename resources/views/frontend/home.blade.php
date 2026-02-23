@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-2xl p-8 md:p-12 mb-10 text-white">
        <div class="max-w-2xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">Welcome to ShopKu</h1>
            <p class="text-slate-300 text-lg mb-6">Discover amazing products at great prices. Shop with confidence.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('product.index') }}" class="btn bg-white text-slate-900 hover:bg-slate-100 h-11 px-6">
                    <i class="fa-solid fa-grid-2 mr-2"></i>Browse Products
                </a>
            </div>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-slate-900">Categories</h2>
            <a href="{{ route('product.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                View all <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="flex flex-wrap gap-3">
            @foreach($categories as $category)
                <a href="{{ route('product.index', ['category' => $category->id]) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-700 hover:border-primary-500 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200 shadow-soft">
                    <i class="fa-solid fa-tag text-slate-400"></i>
                    {{ $category->name }}
                </a>
            @endforeach
            <a href="{{ route('product.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-all duration-200">
                <i class="fa-solid fa-grid-2"></i>
                All Categories
            </a>
        </div>
    </div>

    <!-- Products Section -->
    <div class="mb-10">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">All Products</h2>
                <p class="text-sm text-slate-500 mt-1">{{ $products->count() }} products available</p>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-6">
            @foreach($products as $product)
                <div class="card group hover:shadow-elevated transition-all duration-300 overflow-hidden">
                    <!-- Product Image -->
                    <div class="relative aspect-square overflow-hidden bg-slate-100">
                        <img src="{{ $product->image_url ?: 'https://via.placeholder.com/400' }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute top-2 right-2">
                            @if ($product->quantity <= 0)
                                <x-badge variant="danger">
                                    <i class="fa-solid fa-xmark mr-1"></i>Out of Stock
                                </x-badge>
                            @else
                                <x-badge variant="success">
                                    <i class="fa-solid fa-check mr-1"></i>In Stock
                                </x-badge>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-900 mb-1 line-clamp-2 min-h-[2.5rem] leading-tight text-sm">
                            {{ $product->name }}
                        </h3>

                        <p class="text-xs text-slate-500 mb-2">
                            <i class="fa-solid fa-boxes-stacked mr-1"></i>Stock: {{ $product->quantity }}
                        </p>
                        
                        <p class="text-lg font-bold text-primary-600 mb-3">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <a href="{{ route('product.show', $product->id) }}"
                           class="btn-outline w-full justify-center text-xs h-9 mb-2">
                            <i class="fa-solid fa-eye mr-1.5"></i>View Details
                        </a>

                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            @if ($product->quantity <= 0)
                                <button type="button" disabled
                                        class="btn w-full justify-center text-xs h-9 bg-slate-200 text-slate-500 cursor-not-allowed">
                                    <i class="fa-solid fa-ban mr-1.5"></i>Unavailable
                                </button>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="flex items-center border border-slate-200 rounded-md">
                                        <button type="button" class="px-2 py-1 text-slate-600 hover:bg-slate-100" onclick="changeQuantity(this, -1)">
                                            <i class="fa-solid fa-minus text-xs"></i>
                                        </button>
                                        <input type="number" name="quantity" value="1" min="1"
                                               class="w-10 text-center text-sm border-0 focus:ring-0 p-0">
                                        <button type="button" class="px-2 py-1 text-slate-600 hover:bg-slate-100" onclick="changeQuantity(this, 1)">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                    <button type="submit"
                                            class="btn-primary flex-1 justify-center text-xs h-9">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
function changeQuantity(btn, delta) {
    const input = btn.parentElement.querySelector('input[name="quantity"]');
    let value = parseInt(input.value || 1);
    value = Math.max(1, value + delta);
    input.value = value;
}

</script>
@endsection
