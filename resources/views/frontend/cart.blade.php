@extends('layouts.frontend')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                <i class="fa-solid fa-cart-shopping mr-2 text-primary-600"></i>Shopping Cart
            </h1>
            <p class="text-slate-500 mt-1">Review your items before checkout</p>
        </div>
        <a href="{{ route('product.index') }}" class="btn-outline btn-sm">
            <i class="fa-solid fa-arrow-left mr-1.5"></i>Continue Shopping
        </a>
    </div>

    @if($cartItems->isEmpty())
        <!-- Empty State -->
        <div class="card">
            <div class="empty-state py-16">
                <i class="fa-solid fa-cart-shopping empty-state-icon"></i>
                <h3 class="empty-state-title">Your cart is empty</h3>
                <p class="empty-state-description">Looks like you haven't added anything to your cart yet.</p>
                <a href="{{ route('product.index') }}" class="btn-primary">
                    <i class="fa-solid fa-grid-2 mr-2"></i>Browse Products
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="card p-4 md:p-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                            <!-- Product Image -->
                            <img src="{{ $item->product->image_url ?? '/images/default.png' }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-20 h-20 object-cover rounded-lg border border-slate-200">
                            
                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-slate-900 truncate">{{ $item->product->name }}</h3>
                                <p class="text-sm text-slate-500 mt-1">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }} per item
                                </p>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="flex items-center gap-4">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" id="quantity-{{ $item->id }}" value="{{ $item->quantity }}">
                                    
                                    <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden">
                                        <button type="button" 
                                                onclick="updateQuantity({{ $item->id }}, -1)"
                                                class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 transition-colors">
                                            <i class="fa-solid fa-minus text-xs"></i>
                                        </button>
                                        <span class="px-4 py-2 text-slate-900 font-medium min-w-[3rem] text-center" id="display-quantity-{{ $item->id }}">
                                            {{ $item->quantity }}
                                        </span>
                                        <button type="button" 
                                                onclick="updateQuantity({{ $item->id }}, 1)"
                                                class="px-3 py-2 bg-slate-50 hover:bg-slate-100 text-slate-600 transition-colors">
                                            <i class="fa-solid fa-plus text-xs"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- Subtotal -->
                                <div class="text-right min-w-[100px]">
                                    <p class="text-lg font-bold text-slate-900">
                                        Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Delete Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" 
                                      onsubmit="return confirm('Remove this item from cart?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-slate-900 mb-4">
                        <i class="fa-solid fa-receipt mr-2 text-primary-600"></i>Order Summary
                    </h2>
                    
                    <div class="space-y-3 mb-4">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal ({{ $cartItems->count() }} items)</span>
                            <span>Rp {{ number_format($cartItems->sum('total_price'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Shipping</span>
                            <span class="text-emerald-600 font-medium">Free</span>
                        </div>
                    </div>
                    
                    <div class="border-t border-slate-200 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-slate-900">Total</span>
                            <span class="text-xl font-bold text-primary-600">
                                Rp {{ number_format($cartItems->sum('total_price'), 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.page') }}" class="btn-primary w-full justify-center">
                        <i class="fa-solid fa-lock mr-2"></i>Proceed to Checkout
                    </a>
                    
                    <p class="text-xs text-slate-500 text-center mt-4">
                        <i class="fa-solid fa-shield-halved mr-1"></i>Secure checkout
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function updateQuantity(itemId, delta) {
    const input = document.getElementById('quantity-' + itemId);
    const display = document.getElementById('display-quantity-' + itemId);
    let value = parseInt(input.value);
    let newValue = value + delta;

    if (newValue < 1) return;

    input.value = newValue;
    display.textContent = newValue;
    input.form.submit();
}
</script>
@endsection
