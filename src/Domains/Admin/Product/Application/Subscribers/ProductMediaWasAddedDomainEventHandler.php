<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Events\ProductMediaWasAddedDomainEvent;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;
use Project\Shared\Domain\FilesystemInterface;

class ProductMediaWasAddedDomainEventHandler implements DomainEventSubscriberInterface
{

    public function __construct(
        private readonly FilesystemInterface $filesystem,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            ProductMediaWasAddedDomainEvent::class,
        ];     
    }

    public function __invoke(): void
    {
        
    }
}
