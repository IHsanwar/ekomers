<section class="space-y-4">
    <p class="text-sm text-slate-600">
        Once your account is deleted, all of its resources and data will be permanently deleted. 
        Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        <i class="fa-solid fa-trash mr-2"></i>{{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">
                        {{ __('Delete Account') }}
                    </h2>
                    <p class="text-sm text-slate-500">This action cannot be undone</p>
                </div>
            </div>

            <p class="text-sm text-slate-600 mb-4">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Enter your password to confirm') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    <i class="fa-solid fa-xmark mr-2"></i>{{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button>
                    <i class="fa-solid fa-trash mr-2"></i>{{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
