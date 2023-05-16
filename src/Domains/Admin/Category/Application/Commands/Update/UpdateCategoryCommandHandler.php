<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Category\Domain\Category;
use Project\Domains\Category\Domain\CategoryRepositoryInterface;
use Project\Shared\Domain\Bus\Command\CommandHandler;

final class UpdateCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $model = $this->repository->findOrNull($command->uuid);

        if ($model === null) {
            throw new ModelNotFoundException();
        }

        $category = Category::fromPrimitives(
            $command->uuid,
            $command->value,
            $command->isActive
        );

        $this->repository->save($category);
    }
}
