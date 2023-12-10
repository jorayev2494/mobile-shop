<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Commands\Order\Update;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Application\Commands\Order\Update\Command;
use Project\Domains\Client\Order\Application\Commands\Order\Update\CommandHandler;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid as AddressUuid;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Note;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Test\Unit\Application\AddressFactory;
use Project\Domains\Client\Order\Test\Unit\Application\CardFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;
use Project\Domains\Client\Order\Test\Unit\Application\OrderFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

/**
 * @group order
 * @group order-application
 */
class UpdateOrderHandlerTest extends TestCase
{
    public function testUpdate(): void
    {
        $handler = new CommandHandler(
            $orderRepository = $this->createMock(OrderRepositoryInterface::class),
            $clientRepository = $this->createMock(ClientRepositoryInterface::class),
            $cardRepository = $this->createMock(CardRepositoryInterface::class),
            $addressRepository = $this->createMock(AddressRepositoryInterface::class),
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $order = $this->getMockBuilder(Order::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'changeAddress',
                'changeCurrency',
                'changeNote',
            ])
            ->getMock();

        $orderRepository->expects($this->once())
            ->method('findByUuid')
            ->with(Uuid::fromValue(OrderFactory::UUID))
            ->will($this->returnValue($order));

        $addressRepository->expects($this->once())
            ->method('findByUuid')
            ->with(AddressUuid::fromValue(AddressFactory::UUID))
            ->will($this->returnValue($address = AddressFactory::make()));

        $currencyRepository->expects($this->once())
            ->method('findByUUid')
            ->with(CurrencyUUid::fromValue(CurrencyFactory::UUID))
            ->will($this->returnValue($currency = CurrencyFactory::make()));

        $order->expects($this->once())
            ->method('changeAddress')
            ->with($address);

        $order->expects($this->once())
            ->method('changeCurrency')
            ->with($currency);

        $order->expects($this->once())
            ->method('changeNote')
            ->with(Note::fromValue('Change Note custom note'));

        $orderRepository->expects($this->once())
            ->method('save')
            ->with($order);

        $eventBus->expects($this->once())
            ->method('publish');

        $handler(
            new Command(
                OrderFactory::UUID,
                ClientFactory::UUID,
                CardFactory::UUID,
                AddressFactory::UUID,
                CurrencyFactory::UUID,
                [
//                    [
//                        'uuid' => ProductFactory::UUID,
//                        'quantity' => 2,
//                    ],
//                    [
//                        'uuid' => 'a8a5a9b8-01fa-4d60-ba29-b0238baedec9',
//                        'quantity' => 4,
//                    ],
                ],
                OrderFactory::EMAIL,
                OrderFactory::PHONE,
                'Change Note custom note',
            )
        );
    }
}
