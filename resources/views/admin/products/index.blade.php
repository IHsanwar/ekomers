@extends('layouts.admin')

@section('page-title', 'Products')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Product Management</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your store products</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus mr-2"></i>Add Product
    </a>
</div>

<!-- Toast Notifications -->
@if(session('success'))
    <div id="toast-success" class="toast-success mb-6 flex items-start justify-between">
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-check toast-icon"></i>
            <div>
                <div class="toast-title">Success</div>
                <div class="toast-description">{{ session('success') }}</div>
            </div>
        </div>
        <button onclick="dismissToast('toast-success')" class="ml-4 text-current opacity-50 hover:opacity-100">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div id="toast-error" class="toast-error mb-6 flex items-start justify-between">
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-exclamation-circle toast-icon"></i>
            <div>
                <div class="toast-title">Error</div>
                <div class="toast-description">{{ session('error') }}</div>
            </div>
        </div>
        <button onclick="dismissToast('toast-error')" class="ml-4 text-current opacity-50 hover:opacity-100">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
@endif

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $p)
            <div class="card overflow-hidden group">
                <!-- Product Image -->
                <div class="relative aspect-square overflow-hidden bg-slate-100">
                    <img src="{{ asset($p->image_url) }}"
                         alt="{{ $p->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-2 right-2">
                        @if($p->is_active)
                            <x-badge variant="success">
                                <i class="fa-solid fa-check mr-1"></i>Active
                            </x-badge>
                        @else
                            <x-badge variant="danger">
                                <i class="fa-solid fa-xmark mr-1"></i>Inactive
                            </x-badge>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="font-semibold text-slate-900 truncate mb-1">{{ $p->name }}</h3>
                    <p class="text-sm text-slate-500 mb-2">
                        <i class="fa-solid fa-tag mr-1"></i>{{ $p->category->name ?? 'Uncategorized' }}
                    </p>
                    <p class="text-lg font-bold text-primary-600 mb-3">
                        Rp {{ number_format($p->price, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-slate-500 mb-4">
                        <i class="fa-solid fa-boxes-stacked mr-1"></i>Stock: {{ $p->quantity }}
                    </p>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.products.edit', $p) }}" class="btn-outline flex-1 justify-center btn-sm">
                            <i class="fa-solid fa-pen-to-square mr-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-ghost btn-sm text-red-600 hover:bg-red-50">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <!-- Empty State -->
    <div class="card">
        <div class="empty-state py-16">
            <i class="fa-solid fa-box-open empty-state-icon"></i>
            <h3 class="empty-state-title">No products yet</h3>
            <p class="empty-state-description">Get started by adding your first product.</p>
            <a href="{{ route('admin.products.create') }}" class="btn-primary">
                <i class="fa-solid fa-plus mr-2"></i>Add Product
            </a>
        </div>
    </div>
@endif

<script>
    function dismissToast(id) {
        const el = document.getElementById(id);
        if (el) {
            el.style.transition = 'opacity 0.3s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 300);
        }
    }

    // Auto-dismiss after 4 seconds
    document.addEventListener('DOMContentLoaded', function () {
        ['toast-success', 'toast-error'].forEach(function (id) {
            const el = document.getElementById(id);
            if (el) {
                setTimeout(() => dismissToast(id), 4000);
            }
        });
    });
</script>
@endsection