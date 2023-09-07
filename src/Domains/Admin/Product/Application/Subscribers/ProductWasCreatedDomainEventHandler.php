<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Events\ProductWasCreatedDomainEvent;
use Project\Domains\Admin\Product\Domain\Events\ProductWasDeletedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;

final class ProductWasCreatedDomainEventHandler implements DomainEventSubscriberInterface
{

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [ProductWasCreatedDomainEvent::class];
    }

    public function __invoke(ProductWasCreatedDomainEvent $event): void
    {
        $this->logger->info('ProductWasCreatedHandler', $event->toArray());
        // $this->mailer->send('test@gmail.com', 'ProductWasCreatedHandler', data: $event->toArray());
    }
}
