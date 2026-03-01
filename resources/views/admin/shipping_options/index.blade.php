@extends('layouts.admin')
@section('content')

{{-- HEADER --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Shipping Services</h2>
        <p class="text-sm text-slate-500 mt-1">Manage your shipping options</p>
    </div>

    <a href="{{ route('admin.shipping-options.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus mr-2"></i>Add Shipping Service
    </a>
</div>

{{-- LIST TITLE --}}
<h2 class="text-lg font-semibold mb-3">Shipping Options List</h2>
@php
    function shippingIcon($type) {
        return match($type) {
            'same_day' => ['icon' => 'fa-clock', 'color' => 'text-blue-500'],
            'express' => ['icon' => 'fa-truck', 'color' => 'text-green-500'],
            'standard' => ['icon' => 'fa-box', 'color' => 'text-gray-500'],
            default => ['icon' => 'fa-circle-question', 'color' => 'text-slate-400'],
        };
    }
@endphp
{{-- LIST --}}
<div class="space-y-3">
@foreach($shippingOptions as $option)
    @php
        $iconData = shippingIcon($option->delivery_type);
    @endphp

    <div class="card p-4 flex items-center justify-between border-b">
        
        <div class="flex items-center gap-4">
            
            {{-- ICON --}}
            <div class="text-2xl {{ $iconData['color'] }} bg-slate-100 p-5 rounded-lg">
                <i class="fa-solid {{ $iconData['icon'] }}"></i>
            </div>

            {{-- TEXT --}}
            <div>
                <h3 class="font-semibold text-slate-900">
                    {{ $option->name }}
                </h3>
                <p class="text-sm text-slate-500">
                    Cost: Rp {{ number_format($option->cost, 0, ',', '.') }} |
                    Type: {{ ucfirst(str_replace('_', ' ', $option->delivery_type)) }} |
                    Estimated: {{ $option->estimated_delivery_time }}
                </p>
                
            </div>

        </div>
    
        <div class="flex gap-2">
            <a href="{{ route('admin.shipping-options.update', $option->id) }}" class="btn-secondary">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            <form action="{{ route('admin.shipping-options.destroy', $option->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shipping option?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primary bg-red-600 hover:bg-red-700">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>

    </div>
@endforeach
</div>

@endsection