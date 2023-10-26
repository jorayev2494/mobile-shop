<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Application\Product;

use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Tests\Unit\Project\Domains\Admin\Product\Application\Category\CategoryFactory;

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
        ProductPrice $price = null,
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

    public static function create(
        string $uuid = null,
        string $title = null,
        Category $category = null,
        ProductPrice $price = null,
        string $description = null,
        int $viewedCount = null,
        bool $isActive = null,
    ): Product
    {
        return Product::create(
            ProductUuid::fromValue($uuid ?? self::UUID),
            ProductTitle::fromValue($title ?? self::TITLE),
            $category ?? CategoryFactory::make(),
            $price ?? PriceFactory::make(),
            ProductDescription::fromValue($description ?? self::DESCRIPTION),
            $isActive ?? self::IS_ACTIVE,
        );
    }
}
