<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Authentication\Domain\Member;
use Project\Domains\Client\Authentication\Domain\MemberRepositoryInterface;

final class MemberRepository extends BaseClientEntityRepository implements MemberRepositoryInterface
{
    public function getEntity(): string
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
