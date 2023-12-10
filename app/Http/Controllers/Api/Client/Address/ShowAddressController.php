<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Address;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Order\Application\Queries\Address\Show\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowAddressController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(string $uuid): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query($uuid)
        );

        return $this->response->json($result);
    }
}
