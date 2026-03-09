<div class="relative rounded-2xl overflow-hidden shadow-md col-span-1 flex items-end self-stretch"
     style="{{ $holiday['image'] ? 'background-image: url(' . $holiday['image'] . '); background-size: cover; background-position: center;' : 'background-color: #9FC8A9;' }}">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
    {{-- Content --}}
    <div class="relative z-10 p-4 w-full">
        <div class="flex items-end justify-between">
            <div>
                <span class="inline-block bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full mb-2 backdrop-blur-sm">
                    🎉 Holiday
                </span>
                <h3 class="text-white font-serif font-bold text-lg leading-tight">
                    {{ $holiday['name'] }}
                </h3>
                <p class="text-white/80 text-sm mt-1">
                    {{ $holiday['day_of_week'] }}, {{ $holiday['formatted'] }}
                </p>
            </div>
            <div class="text-right">
                <span class="inline-block bg-white/20 text-white text-sm font-bold px-4 py-2 rounded-xl backdrop-blur-sm">
                    @if($holiday['days_away'] === 0)
                        Today!
                    @elseif($holiday['days_away'] === 1)
                        Tomorrow
                    @else
                        In {{ $holiday['days_away'] }} days
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>
