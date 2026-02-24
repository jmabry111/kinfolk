<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FamilyGroupFactory extends Factory
{
    public function definition(): array
    {
        $surnames = ['Johnson', 'Williams', 'Smith', 'Anderson', 'Martinez', 'Taylor', 'Brown', 'Wilson'];
        $surname = $this->faker->randomElement($surnames);

        return [
            'name' => $this->faker->randomElement([
                "The {$surname} Family",
                "{$surname} & Friends",
                "{$surname} Crew",
            ]),
            'owner_id' => User::factory(),
        ];
    }
}
