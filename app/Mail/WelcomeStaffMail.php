<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeStaffMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $staff;

    public $plainPassword;

    public $saccoName;

    /**
     * Create a new message instance.
     */
    public function __construct(User $staff, string $plainPassword, string $saccoName)
    {
        $this->staff = $staff;
        $this->plainPassword = $plainPassword;
        $this->saccoName = $saccoName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to '.$this->saccoName.' - Your Staff Account Details',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.staff.welcome',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
