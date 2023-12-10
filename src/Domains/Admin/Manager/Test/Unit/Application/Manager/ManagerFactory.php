<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Test\Unit\Application\Manager;

use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerPhone;

class ManagerFactory
{
    public const UUID = 'e0d14400-6f2d-4ee5-8813-c85693f94642';

    public const FIRST_NAME = 'Alex';

    public const LAST_NAME = 'Alexov';

    public const EMAIL = 'alex@gmail.com';

    public const ROLE_ID = 1;

    public const PHONE = '123456';

    public static function make(
        string $uuid = null,
        string $firstName = null,
        string $lastName = null,
        string $email = null,
        string $phone = null,
    ): Manager
    {
        $manager = Manager::fromPrimitives(
            $uuid ?? self::UUID,
            $firstName ?? self::FIRST_NAME,
            $lastName ?? self::LAST_NAME,
            $email ?? self::EMAIL,
        );

        $manager->setPhone(ManagerPhone::fromValue(self::PHONE));

        return $manager;
    }
}
