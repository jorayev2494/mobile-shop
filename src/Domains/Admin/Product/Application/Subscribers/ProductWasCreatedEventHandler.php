<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Events\ProductWasCreatedEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\LoggerInterface;
use Project\Shared\Domain\MailerInterface;

final class ProductWasCreatedEventHandler implements DomainEventSubscriberInterface
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [ProductWasCreatedEvent::class];
    }

    public function __invoke(ProductWasCreatedEvent $event): void
    {
        // dd('event', $event->data);
        $this->logger->info('ProductWasCreatedHandler', $event->toArray());
        $this->mailer->send('test@gmail.com', 'ProductWasCreatedHandler', data: $event->toArray());
    }
}
