<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $text)
    {
        $this->name = $name;
        $this->email = $email;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact_message')
                    ->subject('Üzeneted érkezett')
                    ->from($this->email, $this->name)
                    ->replyTo($this->email, $this->name)
                    ->with([
                        'name' => $this->name,
                        'email' => $this->email,
                        'text' => $this->text,
                    ]);
    }
}
