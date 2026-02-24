<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

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
                return $contact;
            })
            ->sortBy('days_away')
            ->values();

        $upcoming30  = $contacts->where('days_away', '<=', 30);
        $upcoming60  = $contacts->whereBetween('days_away', [31, 60]);
        $upcoming90  = $contacts->whereBetween('days_away', [61, 90]);

        return view('dashboard', compact('upcoming30', 'upcoming60', 'upcoming90'));
    }
}
