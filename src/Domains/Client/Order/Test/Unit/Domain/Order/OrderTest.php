<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Domain\Order;

use PHPUnit\Framework\TestCase;
use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Order\Events\OrderProductWasAddedDomainEvent;
use Project\Domains\Client\Order\Domain\Order\Events\OrderStatusWasChangedDomainEvent;
use Project\Domains\Client\Order\Domain\Order\Events\OrderWasCreatedDomainEvent;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Email;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Meta;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Note;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Phone;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\StatusEnum;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Uuid;
use Project\Domains\Client\Order\Domain\OrderProduct\OrderProduct;
use Project\Domains\Client\Order\Domain\OrderProduct\ValueObjects\Quantity;
use Project\Domains\Client\Order\Domain\Product\Product;
use Project\Domains\Client\Order\Test\Unit\Application\AddressFactory;
use Project\Domains\Client\Order\Test\Unit\Application\CardFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ClientFactory;
use Project\Domains\Client\Order\Test\Unit\Application\CurrencyFactory;
use Project\Domains\Client\Order\Test\Unit\Application\MetaFactory;
use Project\Domains\Client\Order\Test\Unit\Application\OrderFactory;
use Project\Domains\Client\Order\Test\Unit\Application\OrderProductFactory;
use Project\Domains\Client\Order\Test\Unit\Application\ProductFactory;

/**
 * @group order-domain
 */
class OrderTest extends TestCase
{
    public function testCreate(): void
    {
        $order = Order::create(
            Uuid::fromValue(OrderFactory::UUID),
            ClientFactory::make(),
            CardFactory::make(),
            AddressFactory::make(),
            CurrencyFactory::make(),
            Email::fromValue(OrderFactory::EMAIL),
            Phone::fromValue(OrderFactory::PHONE),
            Note::fromValue(OrderFactory::NOTE),
            [OrderProductFactory::make()],
            MetaFactory::make()
        );

        $this->assertNotNull($order);
        $this->assertInstanceOf(Order::class, $order);

        $this->assertInstanceOf(Uuid::class, $order->getUuid());
        $this->assertSame(OrderFactory::UUID, $order->getUuid()->value);

        $this->assertInstanceOf(Client::class, $order->getAuthor());
        $this->assertInstanceOf(Card::class, $order->getCard());
        $this->assertInstanceOf(Address::class, $order->getAddress());
        $this->assertInstanceOf(Currency::class, $order->getCurrency());

        $this->assertInstanceOf(Email::class, $order->getEmail());
        $this->assertSame(OrderFactory::EMAIL, $order->getEmail()->value);

        $this->assertInstanceOf(Phone::class, $order->getPhone());
        $this->assertSame(OrderFactory::PHONE, $order->getPhone()->value);

        $this->assertIsArray($orderProducts = $order->getOrderProducts());
        $this->assertCount(1, $orderProducts);
        $this->assertInstanceOf(OrderProduct::class, $orderProducts[0]);
        $this->assertInstanceOf(Product::class, $orderProducts[0]->getProduct());

        $this->assertInstanceOf(Meta::class, $meta = $order->getMeta());
        $this->assertSame(MetaFactory::QUANTITY, $meta->quantity);
        $this->assertSame(MetaFactory::SUM, $meta->sum);

        $this->assertIsArray($domainEvents = $order->pullDomainEvents());
        $this->assertCount(2, $domainEvents);
        $this->assertInstanceOf(OrderProductWasAddedDomainEvent::class, $domainEvents[0]);
        $this->assertInstanceOf(OrderWasCreatedDomainEvent::class, $domainEvents[1]);
    }

    public function testFromPrimitives(): void
    {
        $order = Order::fromPrimitives(
            OrderFactory::UUID,
            ClientFactory::make(),
            CardFactory::make(),
            AddressFactory::make(),
            CurrencyFactory::make(),
            OrderFactory::EMAIL,
            OrderFactory::PHONE,
            OrderFactory::NOTE,
            [OrderProductFactory::make()],
            MetaFactory::make()
        );

        $this->assertNotNull($order);
        $this->assertInstanceOf(Order::class, $order);

        $this->assertInstanceOf(Uuid::class, $order->getUuid());
        $this->assertSame(OrderFactory::UUID, $order->getUuid()->value);

        $this->assertInstanceOf(Client::class, $order->getAuthor());
        $this->assertInstanceOf(Card::class, $order->getCard());
        $this->assertInstanceOf(Address::class, $order->getAddress());
        $this->assertInstanceOf(Currency::class, $order->getCurrency());

        $this->assertInstanceOf(Email::class, $order->getEmail());
        $this->assertSame(OrderFactory::EMAIL, $order->getEmail()->value);

        $this->assertInstanceOf(Phone::class, $order->getPhone());
        $this->assertSame(OrderFactory::PHONE, $order->getPhone()->value);

        $this->assertIsArray($orderProducts = $order->getOrderProducts());
        $this->assertCount(1, $orderProducts);
        $this->assertInstanceOf(OrderProduct::class, $orderProducts[0]);
        $this->assertInstanceOf(Product::class, $orderProducts[0]->getProduct());

        $this->assertInstanceOf(Meta::class, $meta = $order->getMeta());
        $this->assertSame(MetaFactory::QUANTITY, $meta->quantity);
        $this->assertSame(MetaFactory::SUM, $meta->sum);

        $this->assertIsArray($domainEvents = $order->pullDomainEvents());
        $this->assertCount(1, $domainEvents);
        $this->assertInstanceOf(OrderProductWasAddedDomainEvent::class, $domainEvents[0]);
    }

