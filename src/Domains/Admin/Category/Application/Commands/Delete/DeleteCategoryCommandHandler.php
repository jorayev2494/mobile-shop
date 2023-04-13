<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Category\Domain\CategoryRepositoryInterface;
use Project\Domains\Category\Domain\ValueObjects\CategoryUUID;
use Project\Shared\Domain\Bus\Command\CommandHandler;

final class DeleteCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        public readonly CategoryRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $model = $this->repository->findOrNull($command->uuid);

        if ($model === null) {
            throw new ModelNotFoundException();
        }

        $this->repository->delete(CategoryUUID::fromValue($command->uuid));
    }
}
