<?php

namespace App\Mail\Admin\Auth;

use App\Jobs\Enums\QueueType;
use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Code;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRestoreLinkEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // public $queue = QueueType::MAIL;

    public string $restoreLink;

    public function __construct(
        private readonly AuthModel&Admin $authModel,
        private readonly Code $code,
    ) {
        $this->restoreLink = config('admin_dashboard.page_routers.reset_password').'?'.http_build_query(['token' => $code->token, 'restored-type' => $this->authModel->getTable()]);
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Send Restore Link Email',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.admin.auth.restore_password_link',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
