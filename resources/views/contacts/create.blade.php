<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Contact to {{ $familyGroup->name }}
            </h2>
            <a href="{{ route('family-groups.show', $familyGroup) }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to Group
            </a>
        </div>
    </x-slot>

    <div class="py-12" -data="{ yearUnknown: {{ old('birth_year_unknown', $contact->birth_year_unknown ?? false) ? 'true' : 'false' }} }">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('contacts.store', $familyGroup) }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="relationship_type" class="block text-sm font-medium text-gray-700 mb-1">Relationship</label>
                        <select name="relationship_type" id="relationship_type"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select --</option>
                            @foreach(['Parent', 'Sibling', 'Child', 'Grandparent', 'Aunt/Uncle', 'Cousin', 'Spouse/Partner', 'Friend', 'Coworker', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('relationship_type') == $type ? 'selected' : '' }}>
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
                       {{ old('is_kin', '0') == '1' ? 'checked' : '' }}
                       class="text-indigo-600 focus:ring-indigo-500">
                <span class="text-gray-800 font-medium">Kin</span>
                <span class="text-gray-400 text-sm">(family)</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="radio" name="is_kin" value="0"
                       {{ old('is_kin', '0') == '0' ? 'checked' : '' }}
                       class="text-indigo-600 focus:ring-indigo-500">
                <span class="text-gray-800 font-medium">Folk</span>
                <span class="text-gray-400 text-sm">(friends &amp; others)</span>
            </label>
        </div>
    </div>

{{-- Birthday --}}
<div>
    <label class="block text-sm font-medium text-slate-700 mb-1">Birthday</label>

    {{-- Year Unknown Toggle --}}
    <div class="flex items-center gap-2 mb-3">
        <input type="checkbox" id="birth_year_unknown" name="birth_year_unknown" value="1"
               {{ old('birth_year_unknown', $contact->birth_year_unknown ?? false) ? 'checked' : '' }}
               x-model="yearUnknown"
               class="rounded border-slate-300 text-sage-500 focus:ring-sage-400">
        <label for="birth_year_unknown" class="text-sm text-slate-600">Year unknown</label>
    </div>

    {{-- Full date picker (shown when year is known) --}}
    <div x-show="!yearUnknown">
        <input type="date" name="birthday"
               value="{{ old('birthday', isset($contact) ? $contact->birthday?->format('Y-m-d') : '') }}"
               class="w-full rounded-lg border-slate-300 focus:border-sage-400 focus:ring-sage-400">
    </div>

    {{-- Month/day + generation (shown when year is unknown) --}}
    <div x-show="yearUnknown" class="space-y-3">
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs text-slate-500 mb-1">Month</label>
                <select name="birth_month" class="w-full rounded-lg border-slate-300 focus:border-sage-400 focus:ring-sage-400">
                    <option value="">-- Month --</option>
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}"
                            {{ old('birth_month', isset($contact) && $contact->birth_year_unknown ? $contact->birthday?->month : '') == $m ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-slate-500 mb-1">Day</label>
                <select name="birth_day" class="w-full rounded-lg border-slate-300 focus:border-sage-400 focus:ring-sage-400">
                    <option value="">-- Day --</option>
                    @foreach(range(1,31) as $d)
                        <option value="{{ $d }}"
                            {{ old('birth_day', isset($contact) && $contact->birth_year_unknown ? $contact->birthday?->day : '') == $d ? 'selected' : '' }}>
                            {{ $d }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs text-slate-500 mb-1">Generation</label>
            <select name="generation" class="w-full rounded-lg border-slate-300 focus:border-sage-400 focus:ring-sage-400">
                <option value="">-- Select Generation --</option>
                @foreach(['Gen Z', 'Millennial', 'Gen X', 'Baby Boomer', 'Silent Generation'] as $gen)
                    <option value="{{ $gen }}"
                        {{ old('generation', $contact->generation ?? '') == $gen ? 'selected' : '' }}>
                        {{ $gen }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>

                    <div class="mb-4">
                        <label for="interest_tags" class="block text-sm font-medium text-gray-700 mb-1">
                            Interests <span class="text-gray-400 font-normal">(comma separated, e.g. cooking, outdoors, tech)</span>
                        </label>
                        <input type="text" name="interest_tags" id="interest_tags" value="{{ old('interest_tags') }}"
                               placeholder="cooking, outdoors, tech"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('interest_tags') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('family-groups.show', $familyGroup) }}" class="text-gray-500 hover:underline text-sm">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Add Contact
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