    public function testAddOrderProduct(): void
    {
        $order = OrderFactory::make();

        $orderProduct = OrderProductFactory::make(
            ProductFactory::make('147fcc35-7d40-43b8-959f-306b38662d15'),
            Quantity::fromValue(2)
        );

        $order->addOrderProduct($orderProduct);

        $this->assertIsArray($orderProducts = $order->getOrderProducts());
        $this->assertCount(2, $domainEvents = $order->pullDomainEvents());

        /** @var OrderProduct::class $addedOrderProduct */
        $addedOrderProduct = $order->getOrderProducts()[1];
        $this->assertInstanceOf(OrderProduct::class, $addedOrderProduct);

        $this->assertInstanceOf(Product::class, $addedOrderProduct->getProduct());
        $this->assertSame('147fcc35-7d40-43b8-959f-306b38662d15', $addedOrderProduct->getProduct()->getUuid()->value);

        $this->assertInstanceOf(Quantity::class, $addedOrderProduct->getQuantity());
        $this->assertSame(2, $addedOrderProduct->getQuantity()->value);
    }

    /**
     * @dataProvider changeStatusProvider
     */
    public function testChangeStatus(StatusEnum $status): void
    {
        $order = OrderFactory::make();

        $this->assertInstanceOf(StatusEnum::class, $order->getStatus());
        $this->assertSame(StatusEnum::PENDING, $order->getStatus());

        $order->changeStatus($status);

        $this->assertInstanceOf(StatusEnum::class, $order->getStatus());
        $this->assertSame($status, $order->getStatus());

        $this->assertCount(2, $domainEvents = $order->pullDomainEvents());
        $this->assertInstanceOf(OrderStatusWasChangedDomainEvent::class, $domainEvents[1]);
    }

    public function changeStatusProvider(): array
    {
        return [
            // 'pending' => [StatusEnum::PENDING],
            'approved' => [StatusEnum::APPROVED],
            'delivery' => [StatusEnum::DELIVERY],
        ];
    }

    public function testChangeAddress(): void
    {
        $order = OrderFactory::make();

        $this->assertInstanceOf(Address::class, $order->getAddress());
        $this->assertSame(AddressFactory::UUID, $order->getAddress()->getUuid()->value);

        $order->changeAddress(
            AddressFactory::make(
                '2ab10514-787d-485a-832b-688ecd8356e4',
                'My new address',
                'Sasha',
                '5121cb2b-b1d6-417d-8281-d5aab8398a36',
                '15 Hreshatic apt 5',
                '5 Hreshatic apt 15',
                001234,
                '7aabf7e7-0a85-43b1-8e3b-703b6f8c0e18',
                'bbdd9e34-e61a-4d57-a31f-a313450bbbac',
                'My new district'
            )
        );

        $orderAddress = $order->getAddress();
        $this->assertInstanceOf(Address::class, $orderAddress);

        $this->assertNotSame(AddressFactory::UUID, $orderAddress->getUuid()->value);

        $this->assertSame('2ab10514-787d-485a-832b-688ecd8356e4', $orderAddress->getUuid()->value);
        $this->assertSame('My new address', $orderAddress->getTitle()->value);
        $this->assertSame('Sasha', $orderAddress->getFullName()->value);
        $this->assertSame('5121cb2b-b1d6-417d-8281-d5aab8398a36', $orderAddress->getAuthorUuid()->value);
        $this->assertSame('15 Hreshatic apt 5', $orderAddress->getFirstAddress()->value);
        $this->assertSame('5 Hreshatic apt 15', $orderAddress->getSecondAddress()->value);
        $this->assertSame(001234, $orderAddress->getZipCode()->value);
        $this->assertSame('7aabf7e7-0a85-43b1-8e3b-703b6f8c0e18', $orderAddress->getCountryUuid()->value);
        $this->assertSame('bbdd9e34-e61a-4d57-a31f-a313450bbbac', $orderAddress->getCityUuid()->value);
        $this->assertSame('My new district', $orderAddress->getDistrict()->value);
    }

    public function testChangeCurrency(): void
    {
        $order = OrderFactory::make();

        $this->assertInstanceOf(Currency::class, $order->getCurrency());
        $this->assertSame(CurrencyFactory::UUID, $order->getCurrency()->getUuid()->value);
        $this->assertSame(CurrencyFactory::CURRENCY, $order->getCurrency()->getValue()->value);

        $order->changeCurrency(
            CurrencyFactory::make(
                'c1bacea1-7290-4664-8e1c-7aa4d84d299b',
                'TMT',
            )
        );

        $orderCurrency = $order->getCurrency();
        $this->assertInstanceOf(Currency::class, $orderCurrency);

        $this->assertNotSame(CurrencyFactory::UUID, $orderCurrency->getUuid()->value);
        $this->assertNotSame(CurrencyFactory::CURRENCY, $orderCurrency->getValue()->value);

        $this->assertSame('c1bacea1-7290-4664-8e1c-7aa4d84d299b', $orderCurrency->getUuid()->value);
        $this->assertSame('TMT', $orderCurrency->getValue()->value);
    }

    public function testChangeNote(): void
    {
        $order = OrderFactory::make();

        $this->assertInstanceOf(Note::class, $order->getNote());
        $this->assertSame(OrderFactory::NOTE, $order->getNote()->value);

        $order->changeNote(Note::fromValue('My new note'));

        $orderNote = $order->getNote();
        $this->assertInstanceOf(Note::class, $orderNote);

        $this->assertNotSame(OrderFactory::NOTE, $orderNote->value);

        $this->assertNotNull('My new note', $orderNote->value);
        $this->assertSame('My new note', $orderNote->value);
    }

}
