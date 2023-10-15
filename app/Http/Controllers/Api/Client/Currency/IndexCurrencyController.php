<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Currency;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Project\Domains\PublicApi\Currency\Application\Queries\Index\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class IndexCurrencyController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }

    public function __invoke(Request $request): JsonResponse
    {
        return $this->response->json(
            $this->queryBus->ask(
                Query::makeFromRequest($request)
            )
        );
    }
}
