<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\DeleteProduct;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $cart = $this->repository->findByUUID(CartUUID::fromValue($command->uuid));

        if ($cart === null) {
            throw new ModelNotFoundException();
        }

        $removeProduct = Product::fromPrimitives(
            $command->productUUID,
            $command->productCurrencyUUID,
            $command->productQuality,
            $command->productPrice,
            $command->productDiscountPercentage,
        );

        $cart->removeProduct($removeProduct);
        $this->repository->save($cart);
        
        // Delete cart if no products
        if (count($cart->getProducts()) === 0) {
            $this->repository->delete(CartUUID::fromValue($command->uuid));
        }       
    }

}
