<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductCategoryUuid;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly FilesystemInterface $filesystem,
        private readonly EventBusInterface $eventBus,
    )
    {

    }

    public function __invoke(Command $command): void
    {
        $product = Product::create(
            ProductUuid::fromValue($command->uuid),
            ProductTitle::fromValue($command->title),
            ProductCategoryUuid::fromValue($command->categoryUuid),
            new ProductPrice($command->price, $command->discountPercentage, $command->currencyUuid),
            ProductDescription::fromValue($command->description),
            $command->isActive,
        );

        $this->uploadMedias($product, $command->medias);
        $this->repository->save($product);
        $this->eventBus->publish(...$product->pullDomainEvents());
    }

    private function uploadMedias(Product $product, iterable $uploadedMedias): void
    {
        foreach ($uploadedMedias as $media) {
            $uploadedMedia = $this->filesystem->uploadFile(Media::class, $media);
            $product->addMedia($uploadedMedia);
        }
    }
}
