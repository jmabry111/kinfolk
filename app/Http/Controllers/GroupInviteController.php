<?php

namespace App\Http\Controllers;

use App\Models\FamilyGroup;
use App\Models\GroupInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupInviteController extends Controller
{
    public function create(FamilyGroup $familyGroup)
    {
        if ($familyGroup->owner_id !== Auth::id()) {
            abort(403);
        }

        // Generate a new invite token
        $invite = GroupInvite::create([
            'family_group_id' => $familyGroup->id,
            'created_by' => Auth::id(),
            'token' => Str::random(32),
            'expires_at' => now()->addDays(7),
        ]);

        $inviteUrl = route('invites.accept', $invite->token);

        return view('invites.created', compact('familyGroup', 'invite', 'inviteUrl'));
    }
public function accept(string $token)
{
    $invite = GroupInvite::where('token', $token)->firstOrFail();

    \Log::info('Invite accept called', [
        'token' => $token,
        'is_valid' => $invite->isValid(),
        'is_expired' => $invite->isExpired(),
        'is_used' => $invite->isUsed(),
        'auth_check' => Auth::check(),
        'user_id' => Auth::id(),
    ]);

    if (!$invite->isValid()) {
        return view('invites.invalid');
    }

    if (!Auth::check()) {
        session(['invite_token' => $token]);
        session()->save();
        return redirect()->route('login')
            ->with('message', 'Please log in or register to accept this invitation.');
    }

    $user = Auth::user();
    $group = $invite->familyGroup;

    \Log::info('Adding user to group', [
        'user_id' => $user->id,
        'group_id' => $group->id,
        'already_member' => $group->members()->where('user_id', $user->id)->exists(),
    ]);

    if ($group->members()->where('user_id', $user->id)->exists()) {
        return redirect()->route('family-groups.show', $group)
            ->with('message', 'You are already a member of this group.');
    }

    $group->members()->attach($user->id, ['role' => 'member']);
    $invite->update(['used_at' => now()]);

    return redirect()->route('family-groups.show', $group)
        ->with('success', 'You have joined ' . $group->name . '!');
}
}
