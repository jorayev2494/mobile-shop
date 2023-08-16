<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\Create;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartClientUUID;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductCurrencyUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductDiscountPercentage;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductPrice;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductQuality;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductUUID;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CartRepositoryInterface $repository,
        private readonly ProductRepositoryInterface $productRepository,
        private readonly AuthManagerInterface $authManager,
    )
    {
        
    }

    public function __invoke(Command $command): void
    {
        // $cart = $this->repository->findClientCartByClientUUID(CartClientUUID::fromValue($this->authManager->client()->uuid));

        // if ($cart === null) {   
            $cart = Cart::create(
                CartUUID::fromValue($command->uuid),
                CartClientUUID::fromValue($this->authManager->client()->uuid)
            );
        // }

        $cart->addProduct($this->makeProduct($command));
        $this->repository->save($cart);
    }

    private function makeProduct(Command $command): Product
    {
        $product = $this->productRepository->findByUuid(ProductUUID::fromValue($command->productUuid));

        $product ?? throw new ModelNotFoundException("Product not found");

        $productPrice = ((float) $product->price->value) * $command->productQuality;
        $productDiscountPercentage = ((float) $product->discountPercentage->value) * $command->productQuality;

        $product = Product::create(
            $product->uuid,
            $product->title,
            $product->categoryUUID,
            $product->currencyUUID,
            $product->price,
            $product->discountPercentage,
            $product->viewedCount,
            
            CartProductCurrencyUUID::fromValue($product->currencyUUID->value),
            CartProductQuality::fromValue($command->productQuality),
            CartProductPrice::fromValue((string) $productPrice),
            CartProductDiscountPercentage::fromValue((string) $productDiscountPercentage),
        );

        return $product;
    }
}
