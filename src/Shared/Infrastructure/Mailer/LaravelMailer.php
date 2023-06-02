<?php

declare(strict_types=1);

namespace Project\Shared\Infrastructure\Mailer;

use App\Mail\Auth\SendRestoreLinkEmail;
use Illuminate\Contracts\Mail\Mailer;
use Project\Shared\Domain\MailerInterface;

final class LaravelMailer implements MailerInterface
{
    public function __construct(
        private readonly Mailer $mailer,
    )
    {
        
    }

    public function send(string $to, string $text = '', string $view = null, array $data = []): void
    {
        $mail = $this->mailer->to($to)->send(new SendRestoreLinkEmail($data));
        // $mail = $this->mailer->to($to)->send([$text]);
    }
}
