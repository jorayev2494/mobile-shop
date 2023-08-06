<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Queries\Show;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class QueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(Query $query): Cart
    {
        $cart = $this->repository->findByUUID(CartUUID::fromValue($query->uuid));

        if ($cart === null) {
            throw new ModelNotFoundException();
        }

        return $cart;
    }
}
