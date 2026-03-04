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

    $rules = [
        'name'               => 'required|string|max:255',
        'relationship_type'  => 'required|string|max:255',
        'is_kin'             => 'required|boolean',
        'interest_tags'      => 'nullable|string',
        'birth_year_unknown' => 'nullable|boolean',
        'generation'         => 'nullable|string|in:Gen Z,Millennial,Gen X,Baby Boomer,Silent Generation',
    ];

    if ($request->boolean('birth_year_unknown')) {
        $rules['birth_month'] = 'required|integer|min:1|max:12';
        $rules['birth_day']   = 'required|integer|min:1|max:31';
    } else {
        $rules['birthday'] = 'required|date';
    }

    $request->validate($rules);

    $tags = null;
    if ($request->filled('interest_tags')) {
        $tags = array_map('trim', explode(',', $request->interest_tags));
    }

    if ($request->boolean('birth_year_unknown')) {
        $birthday = \Carbon\Carbon::createFromDate(
            1900,
            $request->birth_month,
            $request->birth_day
        );
    } else {
        $birthday = $request->birthday;
    }

    Contact::create([
        'family_group_id'    => $familyGroup->id,
        'added_by'           => Auth::id(),
        'name'               => $request->name,
        'relationship_type'  => $request->relationship_type,
        'is_kin'             => $request->is_kin,
        'birthday'           => $birthday,
        'birth_year_unknown' => $request->boolean('birth_year_unknown'),
        'generation'         => $request->boolean('birth_year_unknown') ? $request->generation : null,
        'interest_tags'      => $tags,
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

    $rules = [
        'name'              => 'required|string|max:255',
        'relationship_type' => 'required|string|max:255',
        'is_kin'            => 'required|boolean',
        'interest_tags'     => 'nullable|string',
        'birth_year_unknown'=> 'nullable|boolean',
        'generation'        => 'nullable|string|in:Gen Z,Millennial,Gen X,Baby Boomer,Silent Generation',
    ];

    if ($request->boolean('birth_year_unknown')) {
        $rules['birth_month'] = 'required|integer|min:1|max:12';
        $rules['birth_day']   = 'required|integer|min:1|max:31';
    } else {
        $rules['birthday'] = 'required|date';
    }

    $request->validate($rules);

    $tags = null;
    if ($request->filled('interest_tags')) {
        $tags = array_map('trim', explode(',', $request->interest_tags));
    }

    if ($request->boolean('birth_year_unknown')) {
        $birthday = \Carbon\Carbon::createFromDate(
            1900,
            $request->birth_month,
            $request->birth_day
        );
    } else {
        $birthday = $request->birthday;
    }

    $contact->update([
        'name'               => $request->name,
        'relationship_type'  => $request->relationship_type,
        'is_kin'             => $request->is_kin,
        'birthday'           => $birthday,
        'birth_year_unknown' => $request->boolean('birth_year_unknown'),
        'generation'         => $request->boolean('birth_year_unknown') ? $request->generation : null,
        'interest_tags'      => $tags,
    ]);

    return redirect()->route('contacts.show', [$familyGroup, $contact])
        ->with('success', 'Contact updated successfully!');
}
}
