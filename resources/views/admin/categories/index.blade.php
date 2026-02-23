@extends('layouts.admin')

@section('page-title', 'Categories')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-slate-900">Category Management</h2>
        <p class="text-sm text-slate-500 mt-1">Organize your products with categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-primary">
        <i class="fa-solid fa-plus mr-2"></i>Add Category
    </a>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="overflow-x-auto">
        <table class="table">
            <thead class="table-header bg-slate-50">
                <tr>
                    <th class="table-head">Name</th>
                    <th class="table-head">Slug</th>
                    <th class="table-head text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @forelse($categories as $cat)
                <tr class="table-row">
                    <td class="table-cell">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-tag text-primary-600"></i>
                            </div>
                            <span class="font-medium text-slate-900">{{ $cat->name }}</span>
                        </div>
                    </td>
                    <td class="table-cell">
                        <span class="font-mono text-sm text-slate-500">{{ $cat->slug }}</span>
                    </td>
                    <td class="table-cell">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-ghost btn-sm">
                                <i class="fa-solid fa-pen-to-square text-slate-600"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this category?');">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn-ghost btn-sm text-red-600 hover:bg-red-50">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="table-cell text-center py-8">
                        <div class="empty-state">
                            <i class="fa-solid fa-folder-open empty-state-icon"></i>
                            <h3 class="empty-state-title">No categories yet</h3>
                            <p class="empty-state-description">Create your first category to organize products.</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                                <i class="fa-solid fa-plus mr-2"></i>Add Category
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection