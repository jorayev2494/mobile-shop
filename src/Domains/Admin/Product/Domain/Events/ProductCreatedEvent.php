<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Domain\Events;

use Project\Domains\Admin\Product\Domain\Product;
use Project\Shared\Domain\Bus\Event\DomainEvent;

class ProductCreatedEvent extends DomainEvent
{
    public const TYPE = 'product_created_event';

    public function __construct(
        private readonly Product $product
    )
    {
        
    }

    public function toArray(): array
    {
        return [
            'product' => $this->product->toArray(),
        ];
    }
}
