<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\FamilyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function create(FamilyGroup $familyGroup)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        return view('contacts.create', compact('familyGroup'));
    }

    public function store(Request $request, FamilyGroup $familyGroup)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'relationship_type' => 'required|string|max:255',
            'is_kin' => 'required|boolean',
            'birthday' => 'required|date',
            'interest_tags' => 'nullable|string',
        ]);

        $tags = null;
        if ($request->filled('interest_tags')) {
            $tags = array_map('trim', explode(',', $request->interest_tags));
        }

        Contact::create([
            'family_group_id' => $familyGroup->id,
            'added_by' => Auth::id(),
            'name' => $request->name,
            'relationship_type' => $request->relationship_type,
            'is_kin' => $request->is_kin,
            'birthday' => $request->birthday,
            'interest_tags' => $tags,
        ]);

        return redirect()->route('family-groups.show', $familyGroup)
            ->with('success', 'Contact added successfully!');
    }

    public function show(FamilyGroup $familyGroup, Contact $contact)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        $gifts = $contact->gifts()
            ->where(function($query) {
                $query->where('is_public', true)
                      ->orWhere('user_id', Auth::id());
            })
            ->get();

        return view('contacts.show', compact('familyGroup', 'contact', 'gifts'));
    }

    public function destroy(FamilyGroup $familyGroup, Contact $contact)
    {
        if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
            abort(403);
        }

        $contact->delete();
        return redirect()->route('family-groups.show', $familyGroup)
            ->with('success', 'Contact removed.');
    }
    public function edit(FamilyGroup $familyGroup, Contact $contact)
{
    if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
        abort(403);
    }

    return view('contacts.edit', compact('familyGroup', 'contact'));
}

public function update(Request $request, FamilyGroup $familyGroup, Contact $contact)
{
    if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
        abort(403);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'relationship_type' => 'required|string|max:255',
        'is_kin' => 'required|boolean',
        'birthday' => 'required|date',
        'interest_tags' => 'nullable|string',
    ]);

    $tags = null;
    if ($request->filled('interest_tags')) {
        $tags = array_map('trim', explode(',', $request->interest_tags));
    }

    $contact->update([
        'name' => $request->name,
        'relationship_type' => $request->relationship_type,
        'is_kin' => $request->is_kin,
        'birthday' => $request->birthday,
        'interest_tags' => $tags,
    ]);

    return redirect()->route('contacts.show', [$familyGroup, $contact])
        ->with('success', 'Contact updated successfully!');
}
}
