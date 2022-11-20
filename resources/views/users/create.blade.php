<x-app-layout>
    <x-slot name="header">
        {{ __('Create user') }}
    </x-slot>

    <!-- @if ($message = Session::get('success'))
        <div class="inline-flex w-full mb-4 overflow-hidden bg-white rounded-lg shadow-md">
            <div class="flex items-center justify-center w-12 bg-green-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                    </path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-green-500">Success</span>
                    <p class="text-sm text-gray-600">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif -->

    <div class="p-4 bg-white rounded-lg shadow-md">

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input type="text"
                         id="name"
                         name="name"
                         class="block w-full"
                         value="{{ old('name') }}"
                         />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')"/>
                <x-text-input type="text"
                         id="email"
                         name="email"
                         class="block w-full"
                         value="{{ old('email') }}"
                         />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')"/>
                <x-text-input type="password"
                         id="password"
                         name="password"
                         class="block w-full"
                         value="{{ old('password') }}"
                         />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="roles" :value="__('Roles')"/>
                @foreach ($roles as $id => $role)
                    <div class="mt-1 inline-flex space-x-1">
                        <input type="radio" name="role" id="role-{{ $id }}" value="{{ $id }}" @checked(old('role') == $id)>
                        <x-input-label for="role-{{ $id }}">{{ $role }}</x-input-label>
                    </div>
                @endforeach
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</x-app-layout>
