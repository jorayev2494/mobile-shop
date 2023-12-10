<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Commands\Order\Delete;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Application\Commands\Order\Delete\Command;
use Project\Domains\Client\Order\Application\Commands\Order\Delete\CommandHandler;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Test\Unit\Application\OrderFactory;

/**
 * @group order
 * @group order-application
 */
class DeleteOrderHandlerTest extends TestCase
{
    public function testDelete(): void
    {
        $handler = new CommandHandler(
            $orderRepository = $this->createMock(OrderRepositoryInterface::class),
        );

        $order = $this->getMockBuilder(Order::class)
            ->disableOriginalConstructor()
            ->getMock();

        $order->expects($this->never())
            ->method('pullDomainEvents');

        $orderRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(OrderFactory::UUID))
            ->will($this->returnValue($order));

        $orderRepository->expects($this->once())
            ->method('delete')
            ->with($order);

        $handler(new Command(OrderFactory::UUID));
    }
}
