<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use App\Repositories\Base\Doctrine\Contracts\ClientEntityManagerInterface;

abstract class BaseClientEntityRepository extends BaseEntityRepository
{
    public function __construct(ClientEntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }
}
