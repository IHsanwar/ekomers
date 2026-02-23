<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-user text-slate-600"></i>
            </div>
            <div>
                <h2 class="font-semibold text-xl text-slate-900">
                    {{ __('Profile Settings') }}
                </h2>
                <p class="text-sm text-slate-500">Manage your account settings and preferences</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information -->
            <div class="card">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">
                        <i class="fa-solid fa-user-pen mr-2 text-slate-400"></i>Profile Information
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Update your account's profile information and email address.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">
                        <i class="fa-solid fa-lock mr-2 text-slate-400"></i>Update Password
                    </h3>
                    <p class="text-sm text-slate-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card border-red-200">
                <div class="p-6 border-b border-red-200 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-700">
                        <i class="fa-solid fa-triangle-exclamation mr-2"></i>Danger Zone
                    </h3>
                    <p class="text-sm text-red-600 mt-1">Permanently delete your account and all of its data.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
