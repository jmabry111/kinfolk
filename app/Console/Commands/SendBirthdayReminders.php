<?php

namespace App\Console\Commands;

use App\Mail\BirthdayReminder;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBirthdayReminders extends Command
{
    protected $signature = 'kinfolk:send-birthday-reminders';
    protected $description = 'Send birthday reminder emails for upcoming birthdays';

    public function handle()
    {
        $reminderDays = [7, 30];
        $sent = 0;

        // Get all contacts whose birthday is in exactly 7 or 30 days
        $contacts = Contact::with('familyGroup.members')->get()
            ->filter(fn($contact) => in_array($contact->days_until_birthday, $reminderDays));

        if ($contacts->isEmpty()) {
            $this->info('No birthdays to remind about today.');
            return Command::SUCCESS;
        }

        // Build a map of user_id -> all contacts they should be notified about
        $memberContacts = [];

        foreach ($contacts as $contact) {
            foreach ($contact->familyGroup->members as $member) {
                $memberContacts[$member->id]['user'] = $member;
                $memberContacts[$member->id]['contacts'][] = $contact;
            }
        }

        // Send ONE email per member containing all their relevant birthdays
        foreach ($memberContacts as $data) {
            $member         = $data['user'];
            $memberBirthdays = collect($data['contacts'])
                ->sortBy('days_until_birthday')
                ->values();

            Mail::to($member->email)->send(
                new BirthdayReminder($memberBirthdays, $member)
            );
            $sent++;
            usleep(600000); // 0.6s pause to stay under Resend rate limit
        }

        $this->info("Sent {$sent} birthday reminder emails.");
        return Command::SUCCESS;
    }
}
