<?php

namespace Project\Domains\Client\Cart\Domain\Product;

use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductCurrencyUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductDiscountPercentage;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductPrice;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\CartProductQuality;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductCategoryUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductCurrencyUUID;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductDiscountPercentage;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Client\Cart\Domain\Product\ValueObjects\ProductUUID;

class Product
{

    private ?Cover $cover;

    private function __construct(
        public readonly ProductUUID $uuid,
        public readonly string $title,
        public readonly ProductCategoryUUID $categoryUUID,
        public readonly ProductCurrencyUUID $currencyUUID,
        public readonly ProductPrice $price,
        public readonly ProductDiscountPercentage $discountPercentage,
        public readonly int $viewedCount,

        public readonly ?CartProductCurrencyUUID $cartProductCurrencyUUID = null,
        public readonly ?CartProductQuality $cartProductQuality = null,
        public readonly ?CartProductPrice $cartProductPrice = null,
        public readonly ?CartProductDiscountPercentage $cartProductDiscountPercentage = null,
    )
    {
        $this->cover = null;
    }

    public static function create(
        ProductUUID $uuid,
        string $title,
        ProductCategoryUUID $categoryUUID,
        ProductCurrencyUUID $currencyUUID,
        ProductPrice $price,
        ProductDiscountPercentage $discountPercentage,
        int $viewedCount,

        ?CartProductCurrencyUUID $cartProductCurrencyUUID = null,
        ?CartProductQuality $cartProductQuality = null,
        ?CartProductPrice $cartProductPrice = null,
        ?CartProductDiscountPercentage $cartProductDiscountPercentage = null,
    ): self
    {
        $product = new self(
            $uuid,
            $title,
            $categoryUUID,
            $currencyUUID,
            $price,
            $discountPercentage,
            $viewedCount,

            $cartProductCurrencyUUID,
            $cartProductQuality,
            $cartProductPrice,
            $cartProductDiscountPercentage,
        );

        return $product;
    }

    public static function fromPrimitives(
        string $uuid,
        string $title,
        string $categoryUUID,
        string $currencyUUID,
        string $price,
        string $discountPercentage,
        int $viewedCount,

        ?string $cartProductCurrencyUUID = null,
        ?int $cartProductQuality = null,
        ?string $cartProductPrice = null,
        ?int $cartProductDiscountPercentage = null,
    ): self
    {
        return new self(
            ProductUUID::fromValue($uuid),
            $title,
            ProductCategoryUUID::fromValue($categoryUUID),
            ProductCurrencyUUID::fromValue($currencyUUID),
            ProductPrice::fromValue($price),
            ProductDiscountPercentage::fromValue($discountPercentage),
            $viewedCount,

            $cartProductCurrencyUUID !== null ? CartProductCurrencyUUID::fromValue($cartProductCurrencyUUID) : $cartProductCurrencyUUID,
            $cartProductQuality !== null ? CartProductQuality::fromValue($cartProductQuality) : $cartProductQuality,
            $cartProductPrice !== null ? CartProductPrice::fromValue($cartProductPrice) : $cartProductPrice,
            $cartProductDiscountPercentage !== null ? CartProductDiscountPercentage::fromValue($cartProductDiscountPercentage) : $cartProductDiscountPercentage,
        );
    }

    public function getCover(): ?Cover
    {
        return $this->cover;
    }

    public function setCover(Cover $cover): void
    {
        $this->cover = $cover;
    }

    public function getDiscountPrice(): int
    {
        return ($discount = (int) $this->discountPercentage->value) > 0 ? (((float) $this->price->value) / 100) * $discount : 0;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title,
            'category_uuid' => $this->categoryUUID->value,
            'currency_uuid' => $this->currencyUUID->value,
            'cover' => $this->cover?->toArray(),
            'price' => $this->price->value,
            'discount_percentage' => $this->discountPercentage->value,
            'discount_price' => $this->getDiscountPrice(),
            'viewed_count' => $this->viewedCount,

            'cart_currency_uuid' => $this->cartProductCurrencyUUID?->value,
            'cart_quality' => $this->cartProductQuality?->value,
            'cart_price' => $this->cartProductPrice?->value,
            'cart_discount_percentage' => $this->cartProductDiscountPercentage?->value,
        ];
    }
}
