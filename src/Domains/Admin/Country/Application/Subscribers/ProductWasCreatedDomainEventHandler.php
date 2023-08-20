<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Events\ProductWasCreatedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\LoggerInterface;
use Project\Shared\Domain\MailerInterface;

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
        $this->logger->info(__METHOD__, $event->toArray());
        $this->mailer->send('testtt@gmail.com', __METHOD__, data: $event->toArray());
    }
}
