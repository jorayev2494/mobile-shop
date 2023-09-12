<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Project\Shared\Application\Query\BaseQuery;

abstract class BaseEntityRepository extends EntityRepository
{
    protected EntityRepository $entityRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->initRepository($entityManager);
    }

    private function initRepository(EntityManagerInterface $entityManager): void
    {
        if ($this->getEntity()) {
            $this->entityRepository = $entityManager->getRepository($this->getEntity());
        }

    }

    abstract protected function getEntity();

    protected function paginator($query, BaseQuery $dataDTO, bool $fetchJoinCollection = true): Paginator
    {
        return new Paginator($query, $dataDTO, $fetchJoinCollection);
    }
}
