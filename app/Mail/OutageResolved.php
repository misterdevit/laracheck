<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OutageResolved extends Mailable
{
    use Queueable, SerializesModels;

    protected $site;

    protected $currentOutage;

    /**
     * Create a new message instance.
     */
    public function __construct($site, $currentOutage)
    {
        $this->site = $site;
        $this->currentOutage = $currentOutage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Site "'.$this->site->name.'" is UP!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.outage.resolved',
            with: [
                'site' => $this->site,
                'outage' => $this->currentOutage,

            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
