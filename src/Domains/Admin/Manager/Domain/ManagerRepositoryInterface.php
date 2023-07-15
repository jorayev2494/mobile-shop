<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain;
use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerUUID;
use Project\Shared\Application\Query\BaseQuery;

interface ManagerRepositoryInterface extends BaseModelRepositoryInterface
{
    public function indexPaginate(BaseQuery $baseQuery): LengthAwarePaginator;

    public function findByUUID(ManagerUUID $uuid): ?Manager;

    public function save(Manager $manager): bool;

    public function delete(ManagerUUID $uuid): void;
}
