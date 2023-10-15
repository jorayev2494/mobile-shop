<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Project\Domains\Client\Profile\Application\Queries\Show\Query;
use Project\Shared\Domain\Bus\Query\QueryBusInterface;

class ShowProfileController extends Controller
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly QueryBusInterface $queryBus,
    ) {

    }
    public function __invoke(): JsonResponse
    {
        $result = $this->queryBus->ask(
            new Query()
        );

        return $this->response->json($result);
    }
}
