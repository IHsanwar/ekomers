@extends('layouts.admin')

@section('page-title', 'Edit Category')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <x-button variant="ghost" size="sm" href="{{ route('admin.categories.index') }}" icon="fa-solid fa-arrow-left" />
    <div>
        <h2 class="text-xl font-bold text-slate-900">Edit Category</h2>
        <p class="text-sm text-slate-500 mt-1">Update category information</p>
    </div>
</div>

<div class="max-w-2xl">
    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <x-card>
            <x-slot:header>
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-tag mr-2 text-slate-400"></i>Category Details
                </h3>
            </x-slot:header>

            <div class="space-y-4">
                <div>
                    <x-input-label for="name" value="Category Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full" 
                                  :value="old('name', $category->name)" 
                                  required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label value="Current Slug" />
                    <p class="mt-1.5 font-mono text-sm text-slate-600 bg-slate-100 px-3 py-2 rounded-lg">
                        {{ $category->slug }}
                    </p>
                    <p class="text-xs text-slate-500 mt-1">The slug will update automatically if you change the name.</p>
                </div>
            </div>

            <x-slot:footer>
                <div class="flex items-center justify-end gap-3 w-full bg-slate-50 -m-6 p-6 border-t border-slate-200">
                    <x-button variant="outline" href="{{ route('admin.categories.index') }}" icon="fa-solid fa-xmark">
                        Cancel
                    </x-button>
                    <x-button variant="primary" type="submit" icon="fa-solid fa-save">
                        Update Category
                    </x-button>
                </div>
            </x-slot:footer>
        </x-card>
    </form>

    <!-- Danger Zone -->
    <x-card class="border-red-200 mt-6">
        <x-slot:header>
            <div class="-m-6 p-6 border-b border-red-200 bg-red-50 rounded-t-lg">
                <h3 class="font-semibold text-red-700">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>Danger Zone
                </h3>
            </div>
        </x-slot:header>

        <p class="text-sm text-slate-600 mb-4">Deleting this category will remove it from all associated products.</p>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <x-button variant="destructive" type="submit" icon="fa-solid fa-trash">
                Delete Category
            </x-button>
        </form>
    </x-card>
</div>
@endsection