<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Create;

use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Product\Product;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Admin\Product\Domain\Product\ProductRepositoryInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
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

        $currency = $this->currencyRepository->findByUuid(CurrencyUuid::fromValue($command->currencyUuid));

        if ($currency === null) {
            throw new DomainException('Currency not found');
        }

        $product = Product::create(
            ProductUuid::fromValue($command->uuid),
            ProductTitle::fromValue($command->title),
            $category,
            new ProductPrice($command->price, $command->discountPercentage, $currency),
            ProductDescription::fromValue($command->description),
            $command->isActive,
        );

        $this->uploadMedias($product, $command->medias);
        // dd($product);
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
