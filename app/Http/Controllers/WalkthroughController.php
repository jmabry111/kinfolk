<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalkthroughController extends Controller
{
    public function complete(Request $request)
    {
        Auth::user()->update(['walkthrough_completed' => true]);
        return response()->json(['success' => true]);
    }

    public function reset(Request $request)
    {
        Auth::user()->update(['walkthrough_completed' => false]);
        return back()->with('success', 'Tour reset! It will start on your next visit to the dashboard.');
    }
}
