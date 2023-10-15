<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Product;

use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Product\Product;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Domain\Product\ValueObjects\Price;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProductWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            ProductWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(ProductWasCreatedDomainEvent $event): void
    {
        $category = $this->categoryRepository->findByUuid(Uuid::fromValue($event->categoryUuid));

        [
            'value' => $value,
            'discount_percentage' => $discountPercentage,
            'currency_uuid' => $currencyUuid,
        ] = $event->price;

        $product = Product::fromPrimitives(
            $event->uuid,
            $event->title,
            $category,
            new Price($value, $discountPercentage, $currencyUuid),
            $event->description,
            $event->viewedCount,
            $event->isActive,
        );

        $this->productRepository->save($product);
    }
}
