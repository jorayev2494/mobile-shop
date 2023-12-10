<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Address\Address;
use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Client\Client;
use Project\Domains\Client\Order\Domain\Currency\Currency;
use Project\Domains\Client\Order\Domain\Order\Order;
use Project\Domains\Client\Order\Domain\Order\ValueObjects\Meta;

class OrderFactory
{
    public const UUID = '8750920f-5478-4dc0-8bfa-cfad88f22207';

    public const EMAIL = 'order@gmail.com';

    public const PHONE = '1234567';

    public const NOTE = 'Note is here';

//    public const ORDER_PRODUCTS = [
//
//    ];

    public static function make(
        string $uuid = null,
        Client $author = null,
        Card $card = null,
        Address $address = null,
        Currency $currency = null,
        string $email = null,
        string $phone = null,
        string $note = null,
        string $orderProducts = null,
        Meta $meta = null,
    ): Order
    {
        return Order::fromPrimitives(
            $uuid ?? self::UUID,
            $author ?? ClientFactory::make(),
            $card ?? CardFactory::make(),
            $address ?? AddressFactory::make(),
            $currency ?? CurrencyFactory::make(),
            $email ?? self::EMAIL,
            $phone ?? self::PHONE,
            $note ?? self::NOTE,
            $orderProducts ?? [
                OrderProductFactory::make(),
            ],
            $meta ?? MetaFactory::make(),
        );
    }
}
