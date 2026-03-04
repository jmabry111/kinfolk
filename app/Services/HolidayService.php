<?php

namespace App\Services;

use Yasumi\Yasumi;
use Yasumi\Holiday;
use Carbon\Carbon;

class HolidayService
{
    public function getUpcomingHolidays(int $year = null): array
    {
        $year = $year ?? now()->year;
        $today = now()->startOfDay();

        $holidays = Yasumi::create('USA', $year);

        $upcoming = [];

foreach ($holidays as $holiday) {
    $date = Carbon::parse($holiday->format('Y-m-d'));

    if ($date->gte($today)) {
        $upcoming[] = [
            'name'      => $holiday->getName(),
            'date'      => $date,
            'days_away' => $today->diffInDays($date),
            'formatted' => $date->format('F j'),
        ];
    }
}
        // If we're late in year, add next year's too
        if (now()->month >= 10) {
            $nextYear = Yasumi::create('USA', $year + 1);
            foreach ($nextYear as $holiday) {
                $date = Carbon::parse($holiday->format('Y-m-d'));
                $upcoming[] = [
                    'name'      => $holiday->getName(),
                    'date'      => $date,
                    'days_away' => $today->diffInDays($date),
                    'formatted' => $date->format('F j'),
                ];
            }
        }

        // Sort by date and filter out weekends-only observances
        usort($upcoming, fn($a, $b) => $a['date']->lt($b['date']) ? -1 : 1);

        return $upcoming;
    }
}
