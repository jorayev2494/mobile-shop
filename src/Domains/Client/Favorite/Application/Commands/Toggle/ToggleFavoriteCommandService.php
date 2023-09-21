<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Commands\Toggle;

use Project\Domains\Client\Favorite\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class ToggleFavoriteCommandService
{

    public function __construct(
        private readonly MemberRepositoryInterface $memberRepository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly AuthManagerInterface $authManager,
    )
    {

    }

    public function execute(ToggleFavoriteCommand $command): void
    {
        $member = $this->memberRepository->findByUuid(MemberUuid::fromValue($command->memberUuid));
        $product = $this->productRepository->findByUuid(ProductUuid::fromValue($command->productUuid));

        $member->getProducts()->contains($product) ? $member->removeProduct($product) : $member->addProduct($product);

        $this->memberRepository->save($member);

        // dd(
        //     $member,
        //     $product
        // );

        // $favorite = new Favorite(
        //     MemberUUID::fromValue($command->memberUUID),
        //     ProductUUID::fromValue($command->productUUID)
        // );

        // $this->repository->contains($favorite)  ? $this->repository->unfavorite($favorite)
        //                                         : $this->repository->favorite($favorite);
    }
}
