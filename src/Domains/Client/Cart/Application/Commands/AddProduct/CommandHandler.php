<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Commands\AddProduct;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartStatus;
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
        $cart = $this->repository->findByUUID(CartUUID::fromValue($command->uuid));

        if ($cart === null) {
            throw new ModelNotFoundException();
        }

        if ($cart->getStatus() === CartStatus::ORDERED) {
            throw new \DomainException("This cart is ordered");
        }

        $this->addProduct($cart, $this->makeAddProduct($command));

        $this->repository->save($cart);
    }

    private function makeAddProduct(Command $command): Product
    {
        $productPrice = ((float) $command->productPrice) * $command->productQuality;
        $productDiscountPercentage = ((float) $command->productDiscountPercentage) * $command->productQuality;

        $addProduct = Product::create(
            ProductUUID::fromValue($command->productUuid),
            ProductCurrencyUUID::fromValue($command->productCurrencyUUID),
            ProductQuality::fromValue($command->productQuality),
            ProductPrice::fromValue((string) $productPrice),
            ProductDiscountPercentage::fromValue((string) $productDiscountPercentage),
        );

        return $addProduct;
    }

    private function addProduct(Cart $cart, Product $aProduct): void
    {
        $products = [];

        foreach ($cart->getProducts() as $key => $product) {
            if ($product->uuid->value === $aProduct->uuid->value) {
                continue;
            }

            $products[] = $product;
        }

        $cart->addProducts($products);
        $cart->addProduct($aProduct);
    }
}
