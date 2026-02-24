<?php

namespace App\Http\Controllers;

use App\Models\FamilyGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyGroupController extends Controller
{
    public function index()
    {
        $groups = Auth::user()->familyGroups()->with('owner')->get();
        return view('family-groups.index', compact('groups'));
    }

    public function create()
    {
        return view('family-groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = FamilyGroup::create([
            'name' => $request->name,
            'owner_id' => Auth::id(),
        ]);

        // Add the creator as a member with owner role
        $group->members()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('family-groups.index')
            ->with('success', 'Family group created successfully!');
    }

    public function show(FamilyGroup $familyGroup)
{
    if (!$familyGroup->members()->where('user_id', Auth::id())->exists()) {
        abort(403);
    }

    $members = $familyGroup->members()->get();
    $contacts = $familyGroup->contacts()->orderBy('name')->get();
    return view('family-groups.show', compact('familyGroup', 'members', 'contacts'));
}

public function destroy(FamilyGroup $familyGroup)
{
    if ($familyGroup->owner_id !== Auth::id()) {
        abort(403);
    }

    $familyGroup->delete();
    return redirect()->route('family-groups.index')
        ->with('success', 'Family group deleted.');
}
}
