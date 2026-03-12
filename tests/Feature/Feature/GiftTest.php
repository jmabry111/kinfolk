<?php

use App\Models\Contact;
use App\Models\FamilyGroup;
use App\Models\Gift;
use App\Models\User;

function groupWithMember(): array
{
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);
    $contact = Contact::factory()->create(['family_group_id' => $group->id, 'added_by' => $user->id]);
    return [$user, $group, $contact];
}

test('member can view the create gift form', function () {
    [$user, $group, $contact] = groupWithMember();

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/contacts/{$contact->id}/gifts/create")
        ->assertOk();
});

test('non-member cannot view the create gift form', function () {
    $user = User::factory()->create();
    [$owner, $group, $contact] = groupWithMember();

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/contacts/{$contact->id}/gifts/create")
        ->assertForbidden();
});

test('member can add a gift', function () {
    [$user, $group, $contact] = groupWithMember();

    $this->actingAs($user)->post("/family-groups/{$group->id}/contacts/{$contact->id}/gifts", [
        'description'       => 'Kindle Paperwhite',
        'budget'            => 100,
        'url'               => null,
        'is_public'         => true,
        'on_christmas_list' => false,
    ]);

    $this->assertDatabaseHas('gifts', ['description' => 'Kindle Paperwhite', 'contact_id' => $contact->id]);
});

test('member can add a gift to the christmas list', function () {
    [$user, $group, $contact] = groupWithMember();

    $this->actingAs($user)->post("/family-groups/{$group->id}/contacts/{$contact->id}/gifts", [
        'description'       => 'Cozy blanket',
        'budget'            => 50,
        'url'               => null,
        'is_public'         => true,
        'on_christmas_list' => true,
    ]);

    $this->assertDatabaseHas('gifts', [
        'description'       => 'Cozy blanket',
        'contact_id'        => $contact->id,
        'on_christmas_list' => true,
    ]);
});

test('gift requires a description', function () {
    [$user, $group, $contact] = groupWithMember();

    $response = $this->actingAs($user)->post("/family-groups/{$group->id}/contacts/{$contact->id}/gifts", [
        'description' => '',
        'is_public'   => true,
    ]);

    $response->assertSessionHasErrors('description');
});

test('member can toggle a gift as purchased', function () {
    [$user, $group, $contact] = groupWithMember();
    $gift = Gift::factory()->create([
        'contact_id'   => $contact->id,
        'user_id'      => $user->id,
        'is_purchased' => false,
    ]);

    $this->actingAs($user)
        ->patch("/family-groups/{$group->id}/contacts/{$contact->id}/gifts/{$gift->id}/toggle-purchased");

    expect($gift->fresh()->is_purchased)->toBeTrue();
    expect($gift->fresh()->purchased_by)->toBe($user->id);
});

test('only the purchaser can unmark a gift as purchased', function () {
    [$user, $group, $contact] = groupWithMember();
    $other = User::factory()->create();
    $group->members()->attach($other->id, ['role' => 'member']);
    $gift = Gift::factory()->create([
        'contact_id'   => $contact->id,
        'user_id'      => $user->id,
        'is_purchased' => true,
        'purchased_by' => $user->id,
    ]);

    $this->actingAs($other)
        ->patch("/family-groups/{$group->id}/contacts/{$contact->id}/gifts/{$gift->id}/toggle-purchased")
        ->assertForbidden();
});

test('member can delete their own gift', function () {
    [$user, $group, $contact] = groupWithMember();
    $gift = Gift::factory()->create(['contact_id' => $contact->id, 'user_id' => $user->id]);

    $this->actingAs($user)
        ->delete("/family-groups/{$group->id}/contacts/{$contact->id}/gifts/{$gift->id}")
        ->assertRedirect();

    $this->assertDatabaseMissing('gifts', ['id' => $gift->id]);
});

test('member cannot delete another members gift', function () {
    [$user, $group, $contact] = groupWithMember();
    $other = User::factory()->create();
    $group->members()->attach($other->id, ['role' => 'member']);
    $gift = Gift::factory()->create(['contact_id' => $contact->id, 'user_id' => $other->id]);

    $this->actingAs($user)
        ->delete("/family-groups/{$group->id}/contacts/{$contact->id}/gifts/{$gift->id}")
        ->assertForbidden();
});

test('member can view the christmas list', function () {
    [$user, $group, $contact] = groupWithMember();

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/christmas-list")
        ->assertOk();
});

test('non-member cannot view the christmas list', function () {
    $user = User::factory()->create();
    [$owner, $group, $contact] = groupWithMember();

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/christmas-list")
        ->assertForbidden();
});
