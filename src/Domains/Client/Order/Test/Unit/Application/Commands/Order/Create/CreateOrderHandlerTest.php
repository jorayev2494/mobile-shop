<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application\Commands\Order\Create;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Application\Commands\Order\Create\Command;
use Project\Domains\Client\Order\Application\Commands\Order\Create\CommandHandler;
use Project\Domains\Client\Order\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Order\Domain\Address\ValueObjects\Uuid as AddressUuid;
use Project\Domains\Client\Order\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Order\Domain\Card\ValueObjects\Uuid as CardUuid;
use Project\Domains\Client\Order\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Order\Domain\Client\ValueObjects\Uuid as ClientUuid;
use Project\Domains\Client\Order\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Order\Domain\Currency\ValueObjects\Uuid as CurrencyUuid;
use Project\Domains\Client\Order\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Order\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Order\Test\Unit\Application\AddressFactory;
use Project\Domains\Client\Order\Test\Unit\Application\CardFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;
use Project\Domains\Client\Order\Test\Unit\Application\OrderFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

/**
 * @group order
 * @group order-application
 */
class CreateOrderHandlerTest extends TestCase
{
    public function testCreate(): void
    {
        $commandHandler = new CommandHandler(
            $orderRepository = $this->createMock(OrderRepositoryInterface::class),
            $clientRepository = $this->createMock(ClientRepositoryInterface::class),
            $cardRepository = $this->createMock(CardRepositoryInterface::class),
            $addressRepository = $this->createMock(AddressRepositoryInterface::class),
            $productRepository = $this->createMock(ProductRepositoryInterface::class),
            $currencyRepository = $this->createMock(CurrencyRepositoryInterface::class),
            $eventBus = $this->createMock(EventBusInterface::class),
        );

        $clientRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(ClientUuid::fromValue(ClientFactory::UUID))
                        ->will($this->returnValue($client = ClientFactory::make()));

        $cardRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(CardUuid::fromValue(CardFactory::UUID))
                        ->will($this->returnValue($card = CardFactory::make()));

        $addressRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(AddressUuid::fromValue( AddressFactory::UUID))
                        ->will($this->returnValue($address = AddressFactory::make()));

        $productRepository->expects($this->exactly(2))
                        ->method('findByUuid')
                        ->with(
                            $this->anything()
//                            $this->onConsecutiveCalls([
//                                ProductFactory::UUID
//                            ],
//                            [
//                                'babdd65d-5977-4d4e-a988-0ffd3f487717',
//                            ])
                        )
                        ->will($this->returnValue($product = ProductFactory::make()));

        $currencyRepository->expects($this->once())
                        ->method('findByUuid')
                        ->with(CurrencyUuid::fromValue(CurrencyFactory::UUID))
                        ->will($this->returnValue($currency = CurrencyFactory::make()));

//        $order = $this->createMock(Order::class);
//        $order->expects($this->once())
//            ->method('addOrderProduct')
//            ->with($orderProduct = OrderProductFactory::make());

        $orderRepository->expects($this->once())
                        ->method('save');

        $eventBus->expects($this->once())
                ->method('publish');

        $commandHandler(
            new Command(
                OrderFactory::UUID,
                ClientFactory::UUID,
                CardFactory::UUID,
                AddressFactory::UUID,
                CurrencyFactory::UUID,
                [
                    [
                        'uuid' => ProductFactory::UUID,
                        'quantity' => 1,
                    ],
                    [
                        'uuid' => 'babdd65d-5977-4d4e-a988-0ffd3f487717',
                        'quantity' => 3,
                    ],
                ],
                OrderFactory::EMAIL,
                OrderFactory::PHONE,
                OrderFactory::NOTE,
            )
        );

    }
}
