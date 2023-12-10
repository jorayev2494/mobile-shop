<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Card\Card;
use Project\Domains\Client\Order\Domain\Client\Client;

class CardFactory
{
    public const UUID = '5fa4a56b-d24f-435c-ad40-c81bbddc0762';

    public const TYPE = 'visa';

    public const HOLDER_NAME = 'Ivan Ivanov';

    public const NUMBER = '1234-1234-1234-1234';

    public const CVV = 123;

    public const EXPIRATION_DATE = '12/25';

    public static function make(
        string $uuid = null,
        Client $client = null,
        string $type = null,
        string $holderName = null,
        string $number = null,
        string $cvv = null,
        string $expirationDate = null,
    ): Card
    {
        return Card::fromPrimitives(
            $uuid ?? self::UUID,
            $client ?? ClientFactory::make(),
            $type ?? self::TYPE,
            $holderName ?? self::HOLDER_NAME,
            $number ?? self::NUMBER,
            $cvv ?? self::CVV,
            $expirationDate ?? self::EXPIRATION_DATE,
        );
    }
}
