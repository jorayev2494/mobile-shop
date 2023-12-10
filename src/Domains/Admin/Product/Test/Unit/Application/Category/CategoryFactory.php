<?php

declare(strict_types= 1);

namespace Project\Domains\Admin\Product\Test\Unit\Application\Category;

use Project\Domains\Admin\Product\Domain\Category\Category;

class CategoryFactory
{
    public const UUID = '5524eedd-ff50-4287-a006-b86a20b6f07a';

    public const CATEGORY = 'Table';

    public const IS_ACTIVE = true;

    public static function make(
        string $uuid = self::UUID,
        string $category = self::CATEGORY,
        bool $isActive = self::IS_ACTIVE
    ): Category
    {
        return Category::fromPrimitives($uuid, $category, $isActive);
    }
}
