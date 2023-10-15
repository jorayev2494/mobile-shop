<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Admin\Product;

use App\Http\Requests\Admin\Product\CreateProductRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Project\Domains\Admin\Product\Application\Commands\Create\Command;
use Project\Shared\Domain\Bus\Command\CommandBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

final class CreateProductController
{
    public function __construct(
        private readonly ResponseFactory $response,
        private readonly CommandBusInterface $commandBus,
        private readonly UuidGeneratorInterface $uuidGenerator,
    )
    {
        
    }

    public function __invoke(CreateProductRequest $request): JsonResponse
    {
        $uuid = $request->get('uuid', $this->uuidGenerator->generate());

        $command = new Command(
            $uuid,
            $request->get('title'),
            $request->get('category_uuid'),
            $request->get('currency_uuid'),
            (float) $request->get('price'),
            (int) $request->get('discount_presence'),
            $request->file('medias'),
            $request->get('description'),
            $request->get('is_active', true),
        );

        $this->commandBus->dispatch($command);

        return $this->response->json(['uuid' => $uuid], Response::HTTP_CREATED);
    }
}
