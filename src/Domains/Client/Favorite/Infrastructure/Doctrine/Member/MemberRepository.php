<?php

declare(strict_types=1);

namespace Project\Domains\Client\Favorite\Infrastructure\Doctrine\Member;
use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Favorite\Domain\Member\Member;
use Project\Domains\Client\Favorite\Domain\Member\MemberRepositoryInterface;
use Project\Domains\Client\Favorite\Domain\Member\ValueObjects\MemberUuid;

final class MemberRepository extends BaseClientEntityRepository implements MemberRepositoryInterface
{
    protected function getEntity(): string
    {
        return Member::class;
    }

    public function findByUuid(MemberUuid $uuid): ?Member
    {
        return $this->entityRepository->find($uuid);
    }

    public function save(Member $member): void
    {
        $this->entityRepository->getEntityManager()->persist($member);
        $this->entityRepository->getEntityManager()->flush();
    }
}
