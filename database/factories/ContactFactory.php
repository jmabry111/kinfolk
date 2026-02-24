<?php

namespace Database\Factories;

use App\Models\FamilyGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        $isKin = $this->faker->boolean(40); // 40% chance of being Kin

        $kinRelationships = ['Parent', 'Sibling', 'Child', 'Grandparent', 'Aunt/Uncle', 'Cousin', 'Spouse/Partner'];
        $folkRelationships = ['Friend', 'Coworker', 'Other'];

        $allInterests = [
            'cooking', 'outdoors', 'tech', 'reading', 'gaming', 'gardening',
            'travel', 'music', 'sports', 'fitness', 'art', 'movies', 'hiking',
            'photography', 'crafts', 'fashion', 'food', 'wine', 'coffee'
        ];

        return [
            'family_group_id' => FamilyGroup::factory(),
            'added_by' => User::factory(),
            'name' => $this->faker->name(),
            'relationship_type' => $isKin
                ? $this->faker->randomElement($kinRelationships)
                : $this->faker->randomElement($folkRelationships),
            'is_kin' => $isKin,
            'birthday' => $this->faker->dateTimeBetween('-80 years', '-5 years')->format('Y-m-d'),
            'interest_tags' => $this->faker->randomElements($allInterests, $this->faker->numberBetween(2, 5)),
        ];
    }
}
