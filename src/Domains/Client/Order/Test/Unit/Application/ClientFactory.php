<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Test\Unit\Application;

use Project\Domains\Client\Order\Domain\Client\Client;

class ClientFactory
{
    public const UUID = '6f9f7783-00cb-4dd8-ba57-29656f82c333';

    public const FIRST_NAME = 'Ivan';

    public const LAST_NAME = 'Ivanov';

    public const EMAIL = 'ivan@gmail.com';

    public const PHONE = '123456';

    public static function make(
        string $uuid = null,
        string $firstName = null,
        string $lastName = null,
        string $email = null,
        string $phone = null,
    ): Client
    {
        return Client::fromPrimitives(
            $uuid ?? self::UUID,
            $firstName ?? self::FIRST_NAME,
            $lastName ?? self::LAST_NAME,
            $email ?? self::EMAIL,
            $phone ?? self::PHONE,
        );
    }
}
