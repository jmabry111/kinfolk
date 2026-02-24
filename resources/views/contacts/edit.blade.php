<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit {{ $contact->name }}
            </h2>
            <a href="{{ route('contacts.show', [$familyGroup, $contact]) }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to Contact
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contacts.update', [$familyGroup, $contact]) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $contact->name) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="relationship_type" class="block text-sm font-medium text-gray-700 mb-1">Relationship</label>
                        <select name="relationship_type" id="relationship_type"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select --</option>
                            @foreach(['Parent', 'Sibling', 'Child', 'Grandparent', 'Aunt/Uncle', 'Cousin', 'Spouse/Partner', 'Friend', 'Coworker', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('relationship_type', $contact->relationship_type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('relationship_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Type</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_kin" value="1"
                                       {{ old('is_kin', $contact->is_kin) == '1' ? 'checked' : '' }}
                                       class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-800 font-medium">Kin</span>
                                <span class="text-gray-400 text-sm">(family)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_kin" value="0"
                                       {{ old('is_kin', $contact->is_kin) == '0' ? 'checked' : '' }}
                                       class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-gray-800 font-medium">Folk</span>
                                <span class="text-gray-400 text-sm">(friends &amp; others)</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="birthday" class="block text-sm font-medium text-gray-700 mb-1">Birthday</label>
                        <input type="date" name="birthday" id="birthday"
                               value="{{ old('birthday', $contact->birthday->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('birthday') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="interest_tags" class="block text-sm font-medium text-gray-700 mb-1">
                            Interests <span class="text-gray-400 font-normal">(comma separated)</span>
                        </label>
                        <input type="text" name="interest_tags" id="interest_tags"
                               value="{{ old('interest_tags', $contact->interest_tags ? implode(', ', $contact->interest_tags) : '') }}"
                               placeholder="cooking, outdoors, tech"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('interest_tags') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('contacts.show', [$familyGroup, $contact]) }}" class="text-gray-500 hover:underline text-sm">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
