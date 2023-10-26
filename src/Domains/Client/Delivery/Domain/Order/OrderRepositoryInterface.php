<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Domain\Order;

use App\Repositories\Base\Doctrine\Paginator;
use Project\Domains\Client\Delivery\Domain\Order\Order;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\AuthorUuid;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\StatusEnum;
use Project\Domains\Client\Delivery\Domain\Order\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;

interface OrderRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Order;

    public function paginateByAuthorUuid(AuthorUuid $authorUuid, BaseQuery $queryDTO, StatusEnum $status): Paginator;

    public function save(Order $order): void;

    public function delete(Order $order): void;
}
