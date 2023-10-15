<?php

namespace App\Http\Controllers\Api\Admin\Country;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Project\Domains\Admin\Country\Application\Queries\Show\Query;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowCountryController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    )
    {
        
    }
   
    public function __invoke(string $uuid): JsonResponse
    {
        /** @var Country $result */
        $result = $this->queryBus->ask(
            new Query($uuid)
        );

        return $this->response->json($result->toArray());
    }
}
