<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Category\Category;
use Project\Domains\Client\Order\Domain\Product\Product;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Description;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Price;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Title;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Uuid;

class ProductFactory
{
    public const UUID = '59ea4467-27c0-4c2d-967d-1b06ea105bcb';

    public const TITLE = 'Test title';

    public const PRICE = PriceFactory::PRICE;

    public const DISCOUNT_PERCENTAGE = PriceFactory::DISCOUNT_PERCENTAGE;

    public const DESCRIPTION = 'Test description';

    public const VIEWED_COUNT = 0;

    public const IS_ACTIVE = true;

    public static function make(
        string $uuid = null,
        string $title = null,
        Category $category = null,
        Price $price = null,
        string $description = null,
        int $viewedCount = null,
        bool $isActive = null,
    ): Product
    {
        return Product::fromPrimitives(
            $uuid ?? self::UUID,
            $title ?? self::TITLE,
            $category ?? CategoryFactory::make(),
            $price ?? PriceFactory::make(),
            $description ?? self::DESCRIPTION,
            $viewedCount ?? self::VIEWED_COUNT,
            $isActive ?? self::IS_ACTIVE,
        );
    }

    public static function makeWithMedia(
        string $uuid = null,
        string $title = null,
        Category $category = null,
        Price $price = null,
        string $description = null,
        int $viewedCount = null,
        bool $isActive = null,
    ): Product
    {
        $product = self::make($uuid, $title, $category, $price, $description, $viewedCount, $isActive);
        $product->addMedia(MediaFactory::make());

        return $product;
    }

    public static function create(
        string $uuid = null,
        string $title = null,
        Category $category = null,
        Price $price = null,
        string $description = null,
        int $viewedCount = null,
        bool $isActive = null,
    ): Product
    {
        return Product::create(
            Uuid::fromValue($uuid ?? self::UUID),
            Title::fromValue($title ?? self::TITLE),
            $category ?? CategoryFactory::make(),
            $price ?? PriceFactory::make(),
            Description::fromValue($description ?? self::DESCRIPTION),
            $isActive ?? self::IS_ACTIVE,
        );
    }
}
