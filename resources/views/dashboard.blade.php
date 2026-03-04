<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upcoming Birthdays
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if($upcoming30->isEmpty() && $upcoming60->isEmpty() && $upcoming90->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-500">
                    No upcoming birthdays in the next 90 days. 
                    <a href="{{ route('family-groups.index') }}" class="text-indigo-600 underline ml-1">
                        Add some contacts
                    </a> to get started.
                </div>
            @endif

            {{-- Next 30 Days --}}
            @if($upcoming30->isNotEmpty())
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                        <span class="bg-rose-100 text-rose-600 text-xs font-bold px-2 py-1 rounded-full">
                            Next 30 Days
                        </span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($upcoming30 as $contact)
                            @include('partials.birthday-card', ['contact' => $contact, 'urgency' => 'high'])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 31-60 Days --}}
            @if($upcoming60->isNotEmpty())
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">
                        <span class="bg-amber-100 text-amber-600 text-xs font-bold px-2 py-1 rounded-full">
                            31–60 Days
                        </span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($upcoming60 as $contact)
                            @include('partials.birthday-card', ['contact' => $contact, 'urgency' => 'medium'])
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 61-90 Days --}}
            @if($upcoming90->isNotEmpty())
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">
                        <span class="bg-sky-100 text-sky-600 text-xs font-bold px-2 py-1 rounded-full">
                            61–90 Days
                        </span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($upcoming90 as $contact)
                            @include('partials.birthday-card', ['contact' => $contact, 'urgency' => 'low'])
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
{{-- Upcoming Holidays --}}
<div class="mt-10">
    <h2 class="text-2xl font-serif font-bold text-slate-700 mb-6">Upcoming Holidays</h2>

    @if(empty($holidays))
        <p class="text-slate-500">No upcoming holidays found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($holidays as $holiday)
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-cream-300 flex items-center gap-4">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-sage-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700">{{ $holiday['name'] }}</p>
                        <p class="text-sm text-slate-500">{{ $holiday['formatted'] }}</p>
                        <p class="text-xs text-sage-500 mt-1">
                            @if($holiday['days_away'] == 0)
                                Today!
                            @elseif($holiday['days_away'] == 1)
                                Tomorrow
                            @else
                                In {{ $holiday['days_away'] }} days
                            @endif
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>
