<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine\Code;

use App\Repositories\Base\Doctrine\BaseClientEntityRepository;
use Project\Domains\Client\Authentication\Domain\Code\Code;
use Project\Domains\Client\Authentication\Domain\Code\CodeRepositoryInterface;

final class CodeRepository extends BaseClientEntityRepository implements CodeRepositoryInterface
{
    public function getEntity(): string
    {
        return Code::class;
    }

    public function findByCode(int $value): ?Code
    {
        return $this->entityRepository->findOneBy(['value' => $value]);
    }

    public function save(Code $code): void
    {
        $this->entityRepository->getEntityManager()->persist($code);
        $this->entityRepository->getEntityManager()->flush();
    }

    public function delete(Code $code): void
    {
        $this->entityRepository->getEntityManager()->remove($code);
        $this->entityRepository->getEntityManager()->flush();
    }
}
