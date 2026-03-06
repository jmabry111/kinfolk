<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dashboard-upcoming">
            Upcoming Holidays and Birthdays
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
                        @foreach($upcoming30 as $item)
                              @if(is_array($item) && ($item['type'] ?? '') === 'holiday')
                                  @include('partials.holiday-card', ['holiday' => $item])
                              @else
                                  @include('partials.birthday-card', ['contact' => $item])
                              @endif
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
                        @foreach($upcoming60 as $item)
                              @if(is_array($item) && ($item['type'] ?? '') === 'holiday')
                                  @include('partials.holiday-card', ['holiday' => $item])
                              @else
                                  @include('partials.birthday-card', ['contact' => $item])
                              @endif
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
                        @foreach($upcoming90 as $item)
                              @if(is_array($item) && ($item['type'] ?? '') === 'holiday')
                                  @include('partials.holiday-card', ['holiday' => $item])
                              @else
                                  @include('partials.birthday-card', ['contact' => $item])
                              @endif
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
@if($laterHolidays->count() > 0)
<div class="mt-10 max-w-4xl mx-auto">
    <h2 class="text-2xl font-serif font-bold text-slate-700 mb-6">Later This Year</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($laterHolidays as $holiday)
            @include('partials.holiday-card', ['holiday' => $holiday])
        @endforeach
    </div>
</div>
@endif
    </div>
@if(!auth()->user()->walkthrough_completed || request('tour'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => window.startKinfolkTour(), 500);
    });
</script>
@endif
</x-app-layout>
