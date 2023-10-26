<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Profile\Application\Profile;

use Project\Domains\Admin\Profile\Domain\Profile\Profile;

class ProfileFactory
{
    public const UUID = '2ad4e76a-ab4b-47d2-abdb-d44a79acf636';

    public const FIRST_NAME = 'Artem';

    public const LAST_NAME = 'Artemov';

    public const EMAIL = 'artem@gmail.com';

    public const PHONE = '12345';

    public static function make(
        string $uuid = null,
        string $firstName = null,
        string $lastName = null,
        string $email = null,
        string $phone = null,
    ): Profile
    {
        return Profile::fromPrimitives(
            $uuid ?? self::UUID,
            $firstName ?? self::FIRST_NAME,
            $lastName ?? self::LAST_NAME,
            $email ?? self::EMAIL,
            $phone ?? self::PHONE
        );
    }
}
