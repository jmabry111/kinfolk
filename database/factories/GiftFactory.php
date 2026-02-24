<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GiftFactory extends Factory
{
    public function definition(): array
    {
        $isPurchased = $this->faker->boolean(25); // 25% chance already purchased
        $isPublic = $this->faker->boolean(70); // 70% chance public

        $giftIdeas = [
            'Cast iron skillet', 'Kindle Paperwhite', 'Yeti tumbler', 'Cozy blanket',
            'Gift card', 'Board game', 'Cookbook', 'Bluetooth speaker', 'Hiking boots',
            'Candle set', 'Wine subscription', 'Coffee grinder', 'Yoga mat',
            'National Parks pass', 'Personalized photo book', 'Smart watch',
            'Noise cancelling headphones', 'Garden tool set', 'Jigsaw puzzle',
            'Movie night basket', 'Spa gift set', 'Leather wallet', 'Running shoes',
        ];

        return [
            'contact_id' => Contact::factory(),
            'user_id' => User::factory(),
            'description' => $this->faker->randomElement($giftIdeas),
            'budget' => $this->faker->randomElement([25, 50, 75, 100, 150, 200, null]),
            'url' => $this->faker->boolean(40) ? $this->faker->url() : null,
            'is_public' => $isPublic,
            'is_purchased' => $isPurchased,
            'purchased_by' => $isPurchased ? User::factory() : null,
        ];
    }
}
