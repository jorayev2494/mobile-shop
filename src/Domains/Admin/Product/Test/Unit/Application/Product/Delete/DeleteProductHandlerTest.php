<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Test\Unit\Application\Product\Delete;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Application\Commands\Delete\Command;
use Project\Domains\Admin\Product\Application\Commands\Delete\CommandHandler;
use Project\Domains\Admin\Product\Application\Commands\Delete\DeleteProductService;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Domains\Admin\Product\Test\Unit\Application\Product\ProductFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;
use Project\Utils\Auth\Contracts\AuthManagerInterface;

/**
 * @group product
 * @group product-application
 */
class DeleteProductHandlerTest extends TestCase
{
    public function setUp(): void
    {

    }

    public function testDeleteProduct(): void
    {
        $handler = new CommandHandler(
            new DeleteProductService(
                $productRepository = $this->createMock(ProductRepositoryInterface::class),
                $mediaRepository = $this->createMock(MediaRepositoryInterface::class),
                $filesystem = $this->createMock(FilesystemInterface::class),
                $eventBus = $this->createMock(EventBusInterface::class),
                $authManager = $this->createMock(AuthManagerInterface::class),
            )
        );

        $productRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ProductUuid::fromValue(ProductFactory::UUID))
                        ->willReturn($product = $this->createMock(Product::class));

        $eventBus->expects($this->once())
                ->method('publish');

        $handler(
            new Command(
                ProductFactory::UUID,
            )
        );

    }
}
