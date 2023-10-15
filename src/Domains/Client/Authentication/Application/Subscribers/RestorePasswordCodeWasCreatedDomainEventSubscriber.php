<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Application\Subscribers;

use Project\Domains\Client\Authentication\Domain\Code\Events\RestorePasswordCodeWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class RestorePasswordCodeWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            RestorePasswordCodeWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(RestorePasswordCodeWasCreatedDomainEvent $event): void
    {
        $view = view('mail.client.auth.restore_password_code', [
            'restoreLink' => 'blablabla22',
            'code' => $event->code,
        ])->render();

        $message = (new Email())
                ->from(getenv('MAIL_FROM_ADDRESS'))
                ->to($event->email)
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html($view);

        $this->mailer->send($message);
    }
}
