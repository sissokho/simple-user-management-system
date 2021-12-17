<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit account details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('users.update', ['user' => $user]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                        </div>

                        <!-- Role -->
                        <div class="mt-4">
                            <x-label for="role" :value="__('Role')" />
                            @if (auth()->user()->is($user))
                                <span class="block px-3 py-2 rounded-md shadow-sm border border-gray-300 cursor-not-allowed">
                                    {{ ucwords($user->role->name) }}
                                </span>
                            @else
                                <select name="role" id="role" class="rounded-md w-full">
                                    @foreach ($roles as $role)
                                        @can('create', [\App\Models\User::class, $role->name])
                                            <option value="{{ $role->id }}"
                                                    {{ $user->role->is($role) ? 'selected' : '' }}
                                            >
                                                {{ ucwords($role->name) }}
                                            </option>
                                        @endcan
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4">
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>

            @if (auth()->user()->is($user))
                <div class="mt-5 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" bag="password" />

                        <x-auth-session-status class="mb-4" :status="session('password-status')" />

                        <form method="POST" action="{{ route('users.updatePassword', ['user' => $user]) }}">
                            @csrf
                            @method('PUT')

                            <!-- Current Password -->
                            <div>
                                <x-label for="current_password" :value="__('Current Password')" />

                                <x-input id="current_password" class="block mt-1 w-full" type="password"
                                            name="current_password"
                                            required
                                            autofocus autocomplete="current-password" />
                            </div>

                            <!-- New Password -->
                            <div class="mt-4">
                                <x-label for="password" :value="__('New Password')" />

                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                            </div>

                            <!-- Password Confirmation -->
                            <div class="mt-4">
                                <x-label for="password_confirmation" :value="__('Confirm New Password')" />

                                <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation"
                                            required />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-4">
                                    {{ __('Update Password') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
