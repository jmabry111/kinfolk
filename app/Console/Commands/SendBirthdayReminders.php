<?php

namespace App\Console\Commands;

use App\Mail\BirthdayReminder;
use App\Models\Contact;
use App\Models\FamilyGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBirthdayReminders extends Command
{
    protected $signature = 'kinfolk:send-birthday-reminders';
    protected $description = 'Send birthday reminder emails for upcoming birthdays';

    public function handle()
    {
        $reminderDays = [30, 7];
        $sent = 0;

        foreach ($reminderDays as $days) {
            // Find contacts whose birthday falls exactly $days from now
            $contacts = Contact::with('familyGroup.members')->get()
                ->filter(fn($contact) => $contact->days_until_birthday === $days);

            foreach ($contacts as $contact) {
                $group = $contact->familyGroup;

                // Send reminder to each member of the family group
                foreach ($group->members as $member) {
                    Mail::to($member->email)->send(
                        new BirthdayReminder($contact, $days)
                    );
                    $sent++;
                    usleep(600000);
                }
            }
        }

        $this->info("Sent {$sent} birthday reminder emails.");
        return Command::SUCCESS;
    }
}
