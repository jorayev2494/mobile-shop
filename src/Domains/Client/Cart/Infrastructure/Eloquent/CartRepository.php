<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Product\Product;

class CartRepository extends BaseModelRepository implements CartRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Cart::class;
    }

    public function findByUUID(CartUUID $cartUUID): ?Cart
    {   
        /** @var \App\Models\Cart $foundCart */
        $foundCart = $this->getModelClone()->newQuery()->with(['products'])->find($cartUUID->value);

        if ($foundCart === null) {
            return $foundCart;
        }

        $products = array_map(
            static fn (array $product): Product => Product::fromPrimitives(
                $product['uuid'],
                $product['cart_currency_uuid'],
                $product['cart_quality'],
                (string) $product['cart_price'],
                (string) $product['cart_discount_percentage'],
            ),
            $foundCart->products->toArray(),
        );

        $cart = Cart::fromPrimitives(
            $foundCart->uuid,
            $foundCart->client_uuid,
            $foundCart->status,
            $products,
        );

        return $cart;
    }

    public function save(Cart $cart): void
    {
        /** @var \App\Models\Cart $modelCart */
        $modelCart = $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'uuid' => $cart->uuid->value,
            ],
            [
                'uuid' => $cart->uuid->value,
                'client_uuid' => $cart->clientUUID->value,
                'status' => $cart->getStatus()->value,
            ]
        );

        $modelCart->products()->detach();
        foreach ($cart->getProducts() as $key => $product) {
            $modelCart->products()->attach($product->uuid->value, $product->toArray());
        }
    }

    public function delete(CartUUID $uuid): void
    {
        $this->getModelClone()->newQuery()->find($uuid->value)?->delete();
    }
}
