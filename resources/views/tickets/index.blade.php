<x-app-layout>
    <x-slot name="header">
        {{ __('Tickets') }}
    </x-slot>
    @can('create', App\Models\Ticket::class)
        <div class="mb-4 flex justify-between">
            <a class="rounded-lg border border-transparent bg-purple-600 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-purple-700 focus:outline-none focus:ring active:bg-purple-600 keychainify-checked" href="{{ route('tickets.create') }}">
                Create
            </a>
        </div>
    @endcan
    <div class="p-4 bg-white rounded-lg shadow-xs">

        <div class="inline-flex overflow-hidden mb-4 w-full bg-white rounded-lg shadow-md">
            <!-- <div class="flex justify-center items-center w-12 bg-blue-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>
            </div>

            <div class="px-4 py-2 -mx-3">
                <div class="mx-3">
                    <span class="font-semibold text-blue-500">Info</span>
                    <p class="text-sm text-gray-600">Sample table page</p>
                </div>
            </div> -->
        </div>

        <div class="overflow-hidden mb-8 w-full rounded-lg border shadow-xs">
            <div class="overflow-x-auto w-full">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase bg-gray-50 border-b">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Author</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Priority</th>
                        <th class="px-4 py-3">Categories</th>
                        <th class="px-4 py-3">Labels</th>
                        @if (auth()->user()->hasRole('admin'))
                            <th class="px-4 py-3">Assigned To</th>
                        @endif
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse ($tickets as $ticket)
                            <tr class="text-gray-700">
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->title }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->user->name }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->status }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    {{ $ticket->priority }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @foreach ($ticket->categories as $category)
                                        <span class="rounded-full bg-gray-50 px-2 py-1">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @foreach ($ticket->labels as $label)
                                        <span class="rounded-full bg-gray-50 px-2 py-1">{{ $label->name }}</span>
                                    @endforeach
                                </td>
                                @if (auth()->user()->hasRole('admin'))
                                    <td class="px-4 py-3 text-sm">
                                        {{ $ticket->assignedToUser->name ?? '' }}
                                    </td>
                                @endif
                                
                                @canany(['update', 'delete'], $ticket)
                                    <td class="px-4 py-3 text-sm">
                                        <a class="rounded-lg border border-transparent bg-purple-600 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-purple-700 focus:outline-none focus:ring active:bg-purple-600 keychainify-checked" href="{{ route('tickets.edit', $ticket->id) }}">Edit</a>

                                        @can('delete', $ticket)
                                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="rounded-lg border border-transparent bg-purple-600 px-4 py-2 text-center text-sm font-medium leading-5 text-white transition-colors duration-150 hover:bg-purple-700 focus:outline-none focus:ring active:bg-purple-600 keychainify-checked">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                        <tr>
                                <td class="px-4 py-3" colspan="4">No tickets found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase bg-gray-50 border-t sm:grid-cols-9">
                {{ $tickets->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
