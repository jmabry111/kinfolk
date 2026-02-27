<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\FamilyGroup;
use App\Models\Gift;
use App\Models\User;
use Illuminate\Database\Seeder;

class SitcomSeeder extends Seeder
{
    public function run(): void
    {
        // Primary user
        $jason = User::factory()->create([
            'name' => 'Jason',
            'email' => 'jason@example.com',
            'password' => bcrypt('password'),
        ]);

        // Secondary user
        $pam = User::factory()->create([
            'name' => 'Pam',
            'email' => 'pam@example.com',
            'password' => bcrypt('password'),
        ]);

        // -------------------------------------------------------
        // GROUP 1: The Simpsons
        // -------------------------------------------------------
        $simpsons = FamilyGroup::create([
            'name' => 'The Simpsons',
            'owner_id' => $jason->id,
        ]);
        $simpsons->members()->attach($jason->id, ['role' => 'owner']);
        $simpsons->members()->attach($pam->id, ['role' => 'member']);

        $simpsonsContacts = [
            [
                'name' => 'Homer Simpson',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => '1956-05-12',
                'interest_tags' => ['food', 'beer', 'tv', 'bowling', 'napping'],
                'gifts' => [
                    ['description' => 'Donut of the Month Club', 'budget' => 50, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Duff Beer Six Pack', 'budget' => 15, 'is_public' => true, 'is_purchased' => true],
                ],
            ],
            [
                'name' => 'Marge Simpson',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => '1956-10-01',
                'interest_tags' => ['cooking', 'crafts', 'family', 'painting'],
                'gifts' => [
                    ['description' => 'Fancy Pearls Necklace', 'budget' => 75, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Cooking Masterclass Subscription', 'budget' => 100, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Bart Simpson',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => now()->addDays(7)->subYears(12)->format('Y-m-d'),
                'interest_tags' => ['skateboarding', 'pranks', 'comics', 'gaming'],
                'gifts' => [
                    ['description' => 'Skateboard', 'budget' => 60, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Itchy & Scratchy Comic Collection', 'budget' => 30, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Lisa Simpson',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => now()->addDays(30)->subYears(10)->format('Y-m-d'),
                'interest_tags' => ['music', 'reading', 'activism', 'jazz', 'science'],
                'gifts' => [
                    ['description' => 'Alto Saxophone Reeds', 'budget' => 25, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Encyclopedia Britannica Set', 'budget' => 200, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Maggie Simpson',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => now()->addDays(45)->subYears(1)->format('Y-m-d'),
                'interest_tags' => ['pacifiers', 'teddy bears'],
                'gifts' => [
                    ['description' => 'Giant Stuffed Panda', 'budget' => 40, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Grandpa Abe Simpson',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => '1920-09-17',
                'interest_tags' => ['stories', 'shuffleboard', 'napping', 'war memorabilia'],
                'gifts' => [
                    ['description' => 'Rocking Chair Cushion', 'budget' => 35, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
        ];

        // -------------------------------------------------------
        // GROUP 2: The Bundy Family (Married With Children)
        // -------------------------------------------------------
        $bundys = FamilyGroup::create([
            'name' => 'The Bundy Family',
            'owner_id' => $jason->id,
        ]);
        $bundys->members()->attach($jason->id, ['role' => 'owner']);

        $bundyContacts = [
            [
                'name' => 'Al Bundy',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => '1953-07-15',
                'interest_tags' => ['football', 'tv', 'complaining', 'no ma\'am'],
                'gifts' => [
                    ['description' => 'Chicago Bears Memorabilia', 'budget' => 50, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Shoe Horn', 'budget' => 10, 'is_public' => true, 'is_purchased' => true],
                ],
            ],
            [
                'name' => 'Peg Bundy',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => now()->addDays(7)->subYears(45)->format('Y-m-d'),
                'interest_tags' => ['shopping', 'tv', 'bonbon', 'hair'],
                'gifts' => [
                    ['description' => 'Hair Spray Set', 'budget' => 40, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Mall Gift Card', 'budget' => 100, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Kelly Bundy',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => now()->addDays(30)->subYears(22)->format('Y-m-d'),
                'interest_tags' => ['fashion', 'dating', 'tv', 'shopping'],
                'gifts' => [
                    ['description' => 'Fashion Magazine Subscription', 'budget' => 30, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Bud Bundy',
                'relationship_type' => 'Friend',
                'is_kin' => false,
                'birthday' => '1974-02-15',
                'interest_tags' => ['dating', 'gaming', 'get-rich-quick schemes'],
                'gifts' => [
                    ['description' => 'Self Help Book', 'budget' => 20, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Marcy Rhoades',
                'relationship_type' => 'Neighbor',
                'is_kin' => false,
                'birthday' => '1955-03-22',
                'interest_tags' => ['feminism', 'banking', 'birds', 'neighborhood watch'],
                'gifts' => [
                    ['description' => 'Bird Feeder', 'budget' => 35, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
        ];

        // -------------------------------------------------------
        // GROUP 3: The Office - Dunder Mifflin
        // -------------------------------------------------------
        $office = FamilyGroup::create([
            'name' => 'Dunder Mifflin Scranton',
            'owner_id' => $jason->id,
        ]);
        $office->members()->attach($jason->id, ['role' => 'owner']);
        $office->members()->attach($pam->id, ['role' => 'member']);

        $officeContacts = [
            [
                'name' => 'Michael Scott',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(7)->subYears(45)->format('Y-m-d'),
                'interest_tags' => ['improv', 'movies', 'his employees', 'magic'],
                'gifts' => [
                    ['description' => 'World\'s Best Boss Mug', 'budget' => 20, 'is_public' => true, 'is_purchased' => true],
                    ['description' => 'Improv Comedy Class', 'budget' => 150, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Dwight Schrute',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(30)->subYears(38)->format('Y-m-d'),
                'interest_tags' => ['beet farming', 'karate', 'survival', 'weapons', 'bears'],
                'gifts' => [
                    ['description' => 'Beet Seeds Collection', 'budget' => 25, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Nunchucks', 'budget' => 45, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'The Art of War Book', 'budget' => 15, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Jim Halpert',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1978-10-01',
                'interest_tags' => ['pranks', 'sports', 'sales', 'family'],
                'gifts' => [
                    ['description' => 'Philadelphia Eagles Jersey', 'budget' => 80, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Pam Beesly',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(60)->subYears(34)->format('Y-m-d'),
                'interest_tags' => ['art', 'painting', 'design', 'family'],
                'gifts' => [
                    ['description' => 'Watercolor Paint Set', 'budget' => 60, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Art Class Enrollment', 'budget' => 120, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Kevin Malone',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1968-06-01',
                'interest_tags' => ['food', 'poker', 'music', 'cooking'],
                'gifts' => [
                    ['description' => 'Giant Pot for Kevin\'s Famous Chili', 'budget' => 40, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Angela Martin',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1971-11-11',
                'interest_tags' => ['cats', 'accounting', 'church', 'judging others'],
                'gifts' => [
                    ['description' => 'Cat Calendar', 'budget' => 20, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Fancy Cat Treats', 'budget' => 30, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Andy Bernard',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(14)->subYears(42)->format('Y-m-d'),
                'interest_tags' => ['acapella', 'cornell', 'anger management', 'banjo'],
                'gifts' => [
                    ['description' => 'Cornell University Pennant', 'budget' => 25, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Banjo Lessons', 'budget' => 100, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Ryan Howard',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1983-05-05',
                'interest_tags' => ['startups', 'coffee', 'fashion', 'business'],
                'gifts' => [
                    ['description' => 'Artisan Coffee Subscription', 'budget' => 60, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
        ];

        // -------------------------------------------------------
        // GROUP 4: Modern Family - The Pritchetts
        // -------------------------------------------------------
        $modernFamily = FamilyGroup::create([
            'name' => 'The Pritchett-Dunphy-Tucker Clan',
            'owner_id' => $jason->id,
        ]);
        $modernFamily->members()->attach($jason->id, ['role' => 'owner']);
        $modernFamily->members()->attach($pam->id, ['role' => 'member']);

        $modernFamilyContacts = [
            [
                'name' => 'Jay Pritchett',
                'relationship_type' => 'Grandparent',
                'is_kin' => true,
                'birthday' => now()->addDays(7)->subYears(65)->format('Y-m-d'),
                'interest_tags' => ['golf', 'closets', 'football', 'cigars', 'dogs'],
                'gifts' => [
                    ['description' => 'Golf Club Set', 'budget' => 200, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Monogrammed Cigar Case', 'budget' => 75, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Gloria Pritchett',
                'relationship_type' => 'Grandparent',
                'is_kin' => true,
                'birthday' => now()->addDays(30)->subYears(40)->format('Y-m-d'),
                'interest_tags' => ['fashion', 'cooking', 'family', 'dancing', 'Colombia'],
                'gifts' => [
                    ['description' => 'Designer Handbag', 'budget' => 250, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Colombian Cookbook', 'budget' => 35, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Mitchell Pritchett',
                'relationship_type' => 'Sibling',
                'is_kin' => true,
                'birthday' => '1974-06-14',
                'interest_tags' => ['law', 'environment', 'theater', 'parenting'],
                'gifts' => [
                    ['description' => 'Environmental Law Book', 'budget' => 45, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Cameron Tucker',
                'relationship_type' => 'Sibling',
                'is_kin' => true,
                'birthday' => now()->addDays(14)->subYears(42)->format('Y-m-d'),
                'interest_tags' => ['theater', 'music', 'football', 'cooking', 'drama'],
                'gifts' => [
                    ['description' => 'Broadway Show Tickets', 'budget' => 180, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Clown Costume', 'budget' => 60, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Claire Dunphy',
                'relationship_type' => 'Sibling',
                'is_kin' => true,
                'birthday' => '1972-03-14',
                'interest_tags' => ['organization', 'parenting', 'wine', 'politics', 'running'],
                'gifts' => [
                    ['description' => 'Planner & Organization Set', 'budget' => 50, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Wine Subscription', 'budget' => 80, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Phil Dunphy',
                'relationship_type' => 'Sibling',
                'is_kin' => true,
                'birthday' => now()->addDays(60)->subYears(46)->format('Y-m-d'),
                'interest_tags' => ['magic', 'real estate', 'technology', 'dad jokes'],
                'gifts' => [
                    ['description' => 'Magic Trick Set', 'budget' => 55, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Latest iPad', 'budget' => 500, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Haley Dunphy',
                'relationship_type' => 'Child',
                'is_kin' => true,
                'birthday' => '1994-05-29',
                'interest_tags' => ['fashion', 'social media', 'photography', 'parenting'],
                'gifts' => [
                    ['description' => 'Camera Lens', 'budget' => 120, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Alex Dunphy',
                'relationship_type' => 'Child',
                'is_kin' => true,
                'birthday' => now()->addDays(21)->subYears(20)->format('Y-m-d'),
                'interest_tags' => ['science', 'reading', 'academics', 'violin'],
                'gifts' => [
                    ['description' => 'Kindle Paperwhite', 'budget' => 130, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Scientific American Subscription', 'budget' => 40, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Luke Dunphy',
                'relationship_type' => 'Child',
                'is_kin' => true,
                'birthday' => '1999-08-09',
                'interest_tags' => ['gaming', 'sports', 'mischief', 'food'],
                'gifts' => [
                    ['description' => 'Gaming Headset', 'budget' => 80, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Lily Tucker-Pritchett',
                'relationship_type' => 'Child',
                'is_kin' => true,
                'birthday' => now()->addDays(35)->subYears(14)->format('Y-m-d'),
                'interest_tags' => ['dance', 'sass', 'fashion', 'drama'],
                'gifts' => [
                    ['description' => 'Dance Class Enrollment', 'budget' => 100, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Manny Delgado',
                'relationship_type' => 'Child',
                'is_kin' => true,
                'birthday' => '2000-01-22',
                'interest_tags' => ['poetry', 'fashion', 'romance', 'culture', 'film'],
                'gifts' => [
                    ['description' => 'Poetry Collection Book', 'budget' => 30, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Beret & Scarf Set', 'budget' => 45, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
        ];

        // -------------------------------------------------------
        // GROUP 5: Superstore - Cloud 9
        // -------------------------------------------------------
        $superstore = FamilyGroup::create([
            'name' => 'Cloud 9 Crew',
            'owner_id' => $jason->id,
        ]);
        $superstore->members()->attach($jason->id, ['role' => 'owner']);

        $superstoreContacts = [
            [
                'name' => 'Amy Sosa',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(7)->subYears(35)->format('Y-m-d'),
                'interest_tags' => ['organization', 'parenting', 'ambition', 'reading'],
                'gifts' => [
                    ['description' => 'Day Planner', 'budget' => 30, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Business Leadership Book', 'budget' => 25, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Jonah Simms',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(30)->subYears(32)->format('Y-m-d'),
                'interest_tags' => ['politics', 'podcasts', 'social justice', 'running'],
                'gifts' => [
                    ['description' => 'Podcast Microphone', 'budget' => 80, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'NPR Tote Bag', 'budget' => 20, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Garrett McNeill',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1985-09-12',
                'interest_tags' => ['announcements', 'sarcasm', 'gaming', 'movies'],
                'gifts' => [
                    ['description' => 'Wireless Gaming Controller', 'budget' => 70, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Cheyenne Thompson',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(14)->subYears(24)->format('Y-m-d'),
                'interest_tags' => ['fashion', 'social media', 'makeup', 'parenting'],
                'gifts' => [
                    ['description' => 'Makeup Palette', 'budget' => 45, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Ring Light for Selfies', 'budget' => 35, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Mateo Liwanag',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1990-04-18',
                'interest_tags' => ['fashion', 'gossip', 'ambition', 'drama'],
                'gifts' => [
                    ['description' => 'Designer Belt', 'budget' => 90, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Dina Fox',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => now()->addDays(45)->subYears(38)->format('Y-m-d'),
                'interest_tags' => ['birds', 'authority', 'fitness', 'hunting'],
                'gifts' => [
                    ['description' => 'Bird Watching Binoculars', 'budget' => 65, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Hunting Gear Gift Card', 'budget' => 100, 'is_public' => false, 'is_purchased' => false],
                ],
            ],
            [
                'name' => 'Glenn Sturgis',
                'relationship_type' => 'Coworker',
                'is_kin' => false,
                'birthday' => '1965-12-25',
                'interest_tags' => ['religion', 'family', 'kindness', 'model trains'],
                'gifts' => [
                    ['description' => 'Model Train Set', 'budget' => 85, 'is_public' => true, 'is_purchased' => false],
                    ['description' => 'Bible with Personal Engraving', 'budget' => 40, 'is_public' => true, 'is_purchased' => false],
                ],
            ],
        ];

        // -------------------------------------------------------
        // Create all contacts and gifts
        // -------------------------------------------------------
        $groups = [
            [$simpsons, $simpsonsContacts],
            [$bundys, $bundyContacts],
            [$office, $officeContacts],
            [$modernFamily, $modernFamilyContacts],
            [$superstore, $superstoreContacts],
        ];

        foreach ($groups as [$group, $contacts]) {
            foreach ($contacts as $contactData) {
                $gifts = $contactData['gifts'] ?? [];
                unset($contactData['gifts']);

                $contact = Contact::create([
                    ...$contactData,
                    'family_group_id' => $group->id,
                    'added_by' => $jason->id,
                ]);

                foreach ($gifts as $giftData) {
                    $isPurchased = $giftData['is_purchased'];
                    Gift::create([
                        ...$giftData,
                        'contact_id' => $contact->id,
                        'user_id' => $jason->id,
                        'purchased_by' => $isPurchased ? $jason->id : null,
                    ]);
                }
            }
        }

        $this->command->info('Sitcom seed data created successfully!');
        $this->command->info('Primary user: jason@example.com / password');
        $this->command->info('Secondary user: pam@example.com / password');
    }
}
