<?php

namespace App\Mail;

use App\Models\ForumPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PostApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    public function __construct(ForumPost $post)
    {
        $this->post = $post;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo về bài viết',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'components.notify_forum_post',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
