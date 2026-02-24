<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Family Group
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('family-groups.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Group Name
                        </label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               placeholder="e.g. The Johnson Family"
                               class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('family-groups.index') }}" class="text-gray-500 hover:underline text-sm">
                            Cancel
                        </a>
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded">
                            Create Group
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
