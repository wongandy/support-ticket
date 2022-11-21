<x-app-layout>
    <x-slot name="header">
        {{ __('Edit label') }}
    </x-slot>

    <div class="p-4 bg-white rounded-lg shadow-md">

        <form action="{{ route('labels.update', $label) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="name" :value="__('Name')"/>
                <x-text-input type="text"
                         id="name"
                         name="name"
                         class="block w-full"
                         value="{{ old('name', $label->name) }}"
                         />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <div class="mt-1 inline-flex space-x-1">
                    <input type="checkbox" name="is_visible" id="is_visible" @checked(old('is_visible', $label->is_visible))>
                    <x-input-label for="is_visible">Visible?</x-input-label>
                </div>
                <x-input-error :messages="$errors->get('is_visible')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>

    </div>
</x-app-layout>
