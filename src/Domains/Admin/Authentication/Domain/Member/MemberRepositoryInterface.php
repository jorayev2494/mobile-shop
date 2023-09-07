<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Member;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface MemberRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findByUuid(string $uuid): ?Member;
    public function findByEmail(string $email): ?Member;
    public function save(Member $member): void;
}
