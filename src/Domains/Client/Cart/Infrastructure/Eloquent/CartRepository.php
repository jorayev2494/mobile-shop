<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Client\Cart\Domain\Cart\Cart;
use Project\Domains\Client\Cart\Domain\Cart\CartRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartClientUUID;
use Project\Domains\Client\Cart\Domain\Cart\ValueObjects\CartUUID;
use Project\Domains\Client\Cart\Domain\Product\Cover;
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
        $foundCart = $this->getModelClone()->newQuery()->with(['products.cover'])->find($cartUUID->value);

        if ($foundCart === null) {
            return null;
        }

        $products = array_map(
            static function (\App\Models\Product $modelProduct): Product {
                $product = Product::fromPrimitives(
                    $modelProduct->uuid,
                    $modelProduct->title,
                    $modelProduct->category_uuid,
                    $modelProduct->currency_uuid,
                    (string) $modelProduct->price,
                    (string) $modelProduct->discount_percentage,
                    $modelProduct->viewed_count,
    
                    $modelProduct->cart_currency_uuid,
                    $modelProduct->cart_quality,
                    (string) $modelProduct->cart_price,
                    $modelProduct->cart_discount_percentage,
                );

                $modelCover = $modelProduct->cover;

                $cover = new Cover($modelCover->uuid, $modelCover->width, $modelCover->height, $modelCover->extension, $modelCover->size, $modelCover->file_original_name, $modelCover->url_pattern);
                $product->setCover($cover);

                return $product;
            },
            iterator_to_array($foundCart->products),
        );

        $cart = Cart::fromPrimitives(
            $foundCart->uuid,
            $foundCart->client_uuid,
            $foundCart->status,
            $products,
        );

        return $cart;
    }

    public function findClientCartByClientUUID(CartClientUUID $clientUUID): ?Cart
    {
        /** @var \App\Models\Cart $foundCart */
        $foundCart = $this->getModelClone()->newQuery()->with(['products'])->where('client_uuid', $clientUUID->value)->first();

        if ($foundCart === null) {
            return null;
        }

        $products = array_map(
            static fn (\App\Models\Product $product): Product => Product::fromPrimitives(
                $product->uuid,
                $product->title,
                $product->category_uuid,
                $product->currency_uuid,
                (string) $product->price,
                (string) $product->discount_percentage,
                $product->viewed_count,

                $product->cart_currency_uuid,
                $product->cart_quality,
                (string) $product->cart_price,
                $product->cart_discount_percentage,
            ),
            iterator_to_array($foundCart->products),
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
        foreach ($cart->getProducts() as $product) {
            $modelCart->products()->attach($product->uuid->value, $product->toArray());
        }
    }

    public function delete(CartUUID $uuid): void
    {
        $this->getModelClone()->newQuery()->find($uuid->value)?->delete();
    }
}
