<?php

use App\Console\Commands\SendBirthdayReminders;
use App\Mail\BirthdayReminder;
use App\Models\Contact;
use App\Models\FamilyGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

function birthdayInDays(int $days): string
{
    return now()->addDays($days + 1)->setYear(1990)->format('Y-m-d');
}

test('command sends no emails when no birthdays are upcoming', function () {
    Mail::fake();

    $this->artisan('kinfolk:send-birthday-reminders')
        ->expectsOutput('No birthdays to remind about today.')
        ->assertExitCode(0);

    Mail::assertNothingSent();
});

test('command sends email for contact with birthday in 7 days', function () {
    Mail::fake();

    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    $birthday = now()->setYear(1990)->addDays(8)->format('Y-m-d');
    Contact::factory()->create([
        'family_group_id' => $group->id,
        'added_by'        => $user->id,
        'birthday'        => $birthday,
    ]);

    $this->artisan('kinfolk:send-birthday-reminders')
        ->assertExitCode(0);

    Mail::assertSent(BirthdayReminder::class);
});

test('command sends email for contact with birthday in 30 days', function () {
    Mail::fake();

    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    $birthday = now()->setYear(1990)->addDays(31)->format('Y-m-d');
    Contact::factory()->create([
        'family_group_id' => $group->id,
        'added_by'        => $user->id,
        'birthday'        => $birthday,
    ]);

    $this->artisan('kinfolk:send-birthday-reminders')
        ->assertExitCode(0);

    Mail::assertSent(BirthdayReminder::class);
});

test('command sends one email per member not per contact', function () {
    Mail::fake();

    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    // Two contacts with birthdays in 7 days
    $birthday = now()->setYear(1990)->addDays(8)->format('Y-m-d');
    Contact::factory()->count(2)->create([
        'family_group_id' => $group->id,
        'added_by'        => $user->id,
        'birthday'        => $birthday,
    ]);

    $this->artisan('kinfolk:send-birthday-reminders')
        ->assertExitCode(0);

    Mail::assertSent(BirthdayReminder::class, 1);
});

test('command sends separate emails to each member', function () {
    Mail::fake();

    $owner = User::factory()->create();
    $member = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $owner->id]);
    $group->members()->attach($owner->id, ['role' => 'owner']);
    $group->members()->attach($member->id, ['role' => 'member']);

    $birthday = now()->setYear(1990)->addDays(8)->format('Y-m-d');
    Contact::factory()->create([
        'family_group_id' => $group->id,
        'added_by'        => $owner->id,
        'birthday'        => $birthday,
    ]);

    $this->artisan('kinfolk:send-birthday-reminders')
        ->assertExitCode(0);

    Mail::assertSent(BirthdayReminder::class, 2);
});

test('command does not send email for birthday not in reminder window', function () {
    Mail::fake();

    $user = User::factory()->create();
    $group = FamilyGroup::factory()->create(['owner_id' => $user->id]);
    $group->members()->attach($user->id, ['role' => 'owner']);

    // Birthday in 15 days - not in reminder window
    $birthday = now()->setYear(1990)->addDays(15)->format('Y-m-d');
    Contact::factory()->create([
        'family_group_id' => $group->id,
        'added_by'        => $user->id,
        'birthday'        => $birthday,
    ]);

    $this->artisan('kinfolk:send-birthday-reminders')
        ->expectsOutput('No birthdays to remind about today.')
        ->assertExitCode(0);

    Mail::assertNothingSent();
});
