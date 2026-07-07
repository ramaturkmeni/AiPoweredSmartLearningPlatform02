<?php

namespace App\Mail;

use App\Models\Quiz;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewQuizPublished extends Mailable
{
    use Queueable, SerializesModels;

    // استقبال الموديل الخاص بالاختبار فقط 
    public function __construct(public Quiz $quiz) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'اختبار جديد متاح لمادة: ' . $this->quiz->lecture->course->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-quiz',
        );
    }
}
