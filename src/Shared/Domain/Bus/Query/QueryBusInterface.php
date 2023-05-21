<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Query;

interface QueryBusInterface
{
    public function ask(QueryInterface $query): ?ResponseInterface;
}
