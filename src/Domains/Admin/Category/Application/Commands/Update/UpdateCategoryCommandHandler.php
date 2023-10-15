<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Update;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class UpdateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {

    }

    public function __invoke(UpdateCategoryCommand $command): void
    {
        $category = $this->repository->findByUuid(CategoryUuid::fromValue($command->uuid));

        if ($category === null) {
            throw new ModelNotFoundException();
        }

        $category->changeValue(CategoryValue::fromValue($command->value));
        $category->changeIsActive($command->isActive);

        $this->repository->save($category);
    }
}
