@extends('layouts.admin')

@section('page-title', $category ? 'Edit Category' : 'Add Category')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.categories.index') }}" class="btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-900">{{ $category ? 'Edit Category' : 'Add New Category' }}</h2>
        <p class="text-sm text-slate-500 mt-1">{{ $category ? 'Update category information' : 'Create a new product category' }}</p>
    </div>
</div>

<div class="max-w-2xl">
    <form action="{{ $category ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST">
        @csrf
        @if($category)
            @method('PUT')
        @endif

        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-tag mr-2 text-slate-400"></i>Category Details
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <x-input-label for="name" value="Category Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full" 
                                  :value="old('name', $category?->name)" 
                                  placeholder="e.g. Electronics, Fashion, Food"
                                  required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <p class="text-xs text-slate-500 mt-1">The slug will be generated automatically from the name.</p>
                </div>
            </div>
            <div class="p-6 border-t border-slate-200 bg-slate-50 flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="btn-outline">
                    <i class="fa-solid fa-xmark mr-2"></i>Cancel
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-save mr-2"></i>
                    {{ $category ? 'Update Category' : 'Save Category' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection