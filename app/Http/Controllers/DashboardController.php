<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\HolidayService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all family group IDs the user belongs to
        $groupIds = $user->familyGroups()->pluck('family_groups.id');

        // Get all contacts from those groups
        $contacts = Contact::whereIn('family_group_id', $groupIds)
            ->get()
            ->map(function ($contact) {
                $contact->days_away = $contact->days_until_birthday;
                $contact->type = 'birthday';
                return $contact;
            })
            ->sortBy('days_away')
            ->values();

        // Get upcoming holidays
        $holidayService = new HolidayService();
        $allHolidays    = $holidayService->getUpcomingHolidays();

        // Split holidays into within-90-days and later
        $holidaysWithin90 = collect(array_filter($allHolidays, fn($h) => $h['days_away'] <= 90));
        $holidaysLater    = collect(array_filter($allHolidays, fn($h) => $h['days_away'] > 90));

        // Merge and sort birthday + holiday sections
        $upcoming30 = $this->mergeSorted(
            $contacts->where('days_away', '<=', 30),
            $holidaysWithin90->where('days_away', '<=', 30)
        );

        $upcoming60 = $this->mergeSorted(
            $contacts->whereBetween('days_away', [31, 60]),
            $holidaysWithin90->filter(fn($h) => $h['days_away'] >= 31 && $h['days_away'] <= 60)
        );

        $upcoming90 = $this->mergeSorted(
            $contacts->whereBetween('days_away', [61, 90]),
            $holidaysWithin90->filter(fn($h) => $h['days_away'] >= 61 && $h['days_away'] <= 90)
        );

        $laterHolidays = $holidaysLater->sortBy('days_away')->values();

        return view('dashboard', compact(
            'upcoming30',
            'upcoming60',
            'upcoming90',
            'laterHolidays'
        ));
    }

    protected function mergeSorted($birthdays, $holidays): Collection
      {
          return collect($birthdays->values())
            ->concat($holidays->values())
            ->sortBy('days_away')
            ->values();
      }
}
