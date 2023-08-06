<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Domain;

use Project\Domains\Client\Product\Domain\ValueObjects\ProductCategoryUUID;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductCurrencyUUID;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductDiscountPercentage;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductPrice;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Domain\Aggregate\AggregateRoot;

class Product extends AggregateRoot
{
    private ?array $currency = null;
    private function __construct(
        public readonly ProductUUID $uuid,
        public readonly string $title,
        public readonly ProductCategoryUUID $categoryUUID,
        public readonly ProductCurrencyUUID $currencyUUID,
        public readonly ProductPrice $price,
        public readonly ProductDiscountPercentage $discountPercentage,
        public iterable $medias,
        public readonly int $viewedCount,
        public readonly string $description,
        public readonly bool $isActive,
    )
    {

    }

    public static function fromPrimitives(string $uuid, string $title, string $categoryUUID, string $currencyUUID, string $price, string $discountPercentage, iterable $medias, int $viewedCount, string $description, bool $isActive = true): self
    {
        return new self(
            ProductUUID::fromValue($uuid),
            $title,
            ProductCategoryUUID::fromValue($categoryUUID),
            ProductCurrencyUUID::fromValue($currencyUUID),
            ProductPrice::fromValue($price),
            ProductDiscountPercentage::fromValue($discountPercentage),
            $medias,
            $viewedCount,
            $description,
            $isActive,
        );
    }

    public function setMedias(iterable $medias): void
    {
        $this->medias = $medias;
    }

    public function setCurrency(array $data): void
    {
        $this->currency = $data;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid->value,
            'title' => $this->title,
            'category_uuid' => $this->categoryUUID->value,
            'currency_uuid' => $this->currencyUUID->value,
            'price' => $this->price->value,
            'currency' => $this->currency,
            'discount_percentage' => $this->discountPercentage->value,
            'medias' => $this->medias,
            'viewed_count' => $this->viewedCount,
            'description' => $this->description,
            'is_active' => $this->isActive,
        ];
    }
}
