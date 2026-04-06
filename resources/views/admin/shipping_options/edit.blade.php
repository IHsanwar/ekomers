@extends('layouts.admin')

@section('page-title', 'Edit Shipping Option')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.shipping-options.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-900">Edit Shipping Option</h2>
        <p class="text-sm text-slate-500 mt-1">Update shipping service information</p>
    </div>
</div>

<!-- Errors -->
@if ($errors->any())
    <div class="card border-red-200 bg-red-50 p-4 mb-6">
        <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Edit Form Card -->
<div class="card max-w-2xl">
    <div class="p-6 border-b border-slate-200">
        <h3 class="font-semibold text-slate-900">
            <i class="fa-solid fa-truck mr-2 text-slate-400"></i>Shipping Details
        </h3>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.shipping-options.update', $shippingOption->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Service Name -->
            <div>
                <label for="name" class="text-sm font-semibold text-slate-900">
                    Service Name
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name', $shippingOption->name) }}"
                       placeholder="e.g., Standard Shipping"
                       class="input mt-2 w-full @error('name') input-error @enderror"
                       required>
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Cost -->
            <div>
                <label for="cost" class="text-sm font-semibold text-slate-900">
                    Cost (Rp)
                </label>
                <input type="number"
                       id="cost"
                       name="cost"
                       value="{{ old('cost', $shippingOption->cost) }}"
                       placeholder="0"
                       min="0"
                       step="0.01"
                       class="input mt-2 w-full @error('cost') input-error @enderror"
                       required>
                @error('cost')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Delivery Type -->
            <div>
                <label for="delivery_type" class="text-sm font-semibold text-slate-900">
                    Delivery Type
                </label>
                <select id="delivery_type"
                        name="delivery_type"
                        class="input mt-2 w-full @error('delivery_type') input-error @enderror"
                        required>
                    <option value="">-- Select Type --</option>
                    <option value="standard" {{ old('delivery_type', $shippingOption->delivery_type) == 'standard' ? 'selected' : '' }}>
                        <i class="fa-solid fa-box"></i> Standard (Regular Shipping)
                    </option>
                    <option value="express" {{ old('delivery_type', $shippingOption->delivery_type) == 'express' ? 'selected' : '' }}>
                        <i class="fa-solid fa-truck"></i> Express (Fast Shipping)
                    </option>
                    <option value="same_day" {{ old('delivery_type', $shippingOption->delivery_type) == 'same_day' ? 'selected' : '' }}>
                        <i class="fa-solid fa-clock"></i> Same Day (Same Day Delivery)
                    </option>
                </select>
                @error('delivery_type')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estimated Delivery Time -->
            <div>
                <label for="estimated_delivery_time" class="text-sm font-semibold text-slate-900">
                    Estimated Delivery Time
                </label>
                <input type="text"
                       id="estimated_delivery_time"
                       name="estimated_delivery_time"
                       value="{{ old('estimated_delivery_time', $shippingOption->estimated_delivery_time) }}"
                       placeholder="e.g., 2-3 days"
                       class="input mt-2 w-full @error('estimated_delivery_time') input-error @enderror"
                       required>
                @error('estimated_delivery_time')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 pt-6 border-t border-slate-200">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>Save Changes
                </button>
                <a href="{{ route('admin.shipping-options.index') }}" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
