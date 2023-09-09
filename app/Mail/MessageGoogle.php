<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MessageGoogle extends Mailable
{
    use Queueable, SerializesModels;

    public $data;   #Données pour la vue

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: isset($this->data['url'])? 'Souscription Tech Briva stock' : 'new massage Tech Briva',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        if (isset($this->data['url'])) {
            return new Content(
                view: 'emails.suscription-email',
            );
        }
        return new Content(
            view: 'emails.contact-email',
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

    public function build()
    {
        if (isset($this->data['url'])) {
            return $this->from("granttiwa0@gmail.com") // L'expéditeur
                    ->subject("Message via le SMTP Google") // Le sujet
                    ->view('emails.suscription-email'); // La vue
        }
        return $this->from("granttiwa0@gmail.com") // L'expéditeur
                    ->subject("Message via le SMTP Google") // Le sujet
                    ->view('emails.contact-email'); // La vue
    }
}
