<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Client\Authentication;

use App\Http\Requests\Client\Auth\LogoutRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Client\Authentication\Application\Commands\Logout\Command;
use Project\Domains\Client\Authentication\Application\Commands\Logout\CommandHandler;

class LogoutController
{
    public function __construct(
        private readonly ResponseFactory $response,
    )
    {
        
    }

    public function __invoke(LogoutRequest $request, CommandHandler $handler): Response
    {
        $handler(new Command($request->headers->get('x-device-id')));

        // dd($handler);

        return $this->response->noContent();
    }
}
