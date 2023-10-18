<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Currency;

use Illuminate\Contracts\Routing\ResponseFactory;
use Project\Domains\Admin\Product\Application\Queries\Currencies\Show\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ShowCurrencyController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }

    public function __invoke(string $uuid): JsonResponse
    {
        $currency = $this->queryBus->ask(
            new Query($uuid)
        );

        return $this->response->json($currency);
    }
}
