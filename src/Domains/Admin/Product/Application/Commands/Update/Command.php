<?php

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Project\Shared\Domain\Bus\Command\CommandInterface;

/**
 * @property-read \Illuminate\Http\UploadedFile[] $medias
 */
final class Command implements CommandInterface
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $title,
        public readonly string $categoryUuid,
        public readonly string $currencyUuid,
        public readonly string $price,
        public readonly string $discountPercentage,
        public readonly iterable $medias,
        public readonly array $removeMediaIds,
        public readonly string $description,
        public readonly bool $isActive,
    )
    {

    }
}
