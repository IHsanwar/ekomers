@extends('layouts.frontend')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto card overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <!-- Image Section -->
            <div class="bg-slate-50 p-6 md:p-8 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-slate-200">
                @if($product->images->count())
                    <div class="space-y-4 w-full">
                        <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}" class="w-full h-auto max-h-[400px] object-cover rounded border border-slate-200 shadow-sm">
                        @if($product->images->count() > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images->skip(1) as $img)
                                <img src="{{ $img->image_url }}" alt="{{ $product->name }}" class="w-full h-20 object-cover rounded border border-slate-200 hover:border-slate-400 cursor-pointer transition-colors shadow-sm">
                            @endforeach
                        </div>
                        @endif
                    </div>
                @else
                    <img src="{{ $product->image_url ?: 'https://via.placeholder.com/500' }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-auto max-h-[400px] object-cover rounded border border-slate-200 shadow-sm">
                @endif
            </div>

            <!-- Content Section -->
            <div class="p-6 md:p-8 flex flex-col">
                <div class="mb-4">
                    <x-badge variant="secondary" class="mb-3">Product Details</x-badge>
                    <h1 class="text-3xl font-bold text-slate-900 tracking-tight">{{ $product->name }}</h1>
                </div>
                
                <div class="mb-6">
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>

                <div class="prose prose-slate prose-sm text-slate-600 mb-8 flex-grow">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <div class="mt-auto border-t border-slate-100 pt-6">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="w-full sm:w-1/3">
                                <label for="quantity" class="label mb-2 block">Quantity</label>
                                <div class="flex items-center input p-0 overflow-hidden">
                                    <button type="button" class="px-4 py-2 hover:bg-slate-100 transition-colors h-full flex items-center justify-center font-medium" onclick="changeQuantity(this, -1)">−</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                                           class="w-full text-center h-full focus:outline-none border-x border-slate-200 text-sm font-medium hide-arrow" style="-moz-appearance: textfield;">
                                    <button type="button" class="px-4 py-2 hover:bg-slate-100 transition-colors h-full flex items-center justify-center font-medium" onclick="changeQuantity(this, 1)">+</button>
                                </div>
                            </div>

                            <div class="w-full sm:w-2/3 flex items-end">
                                <button type="submit" class="btn btn-primary w-full shadow-sm">
                                    <i class="fa-solid fa-cart-plus mr-2"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hide-arrow::-webkit-inner-spin-button, 
    .hide-arrow::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
</style>

<script>
function changeQuantity(btn, delta) {
    const input = btn.parentElement.querySelector('input[name="quantity"]');
    let value = parseInt(input.value || 1);
    value = Math.max(1, value + delta);
    input.value = value;
}
</script>
@endsection