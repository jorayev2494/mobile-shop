<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Product\Product\Update;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Update\Command;
use Project\Domains\Admin\Product\Application\Commands\Update\CommandHandler;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid as CategoryUuid;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;
use Tests\Unit\Project\Domains\Admin\Product\Category\CategoryFactory;
use Tests\Unit\Project\Domains\Admin\Product\Currency\CurrencyFactory;
use Tests\Unit\Project\Domains\Admin\Product\Product\ProductFactory;

class UpdateProductHandlerTest extends TestCase
{
    private const CATEGORY_UUID = '5524eedd-ff50-4287-a006-b86a20b6f87a';

    private const CURRENCY_UUID = '1f00e8dd-978c-41a6-89b4-ee634a8daef9';

    public function setUp(): void
    {

    }

    public function testUpdateProduct(): void
    {
        $handler = new CommandHandler(
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
            $mediaRepository = $this->createMock(MediaRepositoryInterface::class),
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $filesystem = $this->createMock(FilesystemInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $productRepository->expects(self::once())
                        ->method('findByUuid')
                        ->with(ProductUuid::fromValue(ProductFactory::UUID))
                        ->willReturn($product = ProductFactory::make());

        $categoryRepository->expects(self::once())
                        ->method('findByUuid')
                        ->with(CategoryUuid::fromValue(self::CATEGORY_UUID))
                        ->willReturn($category = CategoryFactory::make(self::CATEGORY_UUID, 'chair'));

        $currencyRepository->expects(self::once())
                        ->method('findByUuid')
                        ->with(CurrencyUuid::fromValue(self::CURRENCY_UUID))
                        ->willReturn($currency = CurrencyFactory::make(self::CURRENCY_UUID, 'UAH'));

        $mediaRepository->expects(self::once())
                        ->method('findProductMediasByIds')
                        ->with(ProductFactory::UUID, [])
                        ->willReturn([]);

        $mediaRepository->expects(self::never())
                        ->method('delete');

        $filesystem->expects(self::never())
                    ->method('deleteFile');

        $eventBus->expects(self::once())
                ->method('publish')
        ;
                    
        $handler(
            new Command(
                ProductFactory::UUID,
                'New Title',
                self::CATEGORY_UUID,
                self::CURRENCY_UUID,
                99.99,
                0,
                [],
                [],
                'New Description',
                true,
            )
        );
    }
}
