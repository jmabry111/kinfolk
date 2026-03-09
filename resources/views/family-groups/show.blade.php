<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $familyGroup->name }}
            </h2>
            <a href="{{ route('family-groups.index') }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to Groups
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Members --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Members</h3>
                    @if($familyGroup->owner_id === Auth::id())
                        <a href="{{ route('invites.create', $familyGroup) }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                            + Invite Member
                        </a>
                    @endif
                </div>
                @if($members->isEmpty())
                    <p class="text-gray-500 text-sm">No members yet.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($members as $member)
                            <li class="py-2 flex justify-between items-center">
                                <span class="text-gray-800">{{ $member->name }}</span>
                                <span class="text-xs text-gray-400 capitalize">{{ $member->pivot->role }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Contacts --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Contacts</h3>
                  <div class="flex items-center gap-2">
                    <a href="{{ route('contacts.create', $familyGroup) }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                        + Add Contact
                    </a>
                    <a href="{{ route('gifts.christmas-list', $familyGroup) }}"
                       class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg" title="Group Christmas List">
                       🎄
                    </a>
                  </div>
                </div>
                @if($contacts->isEmpty())
                    <p class="text-gray-500 text-sm">No contacts added yet.</p>
                @else
                    <ul class="divide-y divide-gray-100">
                        @foreach($contacts as $contact)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <a href="{{ route('contacts.show', [$familyGroup, $contact]) }}"
                                       class="text-gray-800 font-medium hover:text-indigo-600">
                                        {{ $contact->name }}
                                    </a>
                                    <span class="text-gray-400 text-sm ml-2">{{ $contact->relationship_type }}</span>
                                    <span class="ml-2 text-xs px-2 py-0.5 rounded-full {{ $contact->is_kin ? 'bg-rose-100 text-rose-600' : 'bg-sky-100 text-sky-600' }}">
                                        {{ $contact->is_kin ? 'Kin' : 'Folk' }}
                                    </span>
                                </div>
                                <span class="text-sm text-gray-500">
                                    {{ $contact->birthday->format('M j') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
