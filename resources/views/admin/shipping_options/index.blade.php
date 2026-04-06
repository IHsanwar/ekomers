@extends('layouts.admin')

@section('page-title', 'Shipping Management')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Shipping Services</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your shipping options</p>
    </div>

    <a href="{{ route('admin.shipping-options.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus mr-2"></i>Add Shipping Service
    </a>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="toast-success mb-4">
        <i class="fa-solid fa-check toast-icon"></i>
        <div>
            <div class="toast-title">Success</div>
            <div class="toast-description">{{ session('success') }}</div>
        </div>
    </div>
@endif

<!-- Shipping Options List -->
<div class="space-y-4">
    @php
        function shippingIcon($type) {
            return match($type) {
                'same_day' => ['icon' => 'fa-clock', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100'],
                'express' => ['icon' => 'fa-truck', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-100'],
                'standard' => ['icon' => 'fa-box', 'color' => 'text-slate-600', 'bg' => 'bg-slate-100'],
                default => ['icon' => 'fa-circle-question', 'color' => 'text-slate-400', 'bg' => 'bg-slate-100'],
            };
        }
    @endphp

    @forelse($shippingOptions as $option)
        @php
            $iconData = shippingIcon($option->delivery_type);
        @endphp

        <div class="card">
            <div class="p-6 flex items-center justify-between">
                <!-- Left Side -->
                <div class="flex items-center gap-4 flex-1">
                    <!-- Icon -->
                    <div class="w-16 h-16 {{ $iconData['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid {{ $iconData['icon'] }} {{ $iconData['color'] }} text-2xl"></i>
                    </div>

                    <!-- Info -->
                    <div class="flex-1">
                        <h3 class="font-semibold text-slate-900 text-lg">
                            {{ $option->name }}
                        </h3>
                        <p class="text-sm text-slate-600 mt-1">
                            <i class="fa-solid fa-tag mr-1.5"></i>
                            <span class="font-medium">Rp {{ number_format($option->cost, 0, ',', '.') }}</span>
                        </p>
                        <p class="text-sm text-slate-500 mt-1">
                            <i class="fa-solid fa-calendar mr-1.5"></i>
                            {{ $option->estimated_delivery_time }} •
                            <span class="capitalize">{{ str_replace('_', ' ', $option->delivery_type) }}</span>
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2 flex-shrink-0">
                    <a href="{{ route('admin.shipping-options.edit', $option->id) }}"
                       class="btn btn-ghost btn-sm"
                       title="Edit shipping option">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <form action="{{ route('admin.shipping-options.destroy', $option->id) }}"
                          method="POST"
                          class="inline"
                          onsubmit="return confirm('Delete this shipping option?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-ghost btn-sm text-red-600 hover:bg-red-50"
                                title="Delete shipping option">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="empty-state py-12">
                <i class="fa-solid fa-box empty-state-icon"></i>
                <h3 class="empty-state-title">No shipping options yet</h3>
                <p class="empty-state-description">Create your first shipping option to get started</p>
                <a href="{{ route('admin.shipping-options.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus mr-2"></i>Add Shipping Service
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection
