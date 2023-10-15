<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Requests\Admin\Product\UpdateProductRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Project\Domains\Admin\Product\Application\Commands\Update\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;

final class UpdateProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
    ) {

    }

    public function __invoke(UpdateProductRequest $request, string $uuid): Response
    {
        $command = new Command(
            $uuid,
            $request->get('title'),
            $request->get('category_uuid'),
            $request->get('currency_uuid'),
            $request->get('price'),
            $request->get('discount_presence'),
            $request->file('medias', []),
            $request->get('remove_media_ids', []),
            $request->get('description'),
            $request->get('is_active', true),
        );

        $this->commandBus->dispatch($command);

        return $this->response->noContent(Response::HTTP_ACCEPTED);
    }
}
