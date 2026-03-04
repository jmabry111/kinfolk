<?php

namespace App\Mail;

use App\Models\Contact;
use App\Services\HolidayService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BirthdayReminder extends Mailable
{
    use Queueable, SerializesModels;

    public array $upcomingHolidays;

    public function __construct(
        public Contact $contact,
        public int $daysUntil
    ) {
        // Get holidays in the next 60 days
        $holidayService = new HolidayService();
        $this->upcomingHolidays = array_filter(
            $holidayService->getUpcomingHolidays(),
            fn($h) => $h['days_away'] <= 60
        );
    }

    public function envelope(): Envelope
    {
        $days = $this->daysUntil === 1 ? 'tomorrow' : "in {$this->daysUntil} days";
        return new Envelope(
            subject: "🎂 {$this->contact->name}'s birthday is {$days}!",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.birthday-reminder',
            with: [
                'upcomingHolidays' => array_values($this->upcomingHolidays),
            ]
        );
    }
}
