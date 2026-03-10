<?php

namespace App\Mail;

use App\Models\FamilyGroup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $verse;

    public function __construct(
        public User $recipient,
        public FamilyGroup $group,
    ) {
        $verses = json_decode(file_get_contents(public_path('verses.json')), true);
        $this->verse = $verses[array_rand($verses)];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Welcome to Kinfolk! You've joined {$this->group->name} 🎉",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.welcome',
        );
    }
}
