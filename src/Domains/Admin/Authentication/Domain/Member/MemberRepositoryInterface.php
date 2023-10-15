<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member;

interface MemberRepositoryInterface
{
    public function findByUuid(string $uuid): ?Member;
    public function findByEmail(string $email): ?Member;
    public function save(Member $member): void;
}
