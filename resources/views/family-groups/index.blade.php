<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Family Groups
            </h2>
            <a href="{{ route('family-groups.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                + New Group
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($groups->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-500">
                    You haven't created or joined any family groups yet.
                    <a href="{{ route('family-groups.create') }}" class="text-indigo-600 underline ml-1">
                        Create your first group
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($groups as $group)
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-start mb-1">
        <h3 class="text-lg font-semibold text-gray-800">{{ $group->name }}</h3>
        <a href="{{ route('gifts.christmas-list', $group) }}"
           title="Group Christmas List"
           class="bg-red-600 hover:bg-red-700 text-white text-sm px-2.5 py-1.5 rounded-lg leading-none flex-shrink-0 ml-2">
            🎄
        </a>
    </div>

    <p class="text-sm text-gray-500 mt-1">
        Owned by {{ $group->owner->name }}
    </p>

    <div class="mt-4 flex justify-between items-center">
                                <a href="{{ route('family-groups.show', $group) }}"
                                   class="text-indigo-600 hover:underline text-sm">
                                    View Group →
                                </a>
                                @if($group->owner_id === Auth::id())
                                    <form method="POST" action="{{ route('family-groups.destroy', $group) }}"
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline text-sm">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
