<?php

declare(strict_types=1);

namespace App\Mail\Admin\Auth;

use App\Models\Admin;
use App\Models\Auth\AuthModel;
use App\Models\Client;
use App\Models\Code;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRestoreLinkEmail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    // public $queue = QueueType::MAIL;

    private string $url;

    public string $restoreLink;

    public function __construct(
        private readonly AuthModel $authModel,
        private readonly Code $code,
    ) {
        if ($authModel instanceof Admin) {
            $this->url = config('admin_dashboard.admin_url') . config('admin_dashboard.page_routers.reset_password');
        } elseif ($authModel instanceof Client) {
            // $this->url = config('admin_dashboard.admin_url');
        }

        $this->restoreLink = $this->url . '?' . http_build_query(['token' => $code->token]);
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
