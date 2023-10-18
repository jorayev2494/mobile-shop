<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Application\Subscribers\Category;

use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasDeletedDomainEvent;
use Project\Domains\Client\Cart\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Cart\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CategoryWasDeletedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {

    }

    public static function subscribedTo(): array
    {
        return [
            CategoryWasDeletedDomainEvent::class,
        ];
    }

    public function __invoke(CategoryWasDeletedDomainEvent $event): void
    {
        $category = $this->categoryRepository->findByUuid(Uuid::fromValue($event->uuid));

        if ($category === null) {
            return;
        }

        $this->categoryRepository->delete($category);
    }
}
