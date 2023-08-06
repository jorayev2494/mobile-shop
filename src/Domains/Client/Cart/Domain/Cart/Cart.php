<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart;

use Illuminate\Support\Collection;
use Project\Shared\Domain\Aggregate\AggregateRoot;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartStatus;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartClientUUID;
use Project\Domains\Client\Cart\Domain\Product\Product;

class Cart extends AggregateRoot
{

    private CartStatus $status;

    /**
     * @template TValue of Product
     * @var Collection<array-key, Product> $products
     */
    public Collection $products;

    private function __construct(
        public readonly CartUUID $uuid,
        public readonly CartClientUUID $clientUUID,
        iterable $products = [],
    )
    {
        $this->products = Collection::make($products);
        $this->status = CartStatus::DRAFT;
    }

    public static function create(CartUUID $uuid, CartClientUUID $clientUUID, iterable $products): self
    {
        $cart = new self($uuid, $clientUUID, $products);

        return $cart;
    }

    public static function fromPrimitives(string $uuid, string $clientUUID, string $status, iterable $products = []): self
    {
        $cart = new self(CartUUID::fromValue($uuid), CartClientUUID::fromValue($clientUUID), $products);
        $cart->status = CartStatus::from($status);

        return $cart;
    }

    public function getStatus(): CartStatus
    {
        return $this->status;
    }

    public function addProduct(Product $product): void
    {
        $this->products->add($product);
    }

    /**
     * @param iterable<Product> $products
     * @return void
     */
    public function addProducts(iterable $products): void
    {
        $this->products = $this->products->empty();

        foreach ($products as $key => $product) {
            $this->products->add($product);
        }
    }

    public function removeProduct(Product $toProduct): void
    {
        foreach ($this->products as $key => $product) {
            if ($toProduct->uuid->value === $product->uuid->value) {
                unset($this->products[$key]);
                return;
            }
        }
    }

    /**
     * @return iterable<array-key, Product>
     */
    public function getProducts(): iterable
    {
        return $this->products;
    }

    public function toArray(): array
    {
        $products = array_map(
            static fn (Product $product): array => $product->toArray(),
            iterator_to_array($this->products)
        );

        $quality = $this->products->sum(static fn (Product $product): int => $product->quality->value);
        $sum = $this->products->sum(static fn (Product $product): float => (float) $product->price->value);
        $discountPercentage = $this->products->sum(static fn (Product $product): float => (float) $product->discountPercentage->value);

        return [
            'uuid' => $this->uuid->value,
            // 'client_uuid' => $this->clientUUID->value,
            'products' => $products,
            'status' => $this->status->value,
            'quality' => $quality,
            'sum' => $sum,
            'discount_percentage' => $discountPercentage,
        ];
    }
}
