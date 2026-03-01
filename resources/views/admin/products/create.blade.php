@extends('layouts.admin')

@section('page-title', $product ? 'Edit Product' : 'Add Product')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.products.index') }}" class="btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-900">{{ $product ? 'Edit Product' : 'Add New Product' }}</h2>
        <p class="text-sm text-slate-500 mt-1">{{ $product ? 'Update product information' : 'Fill in the details to add a new product' }}</p>
    </div>
</div>

<form action="{{ $product ? route('admin.products.update', $product) : route('admin.products.store') }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @if($product)
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="card">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-900">
                        <i class="fa-solid fa-info-circle mr-2 text-slate-400"></i>Basic Information
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <x-input-label for="name" value="Product Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full" 
                                      :value="old('name', $product?->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Description" />
                        <textarea id="description" name="description" rows="4" 
                                  class="input mt-1.5 w-full" required>{{ old('description', $product?->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="category_id" value="Category" />
                            <select id="category_id" name="category_id" class="input mt-1.5 w-full" required>
                                <option value="">Select category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ (old('category_id', $product?->category_id) == $cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="price" value="Price (Rp)" />
                            <x-text-input id="price" name="price" type="number" class="mt-1.5 w-full" 
                                          :value="old('price', $product?->price)" min="0" step="0.01" required />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="quantity" value="Stock Quantity" />
                            <x-text-input id="quantity" name="quantity" type="number" class="mt-1.5 w-full" 
                                          :value="old('quantity', $product?->quantity)" min="0" required />
                            <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="card">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-900">
                        <i class="fa-solid fa-images mr-2 text-slate-400"></i>Product Images
                    </h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <x-input-label for="image" value="Main Image" />
                        <input type="file" id="image" name="image" accept="image/*"
                               class="mt-1.5 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        @if($product && $product->image_url)
                            <div class="mt-2">
                                <img src="{{ asset($product->image_url) }}" alt="Current image" class="w-32 h-32 object-cover rounded-lg border border-slate-200">
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-input-label for="images" value="Gallery Images" />
                        <input type="file" id="images" name="images[]" accept="image/*" multiple
                               class="mt-1.5 w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                        <p class="text-xs text-slate-500 mt-1">You can select multiple images</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status -->
            <div class="card">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="font-semibold text-slate-900">
                        <i class="fa-solid fa-toggle-on mr-2 text-slate-400"></i>Status
                    </h3>
                </div>
                <div class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" 
                               {{ (old('is_active', $product?->is_active ?? true)) ? 'checked' : '' }}
                               class="w-5 h-5 rounded border-slate-300 text-primary-600 focus:ring-primary-500">
                        <div>
                            <span class="font-medium text-slate-900">Active</span>
                            <p class="text-xs text-slate-500">Product will be visible to customers</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="p-6 space-y-3">
                    <button type="submit" class="btn-primary w-full justify-center">
                        <i class="fa-solid fa-save mr-2"></i>
                        {{ $product ? 'Update Product' : 'Save Product' }}
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn-outline w-full justify-center">
                        <i class="fa-solid fa-xmark mr-2"></i>Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection