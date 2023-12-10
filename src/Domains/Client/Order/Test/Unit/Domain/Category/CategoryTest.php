<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Category;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Category\Category;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Value;
use Project\Domains\Client\Order\Test\Unit\Application\CategoryFactory;
use Project\Shared\Domain\Aggregate\AggregateRoot;

/**
 * @group order-domain
 * @group order-category-domain
 */
class CategoryTest extends TestCase
{

    private Category $category;

    protected function setUp(): void
    {
        $this->category = CategoryFactory::make();
    }

    public function testFromPrimitives(): void
    {
        $category = Category::fromPrimitives(
            CategoryFactory::UUID,
            CategoryFactory::CATEGORY,
            CategoryFactory::IS_ACTIVE,
        );

        $this->assertNotNull($category);
        $this->assertInstanceOf(Category::class, $category);
        $this->assertNotInstanceOf(AggregateRoot::class, $category);

        $this->assertInstanceOf(Uuid::class, $category->getUuid());
        $this->assertSame(CategoryFactory::UUID, $category->getUuid()->value);

        $this->assertInstanceOf(Value::class, $category->getValue());
        $this->assertSame(CategoryFactory::CATEGORY, $category->getValue()->value);

        $this->assertIsBool($category->getIsActive());
        $this->assertSame(CategoryFactory::IS_ACTIVE, $category->getIsActive());
    }

    public function testCategorySetValue(): void
    {
        $this->assertInstanceOf(Value::class, $this->category->getValue());
        $this->assertSame(CategoryFactory::CATEGORY, $this->category->getValue()->value);

        $this->category->setValue(Value::fromValue('Bus'));

        $this->assertInstanceOf(Value::class, $this->category->getValue());
        $this->assertNotSame(CategoryFactory::CATEGORY, $this->category->getValue()->value);
        $this->assertSame('Bus', $this->category->getValue()->value);
    }

    public function testCategorySetIsActive(): void
    {
        $this->assertIsBool($this->category->getIsActive());
        $this->assertSame(CategoryFactory::IS_ACTIVE, $this->category->getIsActive());

        $this->category->setIsActive(false);

        $this->assertIsBool($this->category->getIsActive());
        $this->assertNotSame(CategoryFactory::IS_ACTIVE, $this->category->getIsActive());
        $this->assertSame(false, $this->category->getIsActive());
    }
}
