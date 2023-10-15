<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\DeleteProduct;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid as ValueObjectsUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly CartProductRepositoryInterface $cartProductRepository,
        private readonly AuthManagerInterface $authManager,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $cart = $this->repository->findCartByAuthorUuid(AuthorUuid::fromValue($this->authManager->uuid()));

        $cart ?? throw new ModelNotFoundException();

        $deleteProductUuid = ValueObjectsUuid::fromValue($command->productUuid);

        foreach ($cart->getCartProducts() as $cartProduct) {
            if ($cartProduct->getProduct()->getUuid()->isEquals($deleteProductUuid)) {
                $cart->removeProduct($cartProduct);
                $this->cartProductRepository->delete($cartProduct);
                break;
            }
        }

        $cart->isEmpty() ? $this->repository->delete($cart) : $this->repository->save($cart);
    }

}
