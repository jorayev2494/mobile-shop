<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

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
        public readonly float $price,
        public readonly int $discountPercentage,
        public readonly iterable $medias,
        public readonly string $description,
        public readonly bool $isActive,
    )
    {

    }
}
