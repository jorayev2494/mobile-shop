<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Member;

use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUUID;

final class Member
{
    public function __construct(
        public readonly MemberUUID $uuid,
    )
    {
        
    }
}
