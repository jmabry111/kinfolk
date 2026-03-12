<?php

use App\Models\FamilyGroup;
use App\Models\User;

test('guests cannot access family groups', function () {
    $this->get('/family-groups')->assertRedirect('/login');
});

test('user can view their family groups index', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/family-groups');

    $response->assertOk();
});

test('user can view the create family group form', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/family-groups/create');

    $response->assertOk();
});

test('user can create a family group', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/family-groups', [
        'name' => 'The Simpsons',
    ]);

    $response->assertRedirect('/family-groups');
    $this->assertDatabaseHas('family_groups', ['name' => 'The Simpsons']);
});

test('creator is added as owner member of new group', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/family-groups', [
        'name' => 'The Simpsons',
    ]);

    $group = FamilyGroup::where('name', 'The Simpsons')->first();
    expect($group->members()->where('user_id', $user->id)->where('role', 'owner')->exists())->toBeTrue();
});

test('family group requires a name', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/family-groups', [
        'name' => '',
    ]);

    $response->assertSessionHasErrors('name');
});

test('user can view a family group they belong to', function () {
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    $response = $this->actingAs($user)->get("/family-groups/{$group->id}");

    $response->assertOk();
});

test('user cannot view a family group they do not belong to', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $other->id]);
    $group->members()->attach($other->id, ['role' => 'owner']);

    $response = $this->actingAs($user)->get("/family-groups/{$group->id}");

    $response->assertForbidden();
});

test('owner can delete their family group', function () {
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    $response = $this->actingAs($user)->delete("/family-groups/{$group->id}");

    $response->assertRedirect('/family-groups');
    $this->assertDatabaseMissing('family_groups', ['id' => $group->id]);
});

test('non-owner cannot delete a family group', function () {
    $owner = User::factory()->create();
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $owner->id]);
    $group->members()->attach($owner->id, ['role' => 'owner']);
    $group->members()->attach($user->id, ['role' => 'member']);

    $response = $this->actingAs($user)->delete("/family-groups/{$group->id}");

    $response->assertForbidden();
});
