<?php

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Project\Shared\Application\Command\Command;

final class UpdateProductCommand extends Command
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $categoryUUID,
        public readonly string $currencyUUID,
        public readonly string $price,
        public readonly int $discountPercentage,
        public readonly string $description,
        public readonly bool $isActive,
    )
    {

    }
}
