<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Domain\Product;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid as CategoryUuid;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductCategoryWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductDescriptionWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductMediaWasAddedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductPriceWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductTitleWasChangedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasCreatedDomainEvent;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Tests\Unit\Project\Domains\Admin\Product\Application\Category\CategoryFactory;
use Tests\Unit\Project\Domains\Admin\Product\Application\Product\MediaFactory;
use Tests\Unit\Project\Domains\Admin\Product\Application\Product\PriceFactory;
use Tests\Unit\Project\Domains\Admin\Product\Application\Product\ProductFactory;

/**
 * @group product
 * @group product-domain
 */
class ProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $product = Product::create(
            ProductUuid::fromValue(ProductFactory::UUID),
            ProductTitle::fromValue(ProductFactory::TITLE),
            CategoryFactory::make(),
            PriceFactory::make(),
            ProductDescription::fromValue(ProductFactory::DESCRIPTION),
            ProductFactory::IS_ACTIVE,
            $cratedAt = new \DateTimeImmutable(),
            $updatedAt = new \DateTimeImmutable(),
        );

        $this->assertInstanceOf(ProductUuid::class, $product->getUuid());
        $this->assertSame(ProductFactory::UUID, $product->getUuid()->value);

        $this->assertInstanceOf(ProductTitle::class, $product->getTitle());
        $this->assertSame(ProductFactory::TITLE, $product->getTitle()->value);

        $this->assertInstanceOf(Category::class, $product->getCategory());

        $this->assertInstanceOf(CategoryUuid::class, $product->getCategory()->getUuid());
        $this->assertSame(CategoryFactory::UUID, $product->getCategory()->getUuid()->value);
        $this->assertSame(CategoryFactory::CATEGORY, $product->getCategory()->getValue()->value);
        $this->assertSame(CategoryFactory::IS_ACTIVE, $product->getCategory()->getIsActive());

        $this->assertInstanceOf(ProductPrice::class, $product->getPrice());
        $this->assertSame(PriceFactory::PRICE, $product->getPrice()->getValue());
        $this->assertSame(PriceFactory::DISCOUNT_PERCENTAGE, $product->getPrice()->getDiscountPercentage());

        $this->assertInstanceOf(ProductDescription::class, $product->getDescription());
        $this->assertSame(ProductFactory::DESCRIPTION, $product->getDescription()->value);

        $this->assertTrue($product->getIsActive());
        $this->assertSame(ProductFactory::IS_ACTIVE, $product->getIsActive());

        $this->assertNotNull($product->getCreatedAt()->getTimestamp());
        $this->assertSame($cratedAt->getTimestamp(), $product->getCreatedAt()->getTimestamp());

        $this->assertNotNull($product->getUpdatedAt()->getTimestamp());
        $this->assertSame($updatedAt->getTimestamp(), $product->getUpdatedAt()->getTimestamp());

        $this->assertContainsOnlyInstancesOf(ProductWasCreatedDomainEvent::class, $product->pullDomainEvents());
    }

    public function testCreateProductFromPrimitives(): void
    {
        $product = Product::fromPrimitives(
            ProductFactory::UUID,
            ProductFactory::TITLE,
            CategoryFactory::make(),
            PriceFactory::make(),
            ProductFactory::DESCRIPTION,
            0,
            ProductFactory::IS_ACTIVE,
            $cratedAt = new \DateTimeImmutable(),
            $updatedAt = new \DateTimeImmutable(),
        );

        $this->assertInstanceOf(ProductUuid::class, $product->getUuid());
        $this->assertSame(ProductFactory::UUID, $product->getUuid()->value);

        $this->assertInstanceOf(ProductTitle::class, $product->getTitle());
        $this->assertSame(ProductFactory::TITLE, $product->getTitle()->value);

        $this->assertInstanceOf(Category::class, $product->getCategory());
        $this->assertInstanceOf(CategoryUuid::class, $product->getCategory()->getUuid());
        $this->assertSame(CategoryFactory::UUID, $product->getCategory()->getUuid()->value);
        $this->assertSame(CategoryFactory::CATEGORY, $product->getCategory()->getValue()->value);
        $this->assertSame(CategoryFactory::IS_ACTIVE, $product->getCategory()->getIsActive());

        $this->assertInstanceOf(ProductPrice::class, $product->getPrice());
        $this->assertSame(PriceFactory::PRICE, $product->getPrice()->getValue());
        $this->assertSame(PriceFactory::DISCOUNT_PERCENTAGE, $product->getPrice()->getDiscountPercentage());

        $this->assertInstanceOf(ProductDescription::class, $product->getDescription());
        $this->assertSame(ProductFactory::DESCRIPTION, $product->getDescription()->value);

        $this->assertTrue($product->getIsActive());
        $this->assertSame(ProductFactory::IS_ACTIVE, $product->getIsActive());

        $this->assertNotNull($product->getCreatedAt()->getTimestamp());
        $this->assertSame($cratedAt->getTimestamp(), $product->getCreatedAt()->getTimestamp());

        $this->assertNotNull($product->getUpdatedAt()->getTimestamp());
        $this->assertSame($updatedAt->getTimestamp(), $product->getUpdatedAt()->getTimestamp());

        $this->assertEmpty($product->pullDomainEvents());
    }

    public function testProductSetTitle(): void
    {
        $product = ProductFactory::make();

        $product->setTitle(ProductTitle::fromValue('New Title'));

        $this->assertInstanceOf(ProductTitle::class, $product->getTitle());
        $this->assertSame('New Title', $product->getTitle()->value);
        $this->assertCount(0, $product->pullDomainEvents());
    }

    public function testChangeProductTitle(): void
    {
        $product = ProductFactory::make();

        $product->changeTitle(ProductTitle::fromValue('New Title 2'));

        $this->assertInstanceOf(ProductTitle::class, $product->getTitle());
        $this->assertSame('New Title 2', $product->getTitle()->value);
        $this->assertCount(1, $domainEvents = $product->pullDomainEvents());
        $this->assertInstanceOf(ProductTitleWasChangedDomainEvent::class, $domainEvents[0]);
    }

    public function testAddMedias(): void
    {
        $product = ProductFactory::make();
        $product->addMedia(MediaFactory::make());

        $this->assertCount(1, $product->getMedias());
        $this->assertContainsOnlyInstancesOf(Media::class, $product->getMedias());

        $this->assertContainsOnlyInstancesOf(ProductMediaWasAddedDomainEvent::class, $product->pullDomainEvents());
    }

    public function testProductSetCategory(): void
    {
        $product = ProductFactory::make();

        $product->setCategory(CategoryFactory::make('bb8fd6d7-ea1a-4c3f-be2f-279cb3750e8e', 'Bed', false));

        $this->assertInstanceOf(Category::class, $product->getCategory());
        $this->assertInstanceOf(CategoryUuid::class, $product->getCategory()->getUuid());
        $this->assertSame('bb8fd6d7-ea1a-4c3f-be2f-279cb3750e8e', $product->getCategory()->getUuid()->value);
        $this->assertSame('Bed', $product->getCategory()->getValue()->value);
        $this->assertSame(false, $product->getCategory()->getIsActive());
        $this->assertCount(0, $product->pullDomainEvents());
    }

    public function testChangeProductCategory(): void
    {
        $product = ProductFactory::make();

        $product->changeCategory(CategoryFactory::make('0ae901ae-4819-4af4-86c3-3b3e81e8b7b4', 'Armchair', true));

        $this->assertInstanceOf(Category::class, $product->getCategory());
        $this->assertInstanceOf(CategoryUuid::class, $product->getCategory()->getUuid());
        $this->assertSame('0ae901ae-4819-4af4-86c3-3b3e81e8b7b4', $product->getCategory()->getUuid()->value);
        $this->assertSame('Armchair', $product->getCategory()->getValue()->value);
        $this->assertSame(true, $product->getCategory()->getIsActive());

        $this->assertCount(1, $domainEvents = $product->pullDomainEvents());
        $this->assertInstanceOf(ProductCategoryWasChangedDomainEvent::class, $domainEvents[0]);
    }

    public function testProductSetPrice(): void
    {
        $product = ProductFactory::make();

        $product->setPrice(PriceFactory::make(54.99, 12));

        $this->assertSame(54.99, $product->getPrice()->getValue());
        $this->assertSame(12, $product->getPrice()->getDiscountPercentage());
        $this->assertCount(0, $product->pullDomainEvents());
    }

    public function testChangeProductPrice(): void
    {
        $product = ProductFactory::make();

        $product->changePrice(PriceFactory::make(54.99, 12));

        $this->assertCount(1, $domainEvents = $product->pullDomainEvents());
        $this->assertInstanceOf(ProductPriceWasChangedDomainEvent::class, $domainEvents[0]);
    }

    public function testProductSetDescription(): void
    {
        $product = ProductFactory::make();

        $product->setDescription(ProductDescription::fromValue('New Description'));

        $this->assertSame('New Description', $product->getDescription()->value);
        $this->assertCount(0, $product->pullDomainEvents());
    }

    public function testChangeProductDescription(): void
    {
        $product = ProductFactory::make();

        $product->changeDescription(ProductDescription::fromValue('New Description Description'));

        $this->assertSame('New Description Description', $product->getDescription()->value);
        $this->assertCount(1, $domainEvents = $product->pullDomainEvents());
        $this->assertInstanceOf(ProductDescriptionWasChangedDomainEvent::class, $domainEvents[0]);
    }
}
