<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Queries\Get;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Favorite\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class GetFavoritesService
{
    public function __construct(
        private readonly MemberRepositoryInterface $memberRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly AuthManagerInterface $authManager,
    ) {

    }

    public function execute(GetFavoritesQuery $query): Paginator
    {
        return $this->productRepository->memberFavoriteProducts(
            MemberUuid::fromValue($this->authManager->uuid()),
            $query
        );
    }
}
