<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Subscribers\Category;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Product\Domain\Category\Events\CategoryWasDeletedDomainEvent;
use Project\Domains\Client\Order\Application\Subscribers\Category\CategoryWasDeletedDomainEventSubscriber;
use Project\Domains\Client\Order\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Order\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\CategoryFactory;

/**
 * @group order-subscriber
 * @group order-category-subscriber
 */
class CategoryWasDeletedDomainEventSubscriberTest extends TestCase
{
    public function testSubscribedTo(): void
    {
        $this->assertContainsEquals(
            CategoryWasDeletedDomainEvent::class,
            CategoryWasDeletedDomainEventSubscriber::subscribedTo()
        );
    }

    public function testEventHandler(): void
    {
        $handler = new CategoryWasDeletedDomainEventSubscriber(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(CategoryFactory::UUID))
            ->will($this->returnValue($category = CategoryFactory::make()));

        $categoryRepository->expects($this->once())
            ->method('delete')
            ->with($category);

        $handler(new CategoryWasDeletedDomainEvent(CategoryFactory::UUID));
    }

    public function testCategoryNotFound(): void
    {
        $handler = new CategoryWasDeletedDomainEventSubscriber(
            $categoryRepository = $this->createMock(CategoryRepositoryInterface::class),
        );

        $categoryRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(CategoryFactory::UUID))
            ->willReturn(null);

        $categoryRepository->expects($this->never())
            ->method('delete');

        $handler(new CategoryWasDeletedDomainEvent(CategoryFactory::UUID));
    }
}
