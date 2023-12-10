<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Test\Unit\Application\Product\Create;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Create\Command;
use Project\Domains\Admin\Product\Application\Commands\Create\CommandHandler;
use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\Currency;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Test\Unit\Application\Category\CategoryFactory;
use Project\Domains\Admin\Product\Test\Unit\Application\Currency\CurrencyFactory;
use Project\Domains\Admin\Product\Test\Unit\Application\Product\ProductFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;

/**
 * @group product
 * @group product-application
 */
class CreateProductHandlerTest extends TestCase
{

    private ?Product $product = null;

    private ?ProductPrice $price = null;

    private ?Currency $currency = null;

    private ?Category $category = null;

    public function setUp(): void
    {
        $this->category = CategoryFactory::make();
        $this->currency = CurrencyFactory::make();
        $this->product = ProductFactory::create();
    }

    public function testCreateProduct(): void
    {
        $handler = new CommandHandler(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $filesystem = $this->createMock(FilesystemInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class)
        );

        $categoryRepository->expects(self::once())
                        ->method("findByUuid")
                        ->with($this->category->getUuid())
                        ->willReturn($this->category);

        $currencyRepository->expects(self::once())
                        ->method('findByUuid')
                        ->with($this->currency->getUuid())
                        ->willReturn($this->currency);

        // $this->product->record(
        //     new ProductWasCreatedDomainEvent(
        //         ProductFactory::UUID,
        //         ProductFactory::TITLE,
        //         $this->category->getUuid()->value,
        //         $this->productPrice->toArray(),
        //         0,
        //         ProductFactory::DESCRIPTION,
        //         true,
        //         ProductFactory::UUID,
        //         (new \DateTimeImmutable())->format('Y-m-d H:i:s.u T'),
        //     )
        // );

        $productRepository->expects(self::once())
                        ->method('save')
                        // ->with($this->product)
                        ;

        $eventBus->expects(self::once())
                ->method('publish')
                // ->with($this->product->pullDomainEvents())
                ;

        $handler(
            new Command(
                ProductFactory::UUID,
                ProductFactory::TITLE,
                $this->category->getUuid()->value,
                $this->currency->getUuid()->value,
                ProductFactory::PRICE,
                ProductFactory::DISCOUNT_PERCENTAGE,
                [],
                ProductFactory::DESCRIPTION,
                ProductFactory::IS_ACTIVE,
            )
        );
    }
}
