<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎄 Christmas List — {{ $familyGroup->name }}
            </h2>
            <div class="flex items-center gap-3 no-print">
                <a href="{{ route('family-groups.show', $familyGroup) }}"
                   class="text-indigo-600 hover:underline text-sm">
                    ← Back to Group
                </a>
                <button onclick="window.print()"
                        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print / Save PDF
                </button>
            </div>
        </div>
    </x-slot>

    {{-- Print styles --}}
    <style>
        @media print {
            .no-print { display: none !important; }
            nav, header, footer { display: none !important; }
            body { background: white !important; }
            .print-page { padding: 0 !important; }
            .print-card { box-shadow: none !important; border: 1px solid #ddd !important; }
            a[href]::after { content: " (" attr(href) ")"; font-size: 0.75rem; color: #666; }
            .no-print-url::after { content: none !important; }
        }
    </style>

    <div class="py-12 print-page">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Print Header (visible in print only) --}}
            <div class="hidden print:block text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">🎄 Christmas List</h1>
                <p class="text-gray-500 mt-1">{{ $familyGroup->name }} — {{ now()->format('Y') }}</p>
            </div>

            @if($contacts->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center no-print">
                    <p class="text-6xl mb-4">🎁</p>
                    <p class="text-slate-500 text-lg">No gifts on the Christmas list yet.</p>
                    <p class="text-slate-400 text-sm mt-2">
                        When adding or editing a gift idea, check "Add to Christmas List" to have it appear here.
                    </p>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($contacts as $contact)
                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden print-card">

                            {{-- Contact Header --}}
                            <div class="bg-gradient-to-r from-red-600 to-red-500 px-6 py-4 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="text-white font-bold text-lg">{{ $contact->name }}</h3>
                                    @if($contact->birthday)
                                        <p class="text-red-200 text-xs">
                                            {{ $contact->birth_year_unknown
                                                ? $contact->birthday->format('F j')
                                                : $contact->birthday->format('F j, Y') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    <span class="bg-white/20 text-white text-xs font-medium px-3 py-1 rounded-full">
                                        {{ $contact->gifts->count() }} {{ Str::plural('gift', $contact->gifts->count()) }}
                                    </span>
                                </div>
                            </div>

                            {{-- Gift Items --}}
                            <ul class="divide-y divide-slate-100">
                                @foreach($contact->gifts as $gift)
                                    <li class="px-6 py-4 flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3">
                                            <span class="text-xl mt-0.5">🎁</span>
                                            <div>
                                                <p class="font-medium text-slate-800">{{ $gift->description }}</p>
                                                @if($gift->url)
                                                    <a href="{{ $gift->url }}" target="_blank"
                                                       class="text-xs text-blue-500 hover:underline break-all no-print-url">
                                                        {{ $gift->url }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 flex items-center gap-2">
                                            @if($gift->budget)
                                                <span class="text-sm text-slate-500">${{ number_format($gift->budget, 2) }}</span>
                                            @endif
                                            @if($gift->is_purchased)
                                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                                    ✓ Purchased
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 text-xs font-medium px-2.5 py-1 rounded-full">
                                                    Needed
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endforeach
                </div>

                {{-- Footer --}}
                <p class="text-center text-slate-400 text-xs mt-8 no-print">
                    Only gifts marked "Add to Christmas List" appear here.
                </p>
            @endif

        </div>
    </div>
</x-app-layout>
