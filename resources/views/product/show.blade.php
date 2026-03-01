@extends('layouts.frontend')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            @if($product->images->count())
                <div class="space-y-2">
                    @foreach($product->images as $img)
                        <img src="{{ $img->image_url }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded">
                    @endforeach
                </div>
            @else
                <img src="{{ $product->image_url ?: 'https://via.placeholder.com/500' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-96 object-cover rounded">
            @endif
        </div>
        <div>
            <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
            <p class="text-blue-600 text-xl font-semibold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <div class="mt-4 prose">
                {!! nl2br(e($product->description)) !!}
            </div>
             <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="flex items-center justify-between gap-2">
        <div class="flex items-center border rounded-lg">
            <button type="button" class="px-3 py-2 text-gray-600 font-bold" onclick="changeQuantity(this, -1)">−</button>
            <input type="number" name="quantity" value="1" min="1"
                   class="w-16 text-center border-l border-r focus:outline-none">
            <button type="button" class="px-3 py-2 text-gray-600 font-bold" onclick="changeQuantity(this, 1)">+</button>
        </div>

        <button type="submit"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg font-semibold transition-colors duration-200">
            <i class="fa-solid fa-cart-plus"></i>
        </button>
    </div>
</form>
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