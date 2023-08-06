<?php

namespace Project\Domains\Client\Cart\Domain\Product;

use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductCurrencyUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductDiscountPercentage;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductQuality;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductUUID;

class Product
{
    private function __construct(
        public readonly ProductUUID $uuid,
        public readonly ProductCurrencyUUID $currencyUUID,
        public readonly ProductQuality $quality,
        public readonly ProductPrice $price,
        public readonly ProductDiscountPercentage $discountPercentage,
    )
    {
        
    }

    public static function create(
        ProductUUID $uuid,
        ProductCurrencyUUID $currencyUUID,
        ProductQuality $quality,
        ProductPrice $price,
        ProductDiscountPercentage $discountPercentage,
    ): self
    {
        return new self($uuid, $currencyUUID, $quality, $price, $discountPercentage);
    }

    public static function fromPrimitives(string $uuid, string $currencyUUID, int $quality, string $price, string $discountPercentage): self
    {
        return new self(
            ProductUUID::fromValue($uuid),
            ProductCurrencyUUID::fromValue($currencyUUID),
            ProductQuality::fromValue($quality),
            ProductPrice::fromValue($price),
            ProductDiscountPercentage::fromValue($discountPercentage),
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'currency_uuid' => $this->currencyUUID->value,
            'quality' => $this->quality->value,
            'price' => $this->price->value,
            'discount_percentage' => $this->discountPercentage->value,
        ];
    }
}
