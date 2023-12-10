<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Test\Unit\Application;

use Project\Domains\Client\Authentication\Domain\Member;

class MemberFactory
{
    public const UUID = '31ca9c15-8d57-4f17-b95b-6c6dc6671a81';

    public const EMAIL = 'petya@gmail.com';

    public const PASSWORD = '12345Test_';

    public const PHONE = '09876';

    public static function make(
        string $uuid = null,
        string $email = null,
        string $phone = null,
    ): Member
    {
        return Member::fromPrimitives(
            $uuid ?? self::UUID,
            $email ?? self::EMAIL,
            $phone ?? self::PHONE,
        );
    }
}
