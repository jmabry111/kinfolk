<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Models\FamilyGroup;
use App\Models\GroupInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GroupInviteController extends Controller
{
    public function create(FamilyGroup $familyGroup)
    {
        if ($familyGroup->owner_id !== Auth::id()) {
            abort(403);
        }

        $invite = GroupInvite::create([
            'family_group_id' => $familyGroup->id,
            'created_by'      => Auth::id(),
            'token'           => Str::random(32),
            'expires_at'      => now()->addDays(7),
        ]);

        $inviteUrl = route('invites.accept', $invite->token);

        return view('invites.created', compact('familyGroup', 'invite', 'inviteUrl'));
    }

    public function accept(string $token)
    {
        $invite = GroupInvite::where('token', $token)->firstOrFail();

        if (!$invite->isValid()) {
            return view('invites.invalid');
        }

        if (!Auth::check()) {
            session(['invite_token' => $token]);
            session()->save();
            return redirect()->route('login')
                ->with('message', 'Please log in or register to accept this invitation.');
        }

        $user  = Auth::user();
        $group = $invite->familyGroup;

        if ($group->members()->where('user_id', $user->id)->exists()) {
            return redirect()->route('family-groups.show', $group)
                ->with('message', 'You are already a member of this group.');
        }

        $group->members()->attach($user->id, ['role' => 'member']);
        $invite->update(['used_at' => now()]);

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user, $group));

        return redirect()->route('family-groups.show', $group)
            ->with('success', "Welcome! You've been added as a member of {$group->name}. Check your email for a quick guide to getting started.");
    }
}
