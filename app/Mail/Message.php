<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    protected $username;
    protected $email;
    protected $contenue;
    protected $telephone;
    public function __construct($username, $contenue, $email, $telephone)
    {
        $this->username = $username;
        $this->contenue = $contenue;
        $this->email = $email;
        $this->telephone = $telephone;

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message Visiteur',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $contenue = $this->contenue;
        $username = $this->username;
        $email = $this->email;
        $telephone = $this->telephone;
    
        // Use the with method to pass data to the view
        return (new Content())->view('message')->with(compact('username', 'contenue', 'email', 'telephone'));
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
