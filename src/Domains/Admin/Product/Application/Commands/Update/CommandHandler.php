<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Update;

use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\DomainException;
use Project\Shared\Domain\FilesystemInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly MediaRepositoryInterface $mediaRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly CurrencyRepositoryInterface $currencyRepository,
        private readonly FilesystemInterface $filesystem,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $category = $this->categoryRepository->findByUuid(Uuid::fromValue($command->categoryUuid));

        if ($category === null) {
            throw new DomainException('Category not found');
        }

        $product = $this->repository->findByUuid(ProductUuid::fromValue($command->uuid));

        if ($product === null) {
            throw new DomainException('Product not found');
        }

        $currency = $this->currencyRepository->findByUuid(CurrencyUuid::fromValue($command->currencyUuid));

        if ($currency === null) {
            throw new DomainException('Currency not found');
        }

        $this->removeMedias($product, $command->removeMediaIds);
        $product->changeTitle(ProductTitle::fromValue($command->title));
        $product->changeCategory($category);
        $product->changePrice(new ProductPrice($command->price, $command->discountPercentage, $currency));
        $product->changeDescription(ProductDescription::fromValue($command->description));
        $this->uploadMedias($product, $command->medias);

        $this->repository->save($product);
        $this->eventBus->publish(...$product->pullDomainEvents());
    }

    private function removeMedias(Product $product, array $removeMediaIds): void
    {
        $removeMedias = $this->mediaRepository->findProductMediasByIds($product->getUuid()->value, $removeMediaIds);

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
