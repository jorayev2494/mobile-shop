<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Domain\Member;

use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;

interface MemberRepositoryInterface
{
    public function findByUuid(MemberUuid $uuid): ?Member;
    public function save(Member $member): void;
}
