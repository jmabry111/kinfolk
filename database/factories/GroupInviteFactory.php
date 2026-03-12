<?php

namespace Database\Factories;

use App\Models\FamilyGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupInviteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'family_group_id' => FamilyGroup::factory(),
            'created_by'      => User::factory(),
            'token'           => Str::random(32),
            'expires_at'      => now()->addDays(7),
            'used_at'         => null,
        ];
    }

    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'expires_at' => now()->subDays(1),
        ]);
    }

    public function used(): static
    {
        return $this->state(fn (array $attributes) => [
            'used_at' => now()->subHour(),
        ]);
    }
}
