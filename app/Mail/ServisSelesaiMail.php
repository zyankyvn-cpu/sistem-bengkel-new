<?php

namespace App\Mail;

use App\Models\Servis;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServisSelesaiMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Servis $servis) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Servis Kendaraan Anda Telah Selesai',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.servis-selesai',
            with: ['servis' => $this->servis],
        );
    }
}