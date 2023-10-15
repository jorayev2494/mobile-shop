<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\AddProduct;

use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\StatusEnum;
use Project\Domains\Client\Cart\Domain\CartProduct\CartProduct;
use Project\Domains\Client\Cart\Domain\CartProduct\ValueObjects\Quantity;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\Uuid;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid as ValueObjectsUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\UuidGeneratorInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;
use Project\Shared\Domain\DomainException;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly AuthManagerInterface $authManager,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $authorUuid = AuthorUuid::fromValue($this->authManager->uuid());
        $cart = $this->repository->findCartByAuthorUuid($authorUuid);
        
        $cart ??= Cart::create(Uuid::fromValue($this->uuidGenerator->generate()), $authorUuid);

        if ($cart->getStatus()->isNotEquals(StatusEnum::DRAFT)) {
            throw new DomainException("This cart is ordered");
        }

        $product = $this->productRepository->findByUuid(ValueObjectsUuid::fromValue($command->productUuid));

        $productIsNotCart = true;
        foreach ($cart->getCartProducts() as $key => $cartProduct) {
            if ($cartProduct->getProduct()->getUuid()->isEquals($product->getUuid())) {
                $productIsNotCart = false;
                $cartProduct->setQuantity(Quantity::fromValue($command->quantity));
            }
        }

        if ($productIsNotCart) {
            $cart->addCartProduct(CartProduct::create($product, Quantity::fromValue($command->quantity)));
        }

        $this->repository->save($cart);
    }
}
