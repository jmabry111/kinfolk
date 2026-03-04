@php
    $daysAway = $contact->days_away ?? $contact->days_until_birthday;
    $urgency = $daysAway <= 30 ? 'high' : ($daysAway <= 60 ? 'medium' : 'low');
    $borderColor = match($urgency) {
        'high'   => 'border-rose-300',
        'medium' => 'border-amber-300',
        default  => 'border-sky-300',
    };
    $badgeColor = match($urgency) {
        'high'   => 'bg-rose-100 text-rose-600',
        'medium' => 'bg-amber-100 text-amber-600',
        default  => 'bg-sky-100 text-sky-600',
    };
    $groupId = $contact->family_group_id;
@endphp

<div class="bg-white shadow-sm rounded-lg border-l-4 {{ $borderColor }} p-4 flex flex-col gap-2">

    <div class="flex justify-between items-start">
        <div>
            <a href="{{ route('contacts.show', [$groupId, $contact]) }}"
               class="text-gray-800 font-semibold hover:text-indigo-600">
                {{ $contact->name }}
            </a>
            <p class="text-sm text-gray-400">{{ $contact->relationship_type }}</p>
        </div>
        <span class="{{ $badgeColor }} text-xs font-bold px-2 py-1 rounded-full whitespace-nowrap">
            {{ $contact->days_away === 0 ? '🎂 Today!' : 'In ' . $contact->days_away . ' days' }}
        </span>
    </div>

    <div class="flex justify-between items-center text-sm text-gray-500">
@if($contact->birth_year_unknown ?? false)
    <span class="text-slate-500 text-sm">{{ $contact->generation ?? 'Generation unknown' }}</span>
@else
    <span class="text-slate-500 text-sm">Turning {{ \Carbon\Carbon::parse($contact->birthday)->age + 1 }}</span>
@endif
        <span class="text-xs px-2 py-0.5 rounded-full {{ $contact->is_kin ? 'bg-rose-100 text-rose-600' : 'bg-sky-100 text-sky-600' }}">
            {{ $contact->is_kin ? 'Kin' : 'Folk' }}
        </span>
    </div>

    @if($contact->interest_tags)
        <div class="flex flex-wrap gap-1">
            @foreach($contact->interest_tags as $tag)
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $tag }}</span>
            @endforeach
        </div>
    @endif

    <div class="mt-1">
        <a href="{{ route('gifts.create', [$groupId, $contact]) }}"
           class="text-xs text-indigo-600 hover:underline">
            + Add Gift Idea
        </a>
    </div>

</div>
