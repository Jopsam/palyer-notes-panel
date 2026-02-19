<div class="py-10">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Player Notes
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Manage notes for {{ $player->name }}.
                </p>
            </div>

            <a
                href="{{ route('players.index') }}"
                wire:navigate
                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs uppercase tracking-widest hover:bg-gray-300 transition"
                >
                Back
            </a>
        </div>

        <!-- Add Note Card -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100 mb-6">
            <div class="p-6">

                <form wire:submit.prevent="save" class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            New Note
                        </label>

                        <textarea
                            wire:model.defer="note"
                            rows="4"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                            placeholder="Write a note about this player..."
                        ></textarea>

                        @error('note')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    @can(\App\Enums\Permissions::CREATE_PLAYER_NOTES->value)
                        <div class="flex justify-end items-center gap-4">
                            <x-primary-button
                                wire:loading.attr="disabled"
                                >
                                Save Note
                            </x-primary-button>

                            <x-action-message class="me-3" on="note-created">
                                Note saved successfully.
                            </x-action-message>
                        </div>
                    @endcan

                </form>

            </div>
        </div>

        <!-- Notes List Card -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-100">

            @if($notes->count())

                <div class="overflow-x-auto w-full">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Author
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Note
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-100">

                            @foreach($notes as $noteItem)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $noteItem->created_at->format('d/m/Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $noteItem->author->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $noteItem->note }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $notes->links() }}
                    </div>
                </div>

            @else
                <!-- Empty State -->
                <div class="px-6 py-16 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5"
                             viewBox="0 0 24 24" class="w-12 h-12 mx-auto">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 6v12m6-6H6" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">
                        No notes yet
                    </h3>
                    <p class="mt-2 text-sm text-gray-500">
                        This player doesn’t have any notes yet.
                    </p>
                </div>
            @endif

        </div>

    </div>
</div>
