<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Gift Idea for {{ $contact->name }}
            </h2>
            <a href="{{ route('contacts.show', [$familyGroup, $contact]) }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to {{ $contact->name }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('gifts.store', [$familyGroup, $contact]) }}">
                    @csrf

                    {{-- Gift Idea --}}
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Gift Idea</label>
                        <input type="text" name="description" id="description" value="{{ old('description') }}"
                               placeholder="e.g. Cast iron skillet"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Budget --}}
                    <div class="mb-4">
                        <label for="budget" class="block text-sm font-medium text-gray-700 mb-1">
                            Budget <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                            <input type="number" name="budget" id="budget" value="{{ old('budget') }}"
                                   step="0.01" min="0" placeholder="0.00"
                                   class="w-full pl-7 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        @error('budget') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- URL --}}
                    <div class="mb-4">
                        <label for="url" class="block text-sm font-medium text-gray-700 mb-1">
                            Link <span class="text-gray-400 font-normal">(optional)</span>
                        </label>
                        <input type="url" name="url" id="url" value="{{ old('url') }}"
                               placeholder="https://..."
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Visibility --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_public" value="1"
                                       {{ old('is_public', '1') == '1' ? 'checked' : '' }}
                                       class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-800 font-medium">Public</span>
                                <span class="text-gray-400 text-sm">(visible to group members)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_public" value="0"
                                       {{ old('is_public', '1') == '0' ? 'checked' : '' }}
                                       class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-800 font-medium">Private</span>
                                <span class="text-gray-400 text-sm">(only visible to you)</span>
                            </label>
                        </div>
                        @error('is_public') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Christmas List --}}
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-lg">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="on_christmas_list" value="1"
                                   {{ old('on_christmas_list') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-red-500 focus:ring-red-400 w-5 h-5">
                            <div>
                                <span class="text-sm font-medium text-gray-800">🎄 Add to Christmas List</span>
                                <p class="text-xs text-gray-500 mt-0.5">This gift will appear on the group's Christmas list</p>
                            </div>
                        </label>
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('contacts.show', [$familyGroup, $contact]) }}" class="text-gray-500 hover:underline text-sm">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Add Gift Idea
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
