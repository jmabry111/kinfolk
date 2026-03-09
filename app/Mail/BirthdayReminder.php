<?php

namespace App\Mail;

use App\Services\HolidayService;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class BirthdayReminder extends Mailable
{
    use Queueable, SerializesModels;

    public array $upcomingHolidays;
    public Collection $contacts;

    public function __construct(
        Collection $contacts,
        public User $recipient,
    ) {
        $this->contacts = $contacts->sortBy('days_until_birthday')->values();

        // Get holidays in the next 60 days
        $holidayService = new HolidayService();
        $this->upcomingHolidays = array_values(array_filter(
            $holidayService->getUpcomingHolidays(),
            fn($h) => $h['days_away'] <= 60
        ));
    }

    public function envelope(): Envelope
    {
        $count = $this->contacts->count();
        $subject = $count === 1
            ? "🎂 {$this->contacts->first()->name}'s birthday is coming up!"
            : "🎂 {$count} birthdays coming up!";

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.birthday-reminder',
            with: [
                'contacts'         => $this->contacts,
                'upcomingHolidays' => $this->upcomingHolidays,
                'recipient'        => $this->recipient,
            ]
        );
    }
}
