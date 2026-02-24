<?php

namespace App\Policies;

use App\Models\FamilyGroup;
use App\Models\User;

class FamilyGroupPolicy
{
    public function view(User $user, FamilyGroup $familyGroup): bool
    {
        return $familyGroup->members()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, FamilyGroup $familyGroup): bool
    {
        return $familyGroup->owner_id === $user->id;
    }
}
