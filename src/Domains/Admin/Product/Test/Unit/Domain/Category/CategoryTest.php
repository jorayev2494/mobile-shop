<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Test\Unit\Domain\Category;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryIsActiveWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryValueWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasCreatedDomainEvent;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Value;
use Project\Domains\Admin\Product\Test\Unit\Application\Category\CategoryFactory;

/**
 * @group category
 * @group category-domain
 */
class CategoryTest extends TestCase
{
    public function testCreateCategory(): void
    {
        $category = Category::create(
            Uuid::fromValue(CategoryFactory::UUID),
            Value::fromValue(CategoryFactory::CATEGORY),
            CategoryFactory::IS_ACTIVE,
        );

        $this->assertInstanceOf(Category::class, $category);

        $this->assertInstanceOf(Uuid::class, $category->getUuid());
        $this->assertSame(CategoryFactory::UUID, $category->getUuid()->value);

        $this->assertInstanceOf(Value::class, $category->getValue());
        $this->assertSame(CategoryFactory::CATEGORY, $category->getValue()->value);

        $this->assertIsBool($category->getIsActive());
        $this->assertSame(CategoryFactory::IS_ACTIVE, $category->getIsActive());

        $this->assertCount(1, $domainEvents = $category->pullDomainEvents());
        $this->assertInstanceOf(CategoryWasCreatedDomainEvent::class, $domainEvents[0]);
    }

    public function testCreateCategoryFromPrimitives(): void
    {
        $category = Category::fromPrimitives(
            CategoryFactory::UUID,
            CategoryFactory::CATEGORY,
            CategoryFactory::IS_ACTIVE,
        );

        $this->assertInstanceOf(Category::class, $category);

        $this->assertInstanceOf(Uuid::class, $category->getUuid());
        $this->assertSame(CategoryFactory::UUID, $category->getUuid()->value);

        $this->assertInstanceOf(Value::class, $category->getValue());
        $this->assertSame(CategoryFactory::CATEGORY, $category->getValue()->value);

        $this->assertIsBool($category->getIsActive());
        $this->assertSame(CategoryFactory::IS_ACTIVE, $category->getIsActive());

        $this->assertCount(0, $category->pullDomainEvents());
    }

    public function testChangeCategoryValue()
    {
        $category = CategoryFactory::make();

        $category->changeValue(Value::fromValue('Lamp'));

        $this->assertInstanceOf(Value::class, $category->getValue());
        $this->assertSame('Lamp', $category->getValue()->value);

        $this->assertCount(1, $domainEvents = $category->pullDomainEvents());
        $this->assertInstanceOf(CategoryValueWasChangedDomainEvent::class, $domainEvents[0]);
    }

    public function testChangeCategoryIsActive()
    {
        $category = CategoryFactory::make();

        $category->changeIsActive(false);

        $this->assertIsBool($category->getIsActive());
        $this->assertSame(false, $category->getIsActive());

        $this->assertCount(1, $domainEvents = $category->pullDomainEvents());
        $this->assertInstanceOf(CategoryIsActiveWasChangedDomainEvent::class, $domainEvents[0]);
    }
}
