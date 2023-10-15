<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Domain;

use App\Repositories\Contracts\BaseModelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Project\Domains\Client\Order\Domain\ValueObjects\OrderUUID;
use Project\Shared\Application\Query\BaseQuery;

interface OrderProductRepositoryInterface extends BaseModelRepositoryInterface
{
    public function save(iterable $orderProducts): bool;
}
