<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Authentication;

use App\Http\Requests\Admin\Auth\LogoutRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Authentication\Application\Commands\Logout\Command;
use Project\Domains\Admin\Authentication\Application\Commands\Logout\CommandHandler;

class LogoutController
{
    public function __construct(
        public readonly ResponseFactory $response,
    )
    {
        
    }

    public function __invoke(LogoutRequest $request, CommandHandler $handler): Response
    {
        $handler(
            new Command($request->headers->get('x-device-id'))
        );

        return $this->response->noContent();
    }
}
