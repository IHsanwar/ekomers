@extends('layouts.admin')

@section('page-title', 'Edit User Role')

@section('content')
<!-- Header -->
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.users.index') }}" class="btn btn-ghost btn-sm">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div>
        <h2 class="text-xl font-bold text-slate-900">Edit User</h2>
        <p class="text-sm text-slate-500 mt-1">Manage user role and permissions</p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Section -->
    <div class="lg:col-span-2">
        <!-- User Info Card -->
        <div class="card mb-6">
            <div class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-primary-600 to-primary-700 flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">{{ $user->name }}</h3>
                        <p class="text-slate-600">{{ $user->email }}</p>
                        <p class="text-xs text-slate-500 mt-1">Joined {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Change Role Card -->
        <div class="card">
            <div class="p-6 border-b border-slate-200">
                <h3 class="font-semibold text-slate-900">
                    <i class="fa-solid fa-shield mr-2 text-slate-400"></i>Change Role
                </h3>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-3">
                        @foreach($roles as $role)
                            <label class="flex items-start gap-3 p-4 rounded-lg border-2 cursor-pointer transition-all
                                @if(old('role', $user->role) === $role)
                                    border-primary-500 bg-primary-50
                                @else
                                    border-slate-200 hover:border-slate-300
                                @endif
                            ">
                                <input type="radio" name="role" value="{{ $role }}"
                                    @if(old('role', $user->role) === $role) checked @endif
                                    class="w-5 h-5 mt-0.5 accent-primary-600 cursor-pointer">
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-900">
                                        <i class="fa-solid fa-crown mr-1"></i>{{ ucfirst($role) }}
                                    </p>
                                    <p class="text-xs text-slate-600 mt-1">
                                        @if($role === 'admin')
                                            Full access to all admin features and user management
                                        @else
                                            Standard user with purchase and transaction access
                                        @endif
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('role')
                        <div class="text-sm text-red-600 bg-red-50 border border-red-200 rounded p-3">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Warning Alert (if currently admin) -->
                    @if($user->role === 'admin')
                        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex gap-3">
                            <i class="fa-solid fa-triangle-exclamation text-amber-600 text-lg flex-shrink-0 mt-0.5"></i>
                            <div>
                                <p class="font-semibold text-amber-900 text-sm">Warning</p>
                                <p class="text-xs text-amber-800 mt-1">
                                    Removing admin role will revoke all administrative privileges. Make sure there is another admin account available.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-6 border-t border-slate-200">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save"></i>Save Changes
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">
                            <i class="fa-solid fa-times"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- User Stats Card -->
        <div class="card p-6 space-y-4">
            <h3 class="font-semibold text-slate-900">
                <i class="fa-solid fa-info-circle mr-2 text-slate-400"></i>User Information
            </h3>

            <div class="space-y-3">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">User ID</p>
                    <p class="font-mono text-sm font-medium text-slate-900 mt-1">#{{ $user->id }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Email</p>
                    <p class="text-sm text-slate-600 mt-1 truncate">{{ $user->email }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Current Role</p>
                    <div class="mt-1">
                        @if($user->role === 'admin')
                            <span class="badge badge-warning">
                                <i class="fa-solid fa-crown text-xs mr-1"></i>{{ ucfirst($user->role) }}
                            </span>
                        @else
                            <span class="badge badge-secondary">
                                {{ ucfirst($user->role) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Status</p>
                    <div class="mt-1">
                        <span class="badge badge-success">
                            <i class="fa-solid fa-circle text-xs mr-1"></i>Active
                        </span>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase">Joined</p>
                    <p class="text-sm text-slate-600 mt-1">{{ $user->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="card border-red-200 bg-red-50 p-6 mt-4">
            <h3 class="font-semibold text-red-900 text-sm flex items-center gap-2">
                <i class="fa-solid fa-exclamation-triangle"></i>Danger Zone
            </h3>
            <p class="text-xs text-red-700 mt-2 mb-4">
                This action is permanent and cannot be undone.
            </p>
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                  onsubmit="return confirm('Delete user {{ $user->name }}? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-destructive btn-sm w-full">
                    <i class="fa-solid fa-trash"></i>Delete User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
