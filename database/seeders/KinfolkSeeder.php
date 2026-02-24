<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\FamilyGroup;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Database\Seeder;

class KinfolkSeeder extends Seeder
{
    public function run(): void
    {
        // Create a primary test user with known credentials
        $primaryUser = User::factory()->create([
            'name' => 'Jason',
            'email' => 'jason@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create a second user to simulate a family group member
        $secondUser = User::factory()->create([
            'name' => 'Pam',
            'email' => 'pam@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create 2 family groups owned by the primary user
        $groups = collect([
            FamilyGroup::create(['name' => 'The Johnson Family', 'owner_id' => $primaryUser->id]),
            FamilyGroup::create(['name' => 'Work Friends', 'owner_id' => $primaryUser->id]),
        ]);

        // Add both users to the first group
        $groups[0]->members()->attach($primaryUser->id, ['role' => 'owner']);
        $groups[0]->members()->attach($secondUser->id, ['role' => 'member']);

        // Add only primary user to the second group
        $groups[1]->members()->attach($primaryUser->id, ['role' => 'owner']);

        // Add contacts to each group with upcoming birthdays mixed in
        $groups->each(function (FamilyGroup $group) use ($primaryUser, $secondUser) {

            // Create some contacts with birthdays coming up soon (great for dashboard testing)
            $upcomingBirthdays = [7, 14, 21, 35, 60];
            foreach ($upcomingBirthdays as $daysFromNow) {
                $birthday = now()->subYears(rand(5, 70))->addDays($daysFromNow);
                $isKin = $group->name === 'The Johnson Family';

                $contact = Contact::create([
                    'family_group_id' => $group->id,
                    'added_by' => $primaryUser->id,
                    'name' => fake()->name(),
                    'relationship_type' => $isKin
                        ? fake()->randomElement(['Parent', 'Sibling', 'Child', 'Grandparent', 'Aunt/Uncle', 'Cousin'])
                        : fake()->randomElement(['Friend', 'Coworker']),
                    'is_kin' => $isKin,
                    'birthday' => $birthday->format('Y-m-d'),
                    'interest_tags' => fake()->randomElements(
                        ['cooking', 'outdoors', 'tech', 'reading', 'gaming', 'gardening', 'travel', 'music', 'sports', 'fitness'],
                        rand(2, 4)
                    ),
                ]);

                // Add 1-3 gift ideas per contact
                $giftCount = rand(1, 3);
                for ($i = 0; $i < $giftCount; $i++) {
                    $isPurchased = fake()->boolean(20);
                    Gift::create([
                        'contact_id' => $contact->id,
                        'user_id' => fake()->randomElement([$primaryUser->id, $secondUser->id]),
                        'description' => fake()->randomElement([
                            'Cast iron skillet', 'Kindle Paperwhite', 'Yeti tumbler', 'Cozy blanket',
                            'Board game', 'Cookbook', 'Bluetooth speaker', 'Hiking boots',
                            'Candle set', 'Coffee grinder', 'Yoga mat', 'Jigsaw puzzle',
                            'Noise cancelling headphones', 'Personalized photo book', 'Smart watch',
                        ]),
                        'budget' => fake()->randomElement([25, 50, 75, 100, 150, 200, null]),
                        'url' => fake()->boolean(30) ? fake()->url() : null,
                        'is_public' => fake()->boolean(70),
                        'is_purchased' => $isPurchased,
                        'purchased_by' => $isPurchased ? $primaryUser->id : null,
                    ]);
                }
            }

            // Add a few more random contacts without specific upcoming birthdays
            for ($i = 0; $i < 5; $i++) {
                Contact::create([
                    'family_group_id' => $group->id,
                    'added_by' => $primaryUser->id,
                    'name' => fake()->name(),
                    'relationship_type' => fake()->randomElement(['Parent', 'Sibling', 'Friend', 'Coworker', 'Cousin']),
                    'is_kin' => fake()->boolean(40),
                    'birthday' => fake()->dateTimeBetween('-80 years', '-5 years')->format('Y-m-d'),
                    'interest_tags' => fake()->randomElements(
                        ['cooking', 'outdoors', 'tech', 'reading', 'gaming', 'travel', 'music', 'sports'],
                        rand(2, 4)
                    ),
                ]);
            }
        });

        $this->command->info('Kinfolk seeded successfully!');
        $this->command->info('Primary user: jason@example.com / password');
        $this->command->info('Secondary user: pam@example.com / password');
    }
}
