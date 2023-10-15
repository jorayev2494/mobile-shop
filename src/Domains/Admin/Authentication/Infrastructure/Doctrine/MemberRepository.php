<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Authentication\Domain\Member\Member;
use Project\Domains\Admin\Authentication\Domain\Member\MemberRepositoryInterface;

final class MemberRepository extends BaseAdminEntityRepository implements MemberRepositoryInterface
{
    protected function getEntity(): string
    {
        return Member::class;
    }

    public function findByUuid(string $uuid): ?Member
    {
        return $this->entityRepository->find($uuid);
    }

    public function findByEmail(string $email): ?Member
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function save(Member $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}
