<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Subscribers;

use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasCreatedDomainEvent;
use Project\Shared\Domain\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;

final class ProductWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProductWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ProductWasCreatedDomainEvent $event): void
    {
        $this->logger->info('ProductWasCreatedHandler', $event->toArray());

        $view = view('mail.admin.auth.restore_password_link', [
            'restoreLink' => $event->aggregateId(),
        ])->render();

        $mailMessage = (new Email())
                ->from(getenv('MAIL_FROM_ADDRESS'))
                ->to(getenv('MAIL_FROM_ADDRESS'))
                ->subject('Time for Symfony Mailer!')
                ->text('Sending emails is fun again!')
                ->html($view);

        $this->mailer->send($mailMessage);
        // $this->mailer->send('test@gmail.com', 'ProductWasCreatedHandler', data: $event->toArray());
    }
}
