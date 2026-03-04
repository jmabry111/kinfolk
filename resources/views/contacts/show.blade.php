<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $contact->name }}
            </h2>
            <a href="{{ route('family-groups.show', $familyGroup) }}" class="text-indigo-600 hover:underline text-sm">
                ← Back to {{ $familyGroup->name }}
            </a>
        </div>
<div class="flex items-center gap-4">
    <a href="{{ route('contacts.edit', [$familyGroup, $contact]) }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
        Edit Contact
    </a>
    <a href="{{ route('family-groups.show', $familyGroup) }}" class="text-indigo-600 hover:underline text-sm">
        ← Back to {{ $familyGroup->name }}
    </a>
</div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Contact Info --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm text-gray-500">Relationship</dt>
                        <dd class="text-gray-800 font-medium">{{ $contact->relationship_type }}</dd>
                    </div>
<div>
    <dt class="text-sm text-gray-500">Type</dt>
    <dd>
        <span class="text-xs px-2 py-0.5 rounded-full {{ $contact->is_kin ? 'bg-rose-100 text-rose-600' : 'bg-sky-100 text-sky-600' }}">
            {{ $contact->is_kin ? 'Kin' : 'Folk' }}
        </span>
    </dd>
</div>
{{-- Birthday --}}
<div>
    <p class="text-sm text-slate-500">Birthday</p>
    @if($contact->birth_year_unknown)
        <p class="font-semibold text-slate-700">
            {{ $contact->birthday->format('F j') }}
        </p>
    @else
        <p class="font-semibold text-slate-700">
            {{ $contact->birthday->format('F j, Y') }}
        </p>
    @endif
</div>
{{-- Age --}}
<div>
<p class="text-sm text-slate-500">{{ $contact->birth_year_unknown ? 'Generation' : 'Age' }}</p>
    @if($contact->birth_year_unknown)
        <p class="font-semibold text-slate-700">
            {{ $contact->generation ?? 'Unknown' }}
        </p>
    @else
        <p class="font-semibold text-slate-700">
            {{ $contact->birthday->age }}
        </p>
    @endif
</div>
<div>
                        <dt class="text-sm text-gray-500">Birthday In</dt>
                        <dd class="text-gray-800 font-medium">{{ $contact->days_until_birthday }} days</dd>
                    </div>
                    @if($contact->interest_tags)
                    <div class="col-span-2">
                        <dt class="text-sm text-gray-500">Interests</dt>
                        <dd class="flex flex-wrap gap-2 mt-1">
                            @foreach($contact->interest_tags as $tag)
                                <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full">{{ $tag }}</span>
                            @endforeach
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>

{{-- Gift Ideas --}}
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Gift Ideas</h3>
        <a href="{{ route('gifts.create', [$familyGroup, $contact]) }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
            + Add Gift Idea
        </a>
    </div>

    @if($gifts->isEmpty())
        <p class="text-gray-500 text-sm">No gift ideas yet.</p>
    @else
        <ul class="divide-y divide-gray-100">
            @foreach($gifts as $gift)
                <li class="py-3 {{ $gift->is_purchased ? 'opacity-50' : '' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-gray-800 font-medium">{{ $gift->description }}</span>

                            @if($gift->is_purchased)
                                <span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">
                                    This one's covered!
                                </span>
                            @endif

                            @if(!$gift->is_public)
                                <span class="ml-2 text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                    Private
                                </span>
                            @endif

                            <div class="flex items-center gap-3 mt-1">
                                @if($gift->budget)
                                    <span class="text-sm text-gray-500">${{ number_format($gift->budget, 2) }}</span>
                                @endif
                                @if($gift->url)
                                    <a href="{{ $gift->url }}" target="_blank"
                                       class="text-sm text-indigo-600 hover:underline">View Link →</a>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2 ml-4">
                            {{-- Toggle Purchased --}}
                            <form method="POST" action="{{ route('gifts.toggle-purchased', [$familyGroup, $contact, $gift]) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="text-xs px-2 py-1 rounded border {{ $gift->is_purchased ? 'border-gray-300 text-gray-400 hover:text-gray-600' : 'border-green-400 text-green-600 hover:bg-green-50' }}">
                                    {{ $gift->is_purchased ? 'Unmark' : 'Mark Purchased' }}
                                </button>
                            </form>

                            {{-- Edit (only gift owner) --}}
                            @if($gift->user_id === Auth::id())
                                <a href="{{ route('gifts.edit', [$familyGroup, $contact, $gift]) }}"
                                   class="text-xs text-indigo-600 hover:underline">Edit</a>

                                <form method="POST" action="{{ route('gifts.destroy', [$familyGroup, $contact, $gift]) }}"
                                      onsubmit="return confirm('Remove this gift idea?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-500 hover:underline">Remove</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>

        </div>
    </div>
</x-app-layout>
