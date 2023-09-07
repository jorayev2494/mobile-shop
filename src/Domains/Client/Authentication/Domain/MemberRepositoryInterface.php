<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface MemberRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findByUuid(string $uuid): ?Member;

    public function findByEmail(string $email): ?Member;

    public function save(Member $member): void;
}
