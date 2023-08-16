<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;

use Project\Domains\Client\Favorite\Domain\Favorite;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUUID;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUUID;
use Project\Domains\Client\Favorite\Infrastructure\Eloquent\FavoriteRepository;

final class ToggleFavoriteCommandService
{

    public function __construct(
        private readonly FavoriteRepository $repository,
    )
    {

    }

    public function execute(ToggleFavoriteCommand $command): void
    {
        $favorite = new Favorite(
            MemberUUID::fromValue($command->memberUUID),
            ProductUUID::fromValue($command->productUUID)
        );

        $this->repository->contains($favorite)  ? $this->repository->unfavorite($favorite)
                                                : $this->repository->favorite($favorite);
    }
}
