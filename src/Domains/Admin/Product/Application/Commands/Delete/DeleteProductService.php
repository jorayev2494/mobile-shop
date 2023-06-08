<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Delete;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Product as DomainProduct;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\FilesystemInterface;

final class DeleteProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository,
        private readonly FilesystemInterface $filesystem,
        private readonly EventBusInterface $eventBus,
    )
    {
        
    }

    public function execute(ProductUUID $uuid): void
    {
        /** @var Product $product */
        $product = $this->repository->findOrNull($uuid->value);

        if ($product === null) {
            throw new ModelNotFoundException();
        }

        // $this->deleteMedias($product);
        $p = DomainProduct::fromPrimitives(
            $product->uuid,
            $product->title,
            $product->category_uuid,
            $product->currency_uuid,
            (string) $product->price,
            (string) $product->discount_percentage,
            $product->medias,
            0,
            $product->description,
            $product->is_active
        );
        $p->delete();
        $this->repository->delete($uuid);
        $this->eventBus->publish(...$p->pullDomainEvents());
    }

    // private function deleteMedias(Product $product): void
    // {
    //     /** @var File $media */
    //     foreach ($product->medias as $key => $media) {
    //         $this->filesystem->deleteFile($media->path, $media->name);
    //         $media->delete();
    //     }
    // }
}
