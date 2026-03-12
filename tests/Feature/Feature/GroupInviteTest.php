<?php

use App\Mail\WelcomeEmail;
use App\Models\FamilyGroup;
use App\Models\GroupInvite;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('owner can create an invite link', function () {
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    $response = $this->actingAs($user)
        ->get("/family-groups/{$group->id}/invite");

    $response->assertOk();
    $this->assertDatabaseHas('group_invites', ['family_group_id' => $group->id]);
});

test('non-owner cannot create an invite link', function () {
    $owner = User::factory()->create();
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $owner->id]);
    $group->members()->attach($owner->id, ['role' => 'owner']);
    $group->members()->attach($user->id, ['role' => 'member']);

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/invite")
        ->assertForbidden();
});

test('guest visiting invite link is redirected to login', function () {
    $invite = GroupInvite::factory()->create();

    $this->get("/invites/{$invite->token}")
        ->assertRedirect('/login');
});

test('authenticated user can accept a valid invite', function () {
    Mail::fake();

    $owner = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $owner->id]);
    $group->members()->attach($owner->id, ['role' => 'owner']);
    $invite = GroupInvite::factory()->create(['family_group_id' => $group->id, 'created_by' => $owner->id]);
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get("/invites/{$invite->token}")
        ->assertRedirect("/family-groups/{$group->id}");

    expect($group->members()->where('user_id', $user->id)->exists())->toBeTrue();
    expect($invite->fresh()->used_at)->not->toBeNull();
    Mail::assertSent(WelcomeEmail::class);
});

test('expired invite shows invalid page', function () {
    $invite = GroupInvite::factory()->expired()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get("/invites/{$invite->token}");

    $response->assertOk();
    $response->assertViewIs('invites.invalid');
});

test('used invite shows invalid page', function () {
    $invite = GroupInvite::factory()->used()->create();
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get("/invites/{$invite->token}");

    $response->assertOk();
    $response->assertViewIs('invites.invalid');
});

test('user already in group is redirected with message', function () {
    Mail::fake();

    $owner = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $owner->id]);
    $group->members()->attach($owner->id, ['role' => 'owner']);
    $invite = GroupInvite::factory()->create(['family_group_id' => $group->id, 'created_by' => $owner->id]);
    $user = User::factory()->create();
    $group->members()->attach($user->id, ['role' => 'member']);

    $this->actingAs($user)
        ->get("/invites/{$invite->token}")
        ->assertRedirect("/family-groups/{$group->id}");

    Mail::assertNotSent(WelcomeEmail::class);
});
