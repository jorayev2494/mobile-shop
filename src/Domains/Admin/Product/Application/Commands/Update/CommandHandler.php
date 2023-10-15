<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductCategoryUuid;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly FilesystemInterface $filesystem,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $product = $this->repository->findByUuid(ProductUuid::fromValue($command->uuid));

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        $this->removeMedias($product, $command->removeMediaIds);
        $product->changeTitle(ProductTitle::fromValue($command->title));
        $product->changeCategoryUuid(ProductCategoryUuid::fromValue($command->categoryUuid));
        $product->changePrice(new ProductPrice($command->price, $command->discountPercentage, $command->categoryUuid));
        $product->changeDescription(ProductDescription::fromValue($command->description));
        $this->uploadMedias($product, $command->medias);

        $this->repository->save($product);
        $this->eventBus->publish(...$product->pullDomainEvents());
    }

    private function removeMedias(Product $product, array $removeMediaIds): void
    {
        $removeMedias = $this->mediaRepository->findProductMediasByIds($product->getUuid(), $removeMediaIds);
        foreach ($removeMedias as $media) {
            $product->removeMedia($media);
            $this->filesystem->deleteFile($media);
            $this->mediaRepository->delete($media);
        }
    }

    private function uploadMedias(Product $product, iterable $uploadedMedias): void
    {
        foreach ($uploadedMedias as $media) {
            $uploadedMedia = $this->filesystem->uploadFile(Media::class, $media);
            $product->addMedia($uploadedMedia);
        }
    }
}
