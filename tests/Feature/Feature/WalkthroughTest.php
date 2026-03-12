<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

test('new users have walkthrough_completed set to false', function () {
    $user = User::factory()->create();
    expect($user->walkthrough_completed)->toBeFalse();
});

test('authenticated user can complete the walkthrough', function () {
    $user = User::factory()->create(['walkthrough_completed' => false]);
        $response = $this->actingAs($user, 'web')
        ->post('/walkthrough/complete');

      $response->assertOk();
      $response->assertJson(['success' => true]);
      expect($user->fresh()->walkthrough_completed)->toBeTrue();
});
test('authenticated user can reset the walkthrough', function () {
    $user = User::factory()->create(['walkthrough_completed' => true]);

    $this->actingAs($user)->post('/walkthrough/reset');

    expect($user->fresh()->walkthrough_completed)->toBeFalse();
});

test('guests cannot complete the walkthrough', function () {
    $this->post('/walkthrough/complete')->assertRedirect('/login');
});

test('guests cannot reset the walkthrough', function () {
    $this->post('/walkthrough/reset')->assertRedirect('/login');
});
