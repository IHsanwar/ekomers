@extends('layouts.frontend')
@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6">Welcome to The Artifact</h1>
    <p class="text-gray-600 mb-6">Discover amazing merchandise products at great prices! Shop with confidence and find the perfect items to express your unique style.</p>
    <a href="{{ route('product.index') }}" class="btn bg-blue-600 text-white hover:bg-blue-700 h-11 px-6">
        <i class="fa-solid fa-grid-2 mr-2"></i>Browse Products
    </a>
</div>
@endsection