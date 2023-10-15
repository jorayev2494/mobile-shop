<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Queries\Index;

use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly AuthManagerInterface $authManager,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
        
    }

    public function __invoke(Query $query)
    {
        $authorUuid = AuthorUuid::fromValue($this->authManager->uuid());
        $member = $this->cartRepository->findCartByAuthorUuid($authorUuid);

        $member ??= Cart::create(Uuid::fromValue($this->uuidGenerator->generate()), $authorUuid);

        return $member;
    }
}
