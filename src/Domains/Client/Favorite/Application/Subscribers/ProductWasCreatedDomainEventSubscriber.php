<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Application\Subscribers;

use Project\Domains\Admin\Product\Domain\Product\Events\ProductWasCreatedDomainEvent;
use Project\Domains\Client\Favorite\Domain\Product\Product;
use Project\Domains\Client\Favorite\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductCategoryUuid;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductDescription;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductPrice;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductTitle;
use Project\Domains\Client\Favorite\Domain\Product\ValueObjects\ProductUuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class ProductWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
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
        [
            'value' => $value,
            'discount_percentage' => $discountPercentage,
            'currency_uuid' => $currencyUuid,
        ] = $event->price;

        $product = Product::create(
            ProductUuid::fromValue($event->uuid),
            ProductTitle::fromValue($event->title),
            ProductCategoryUuid::fromValue($event->categoryUuid),
            new ProductPrice($value, $discountPercentage, $currencyUuid),
            ProductDescription::fromValue($event->description),
            $event->isActive,
        );

        $this->productRepository->save($product);
    }
}
