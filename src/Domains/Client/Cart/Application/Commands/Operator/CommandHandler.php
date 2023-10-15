<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Operator;

use DomainException;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\AuthorUuid;
use Project\Domains\Client\Cart\Domain\CartProduct\ValueObjects\Quantity;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        $cart = $this->cartRepository->findCartByAuthorUuid(AuthorUuid::fromValue($this->authManager->uuid()));

        if ($cart === null) {
            throw new DomainException('Cart not found');
        }

        $operatorProductUuid = Uuid::fromValue($command->productUuid);

        foreach ($cart->getCartProducts() as $cartProduct) {
            if ($cartProduct->getProduct()->getUuid()->isEquals($operatorProductUuid)) {
                $quantityValue = $cartProduct->getQuantity()->value;
                $operatorValue = (int) $command->operatorValue;
                if ($quantityValue !== null) {
                    if ($command->operator === 'increment') {
                        $quantityValue += $operatorValue;
                    }
                    if ($command->operator === 'decrement' && $quantityValue > $operatorValue) {
                        $quantityValue -= $operatorValue;
                    }
                    $cartProduct->setQuantity(Quantity::fromValue($quantityValue));
                }
            }
        }

        $this->cartRepository->save($cart);
    }
}
