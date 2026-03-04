<?php

namespace App\Services;

use Yasumi\Yasumi;
use Carbon\Carbon;

class HolidayService
{
    // Map holiday slugs to image filenames in public/images/holidays/
    protected array $imageMap = [
        'new-years-day'                => 'new-years-day.jpg',
        'mlk-day'                      => 'mlk-day.jpg',
        'valentines-day'               => 'valentines-day.jpg',
        'presidents-day'               => 'presidents-day.jpg',
        'st-patricks-day'              => 'st-patricks-day.jpg',
        'easter'                       => 'easter.jpg',
        'mothers-day'                  => 'mothers-day.jpg',
        'memorial-day'                 => 'memorial-day.jpg',
        'juneteenth'                   => 'juneteenth.jpg',
        'fathers-day'                  => 'fathers-day.jpg',
        'independence-day'             => 'independence-day.jpg',
        'independence-day-observed'    => 'independence-day.jpg',
        'labor-day'                    => 'labor-day.jpg',
        'columbus-day'                 => 'columbus-day.jpg',
        'halloween'                    => 'halloween.jpg',
        'veterans-day'                 => 'veterans-day.jpg',
        'veterans-day-observed'        => 'veterans-day.jpg',
        'thanksgiving-day'             => 'thanksgiving.jpg',
        'christmas'                    => 'christmas.jpg',
        'christmas-day-observed'       => 'christmas.jpg',
        'new-years-eve'                => 'new-years-eve.jpg',
    ];

    protected function slugify(string $name): string
    {
        $name = str_replace("'", '', $name); // strip apostrophes first
        return strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '-', $name), '-'));
    }

    protected function getImage(string $slug): ?string
    {
        $filename = $this->imageMap[$slug] ?? null;
        if ($filename && file_exists(public_path("images/holidays/{$filename}"))) {
            return "/images/holidays/{$filename}";
        }
        return null;
    }

    protected function buildHolidayEntry($holiday, Carbon $today): array
    {
        $date  = Carbon::parse($holiday->format('Y-m-d'));
        $slug  = $this->slugify($holiday->getName());
        $image = $this->getImage($slug);

        return [
            'name'       => $holiday->getName(),
            'slug'       => $slug,
            'date'       => $date,
            'days_away'  => (int) $today->diffInDays($date),
            'formatted'  => $date->format('F j'),
            'day_of_week'=> $date->format('l'),
            'image'      => $image,
            'type'       => 'holiday',
        ];
    }

    public function getUpcomingHolidays(int $year = null): array
{
    $year  = $year ?? now()->year;
    $today = now()->startOfDay();

    $upcoming = [];  // ← must be defined first

    $holidays = Yasumi::create('USA', $year);
    foreach ($holidays as $holiday) {
        $date = Carbon::parse($holiday->format('Y-m-d'));
        if ($date->gte($today)) {
            $upcoming[] = $this->buildHolidayEntry($holiday, $today);
        }
    }

    // Add extra non-federal holidays for this year
    $upcoming = array_merge($upcoming, $this->getExtraHolidays($year, $today));

    // If October or later, pull in next year's holidays too
    if (now()->month >= 10) {
        $nextHolidays = Yasumi::create('USA', $year + 1);
        foreach ($nextHolidays as $holiday) {
            $upcoming[] = $this->buildHolidayEntry($holiday, $today);
        }
        $upcoming = array_merge($upcoming, $this->getExtraHolidays($year + 1, $today));
    }

    usort($upcoming, fn($a, $b) => $a['date']->lt($b['date']) ? -1 : 1);

    return $upcoming;
    }

    protected function getExtraHolidays(int $year, Carbon $today): array
{
    $extras = [
        // Fixed date holidays
        ['name' => "Valentine's Day",  'date' => "{$year}-02-14"],
        ['name' => 'St. Patrick\'s Day','date' => "{$year}-03-17"],
        ['name' => 'Halloween',         'date' => "{$year}-10-31"],
        ['name' => 'New Year\'s Eve',   'date' => "{$year}-12-31"],

        // Easter - calculated
        ['name' => 'Easter',            'date' => date('Y-m-d', easter_date($year))],

        // Mother's Day - 2nd Sunday in May
        ['name' => "Mother's Day",      'date' => $this->nthWeekdayOfMonth($year, 5, 0, 2)->format('Y-m-d')],

        // Father's Day - 3rd Sunday in June
        ['name' => "Father's Day",      'date' => $this->nthWeekdayOfMonth($year, 6, 0, 3)->format('Y-m-d')],

        // Halloween is fixed above
    ];

    $results = [];
    foreach ($extras as $extra) {
        $date = Carbon::parse($extra['date']);
        if ($date->gte($today)) {
            $slug = $this->slugify($extra['name']);
            $results[] = [
                'name'       => $extra['name'],
                'slug'       => $slug,
                'date'       => $date,
                'days_away'  => (int) $today->diffInDays($date),
                'formatted'  => $date->format('F j'),
                'day_of_week'=> $date->format('l'),
                'image'      => $this->getImage($slug),
                'type'       => 'holiday',
            ];
        }
    }

    return $results;
}

// Returns the Nth occurrence of a weekday in a given month
// $weekday: 0=Sunday, 1=Monday ... 6=Saturday
protected function nthWeekdayOfMonth(int $year, int $month, int $weekday, int $nth): Carbon
{
    $date = Carbon::create($year, $month, 1);
    $count = 0;
    while ($count < $nth) {
        if ($date->dayOfWeek === $weekday) {
            $count++;
            if ($count === $nth) break;
        }
        $date->addDay();
    }
    return $date;
}
}
