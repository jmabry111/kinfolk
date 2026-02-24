<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\FamilyGroup;
use App\Models\Gift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    public function create(FamilyGroup $familyGroup, Contact $contact)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        return view('gifts.create', compact('familyGroup', 'contact'));
    }

    public function store(Request $request, FamilyGroup $familyGroup, Contact $contact)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        $request->validate([
            'description' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'url' => 'nullable|url|max:255',
            'is_public' => 'required|boolean',
        ]);

        Gift::create([
            'contact_id' => $contact->id,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'budget' => $request->budget,
            'url' => $request->url,
            'is_public' => $request->is_public,
            'is_purchased' => false,
        ]);

        return redirect()->route('contacts.show', [$familyGroup, $contact])
            ->with('success', 'Gift idea added!');
    }

    public function togglePurchased(FamilyGroup $familyGroup, Contact $contact, Gift $gift)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        if ($gift->is_purchased) {
            // Only the person who marked it purchased can unmark it
            if ($gift->purchased_by !== Auth::id()) {
                abort(403);
            }
            $gift->update([
                'is_purchased' => false,
                'purchased_by' => null,
            ]);
        } else {
            $gift->update([
                'is_purchased' => true,
                'purchased_by' => Auth::id(),
            ]);
        }

        return redirect()->route('contacts.show', [$familyGroup, $contact])
            ->with('success', 'Gift updated!');
    }

    public function destroy(FamilyGroup $familyGroup, Contact $contact, Gift $gift)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        // Only the person who added the gift can delete it
        if ($gift->user_id !== Auth::id()) {
            abort(403);
        }

        $gift->delete();

        return redirect()->route('contacts.show', [$familyGroup, $contact])
            ->with('success', 'Gift idea removed.');
    }

    public function edit(FamilyGroup $familyGroup, Contact $contact, Gift $gift)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        if ($gift->user_id !== Auth::id()) {
            abort(403);
        }

        return view('gifts.edit', compact('familyGroup', 'contact', 'gift'));
    }

    public function update(Request $request, FamilyGroup $familyGroup, Contact $contact, Gift $gift)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        if ($gift->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'description' => 'required|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'url' => 'nullable|url|max:255',
            'is_public' => 'required|boolean',
        ]);

        $gift->update([
            'description' => $request->description,
            'budget' => $request->budget,
            'url' => $request->url,
            'is_public' => $request->is_public,
        ]);

        return redirect()->route('contacts.show', [$familyGroup, $contact])
            ->with('success', 'Gift idea updated!');
    }
}
