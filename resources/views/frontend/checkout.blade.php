@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900 mb-4">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to Cart
        </a>
        <h1 class="text-2xl font-bold text-slate-900">
            <i class="fa-solid fa-credit-card mr-2 text-primary-600"></i>Checkout
        </h1>
        <p class="text-slate-500 mt-1">Review your order and confirm purchase</p>
    </div>

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
            <i class="fa-solid fa-circle-exclamation mr-3"></i>
            {{ session('error') }}
        </div>
    @endif
        
    @if($cartItems->isEmpty())
        <div class="card">
            <div class="empty-state py-16">
                <i class="fa-solid fa-cart-shopping empty-state-icon"></i>
                <h3 class="empty-state-title">Your cart is empty</h3>
                <p class="empty-state-description">Add some products before checkout.</p>
                <a href="{{ route('product.index') }}" class="btn-primary">
                    <i class="fa-solid fa-grid-2 mr-2"></i>Browse Products
                </a>
            </div>
        </div>
    @else
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <!-- Order Items -->
            <div class="card mb-6">
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900">
                        <i class="fa-solid fa-box mr-2 text-slate-400"></i>Order Items
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-header bg-slate-50">
                            <tr>
                                <th class="table-head">Product</th>
                                <th class="table-head text-right">Price</th>
                                <th class="table-head text-center">Quantity</th>
                                <th class="table-head text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="table-body">
                            @php $total = 0; @endphp
                            @foreach($cartItems as $index => $item)
                                @php 
                                    $subtotal = $item->product->price * $item->quantity; 
                                    $total += $subtotal;
                                @endphp
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $item->product->image_url ?? '/images/default.png' }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                            <span class="font-medium text-slate-900">{{ $item->product->name }}</span>
                                        </div>
                                        <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product->id }}">
                                    </td>
                                    <td class="table-cell text-right text-slate-600">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="table-cell text-center">
                                        <input type="number" name="items[{{ $index }}][quantity]" 
                                               value="{{ $item->quantity }}" min="1"
                                               class="input w-20 text-center">
                                    </td>
                                    <td class="table-cell text-right font-semibold text-slate-900">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Shipping & Address -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Shipping Method -->
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">
                        <i class="fa-solid fa-truck mr-2 text-slate-400"></i>Shipping Method
                    </h2>
                    <select name="shipping_option_id" class="input w-full" required>
                        <option value="">Select Shipping Option</option>
                        @forelse($shippingOptions as $option)
                            <option value="{{ $option->id }}">
                                {{ $option->name }} - Rp {{ number_format($option->cost, 0, ',', '.') }} 
                                ({{ $option->estimated_delivery_time }})
                            </option>
                        @empty
                            <option value="" disabled>No shipping options available</option>
                        @endforelse
                    </select>
                    @error('shipping_option_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="card p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">
                        <i class="fa-solid fa-map-location-dot mr-2 text-slate-400"></i>Delivery Address
                    </h2>
                    <textarea name="address" class="input w-full h-24 resize-none" placeholder="Enter your full delivery address..." required></textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Order Total -->
            <div class="card p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-slate-600 text-sm">
                                <span>Subtotal</span>
                                <span id="subtotalDisplay">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600 text-sm">
                                <span>Shipping</span>
                                <span id="shippingDisplay">Rp 0</span>
                            </div>
                            <div class="border-t border-slate-200 pt-3 flex justify-between">
                                <p class="font-semibold text-slate-900">Order Total</p>
                                <p class="text-xl font-bold text-primary-600" id="grandTotal">
                                    Rp {{ number_format($total, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit" class="btn-primary h-12 px-8 w-full md:w-auto">
                            <i class="fa-solid fa-check mr-2"></i>Confirm Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Security Note -->
            <div class="text-center text-sm text-slate-500">
                <i class="fa-solid fa-lock mr-1"></i>
                Your payment information is secure and encrypted
            </div>
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const shippingData = @json($shippingOptions);
                const subtotal = Number({{ $total }});

                function formatRupiah(num) {
                    return 'Rp ' + Math.floor(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                function updateTotal() {
                    const shippingSelect = document.querySelector('select[name="shipping_option_id"]');
                    const selectedOptionId = shippingSelect.value;

                    let shippingCost = 0;

                    if (selectedOptionId) {
                        const selectedOption = shippingData.find(option => option.id == selectedOptionId);
                        if (selectedOption) {
                            shippingCost = Number(selectedOption.cost);
                        }
                    }

                    const grandTotal = subtotal + shippingCost;

                    document.getElementById('shippingDisplay').textContent = formatRupiah(shippingCost);
                    document.getElementById('grandTotal').textContent = formatRupiah(grandTotal);
                }

                const shippingSelect = document.querySelector('select[name="shipping_option_id"]');

                if (shippingSelect) {
                    shippingSelect.addEventListener('change', updateTotal);
                }
            });
        </script>
    @endif
</div>

@endsection