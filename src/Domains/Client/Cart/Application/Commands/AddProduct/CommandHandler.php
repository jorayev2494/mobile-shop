<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\AddProduct;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartStatus;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductCurrencyUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductDiscountPercentage;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductPrice;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductQuality;
use Project\Domains\Client\Cart\Domain\Product\Product;
use Project\Domains\Client\Cart\Domain\Product\ProductRepositoryInterface;
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
        $cart = $this->repository->findByUUID(CartUUID::fromValue($command->uuid));

        $cart ?? throw new ModelNotFoundException("Cart not found");

        if ($cart->getStatus() === CartStatus::ORDERED) {
            throw new \DomainException("This cart is ordered");
        }

        $this->addProduct($cart, $this->makeProduct($command));

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
            CartProductDiscountPercentage::fromValue((int) $productDiscountPercentage),
        );

        return $product;
    }


    private function addProduct(Cart $cart, Product $product): void
    {
        $products = [];

        foreach ($cart->getProducts() as $cartProduct) {
            if ($cartProduct->uuid->value === $product->uuid->value) {
                continue;
            }

            $products[] = $cartProduct;
        }

        $cart->addProducts($products);
        $cart->addProduct($product);
    }
}
