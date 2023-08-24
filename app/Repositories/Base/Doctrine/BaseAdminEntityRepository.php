<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use App\Repositories\Base\Doctrine\Contracts\AdminEntityManagerInterface;

abstract class BaseAdminEntityRepository extends BaseEntityRepository
{
    public function __construct(AdminEntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }
}
