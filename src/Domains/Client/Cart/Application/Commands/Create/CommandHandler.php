<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Create;

use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartClientUUID;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductCurrencyUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductDiscountPercentage;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductQuality;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductUUID;
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
        $cart = Cart::create(
            CartUUID::fromValue($command->uuid),
            CartClientUUID::fromValue($this->authManager->client()->uuid),
            $this->loadProducts($command)
        );
        
        $this->repository->save($cart);
    }

    private function loadProducts(Command $command): iterable
    {
        $products = [];

        foreach ($command->products as $key => [
            'uuid' => $uuid,
            'currency_uuid' => $currencyUUID,
            'quality' => $quality,
            'price' => $price,
            'discount_percentage' => $discountPercentage,
        ]) {
            $price = ((float) $price) * $quality;
            $discountPercentage = ((float) $discountPercentage) * $quality;

            $products[] = Product::create(
                ProductUUID::fromValue($uuid),
                ProductCurrencyUUID::fromValue($currencyUUID),
                ProductQuality::fromValue($quality),
                ProductPrice::fromValue((string) $price),
                ProductDiscountPercentage::fromValue((string) $discountPercentage)
            );
        }

        return $products;
    }
}
