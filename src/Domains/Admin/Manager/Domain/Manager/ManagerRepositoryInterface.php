<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Manager;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Manager\Domain\Manager\ValueObjects\ManagerUuid;
use Project\Shared\Application\Query\BaseQuery;

interface ManagerRepositoryInterface
{
    public function paginate(BaseQuery $baseQuery): Paginator;

    public function findByUuid(ManagerUuid $uuid): ?Manager;

    public function save(Manager $manager): void;

    public function delete(Manager $manager): void;
}
