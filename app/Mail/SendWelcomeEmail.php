<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Criar nova instância da mensagem.
     */
    public function __construct(public $user)
    {
        //
    }

    /**
     * Obtém o envelope da mensagem
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Boas vindas!!',
        );
    }

    /**
     * Obtém as informações do conteudo das mensagens
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sendWelcomeHtmlEmail',
            text: 'emails.sendWelcomeHtmlEmail',
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
