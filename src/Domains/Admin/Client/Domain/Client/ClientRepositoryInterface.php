<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Domain\Client;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Shared\Application\Query\BaseQuery;

interface ClientRepositoryInterface
{
    public function paginate(BaseQuery $dataDTO): Paginator;

    public function findByUuid(ClientUuid $uuid): ?Client;

    public function save(Client $client): void;

    public function delete(Client $client): void;
}
