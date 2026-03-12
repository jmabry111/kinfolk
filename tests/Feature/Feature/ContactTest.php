<?php

use App\Models\Contact;
use App\Models\FamilyGroup;
use App\Models\User;

function groupWithOwner(): array
{
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);
    return [$user, $group];
}

test('guests cannot access contacts', function () {
    $group = FamilyGroup::factory()->create();
    $this->get("/family-groups/{$group->id}/contacts/create")->assertRedirect('/login');
});

test('non-member cannot create a contact', function () {
    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create();

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/contacts/create")
        ->assertForbidden();
});

test('member can view the create contact form', function () {
    [$user, $group] = groupWithOwner();

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/contacts/create")
        ->assertOk();
});

test('member can create a contact with a known birthday', function () {
    [$user, $group] = groupWithOwner();

    $this->actingAs($user)->post("/family-groups/{$group->id}/contacts", [
        'name'              => 'John Doe',
        'relationship_type' => 'Friend',
        'is_kin'            => false,
        'birthday'          => '1990-05-15',
        'birth_year_unknown'=> false,
        'interest_tags'     => 'music, travel',
    ]);

    $this->assertDatabaseHas('contacts', ['name' => 'John Doe', 'family_group_id' => $group->id]);
});

test('member can create a contact with unknown birth year', function () {
    [$user, $group] = groupWithOwner();

    $this->actingAs($user)->post("/family-groups/{$group->id}/contacts", [
        'name'               => 'Jane Doe',
        'relationship_type'  => 'Sibling',
        'is_kin'             => true,
        'birth_year_unknown' => true,
        'birth_month'        => 6,
        'birth_day'          => 20,
        'generation'         => 'Millennial',
    ]);

    $this->assertDatabaseHas('contacts', ['name' => 'Jane Doe', 'birth_year_unknown' => true]);
});

test('contact requires a name', function () {
    [$user, $group] = groupWithOwner();

    $response = $this->actingAs($user)->post("/family-groups/{$group->id}/contacts", [
        'name'              => '',
        'relationship_type' => 'Friend',
        'is_kin'            => false,
        'birthday'          => '1990-05-15',
    ]);

    $response->assertSessionHasErrors('name');
});

test('member can view a contact', function () {
    [$user, $group] = groupWithOwner();
    $contact = Contact::factory()->create(['family_group_id' => $group->id, 'added_by' => $user->id]);

    $this->actingAs($user)
        ->get("/family-groups/{$group->id}/contacts/{$contact->id}")
        ->assertOk();
});

test('member can delete a contact', function () {
    [$user, $group] = groupWithOwner();
    $contact = Contact::factory()->create(['family_group_id' => $group->id, 'added_by' => $user->id]);

    $this->actingAs($user)
        ->delete("/family-groups/{$group->id}/contacts/{$contact->id}")
        ->assertRedirect("/family-groups/{$group->id}");

    $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
});

test('non-member cannot delete a contact', function () {
    $user = User::factory()->create();
    [$owner, $group] = groupWithOwner();
    $contact = Contact::factory()->create(['family_group_id' => $group->id, 'added_by' => $owner->id]);

    $this->actingAs($user)
        ->delete("/family-groups/{$group->id}/contacts/{$contact->id}")
        ->assertForbidden();
});
