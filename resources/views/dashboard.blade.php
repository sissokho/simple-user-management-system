<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openDialog: true }">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            @role('user')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                </div>
            @else
                <!-- Delete confirmaton dialog -->
                <div
                    class="flex justify-center items-center absolute inset-0 bg-black bg-opacity-50"
                    x-show="openDialog"
                    x-trap.inert.noscroll="openDialog"
                    x-on:click="openDialog = false"
                    x-on:keyup.escape="openDialog = false"
                >
                    <div class="bg-white w-72 p-3 rounded">
                        <p class="font-semibold text-center">Are you sure you want to delete this account ?</p>

                        <div class="mt-7 text-center">
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                            <button
                                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                                x-on:click="openDialog = false"
                            >
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <x-button>
                    <a href="{{ route('users.create') }}">Create a new user</a>
                </x-button>

                <!-- Session Status -->
                <x-auth-session-status class="mt-3 text-center" :status="session('status')" />

                <x-auth-validation-errors class="mt-3 text-center" :errors="$errors" />

                <div class="flex flex-col mt-5">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Account status
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Reset password link</span>
                                                <span class="sr-only">Edit</span>
                                                <span class="sr-only">Delete</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $user->name }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                {{ $user->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($user->hasVerifiedEmail())
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Activated
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Not activated yet
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->role->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    @if (!$user->hasVerifiedEmail())
                                                        <a
                                                            href="#"
                                                            class="text-purple-600 hover:text-indigo-900"
                                                            onclick="event.preventDefault();
                                                                        document.getElementById('password-reset-form-{{ $user->id }}').submit();"
                                                        >
                                                            Reset password link
                                                        </a>
                                                        <form action="{{ route('users.resetPassworkLink') }}" method="POST" id="password-reset-form-{{ $user->id }}" class="hidden">
                                                            @csrf
                                                            <input type="hidden" name="email" value="{{ $user->email }}">
                                                        </form>
                                                    @endif

                                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="ml-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                                    <a href="#" class="ml-2 text-red-600 hover:text-indigo-900">Delete</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>

            @endrole
        </div>
    </div>
</x-app-layout>
