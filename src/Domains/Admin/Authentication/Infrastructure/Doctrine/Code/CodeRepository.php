<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Code;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Authentication\Domain\Code\Code;
use Project\Domains\Admin\Authentication\Domain\Code\CodeRepositoryInterface;

final class CodeRepository extends BaseAdminEntityRepository implements CodeRepositoryInterface
{
    public function getEntity(): string
    {
        return Code::class;
    }

    public function findByToken(string $token): ?Code
    {
        return $this->entityRepository->findOneBy(['value' => $token]);
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
