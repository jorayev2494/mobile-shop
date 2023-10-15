<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Subscribers\Category;

use Project\Domains\Admin\Category\Domain\Category\Events\CategoryWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Category\Category;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Shared\Domain\Bus\Event\DomainEventSubscriberInterface;

final class CategoryWasCreatedDomainEventSubscriber implements DomainEventSubscriberInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    )
    {
        
    }

    public static function subscribedTo(): array
    {
        return [
            CategoryWasCreatedDomainEvent::class,
        ];
    }

    public function __invoke(CategoryWasCreatedDomainEvent $event): void
    {
        $category = Category::fromPrimitives($event->uuid, $event->value, $event->isActive);

        $this->categoryRepository->save($category);
    }
}
