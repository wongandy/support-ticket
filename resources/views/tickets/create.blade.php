<x-app-layout>
    <x-slot name="header">
        {{ __('Create ticket') }}
    </x-slot>

    @if ($message = Session::get('success'))
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
    @endif

    <div class="p-4 bg-white rounded-lg shadow-md">

        <form action="{{ route('tickets.store') }}" method="POST">
            @csrf

            <div>
                <x-input-label for="title" :value="__('Title')"/>
                <x-text-input type="text"
                         id="title"
                         name="title"
                         class="block w-full"
                         value="{{ old('title') }}"
                         />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')"/>
                <textarea id="description" name="description" class="mt-1 block h-32 w-full rounded-md border-gray-300 shadow-sm focus-within:text-primary-600 focus:border-primary-300 focus:ring-primary-200 focus:ring focus:ring-opacity-50">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="categories" :value="__('Categories')"/>
                @foreach ($categories as $id => $name)
                    <div class="mt-1 inline-flex space-x-1">
                        <input type="checkbox" name="categories[]" id="category-{{ $id }}" value="{{ $id }}" @checked(in_array($id, old('categories', [])))>
                        <x-input-label for="category-{{ $id }}">{{ $name }}</x-input-label>
                    </div>
                @endforeach
                <x-input-error :messages="$errors->get('categories')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="labels" :value="__('Labels')"/>
                @foreach ($labels as $id => $name)
                    <div class="mt-1 inline-flex space-x-1">
                        <input type="checkbox" name="labels[]" id="label-{{ $id }}" value="{{ $id }}" @checked(in_array($id, old('labels', [])))>
                        <x-input-label for="label-{{ $id }}">{{ $name }}</x-input-label>
                    </div>
                @endforeach
                <x-input-error :messages="$errors->get('labels')" class="mt-2" />
            </div>
            
            <div class="mt-4">
                <x-input-label for="priority" :value="__('Priority')"/>

                <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:text-primary-600 focus:border-primary-300 focus:ring-primary-200 focus:ring focus:ring-opacity-50">
                    @foreach (App\Enums\Tickets\Priorities::cases() as $priority)
                        <option value="{{ $priority->value }}" @selected(old('priority') == $priority->value)>{{ $priority->name }}</option>
                    @endforeach
                </select>
            </div>

            @if (auth()->user()->hasRole('admin'))
                <div class="mt-4">
                    <x-input-label for="assigned_to" :value="__('Assign To')"/>
                    <select name="assigned_to" id="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus-within:text-primary-600 focus:border-primary-300 focus:ring-primary-200 focus:ring focus:ring-opacity-50">
                        <option value="">-- SELECT AGENT --</option>
                        @foreach ($agents as $id => $agent)
                            <option value="{{ $id }}">{{ $agent }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</x-app-layout>
