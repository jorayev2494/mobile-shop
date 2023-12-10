<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Category;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasCreatedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Category\CategoryWasCreatedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Order\Test\Unit\Application\CategoryFactory;

/**
 * @group order-subscriber
 * @group order-category-subscriber
 */
class CategoryWasCreatedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            CategoryWasCreatedDomainEvent::class,
            CategoryWasCreatedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new CategoryWasCreatedDomainEventSubscriber(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
            ->method('save')
            ->with(CategoryFactory::make());

        $handler(
            new CategoryWasCreatedDomainEvent(
                CategoryFactory::UUID,
                CategoryFactory::CATEGORY,
                CategoryFactory::IS_ACTIVE,
            )
        );
    }
}
