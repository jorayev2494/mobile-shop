<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Create;

use Project\Domains\Admin\Category\Domain\Category;
use Project\Domains\Admin\Category\Domain\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\ValueObjects\CategoryUUID;
use Project\Domains\Admin\Category\Domain\ValueObjects\CategoryValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;

final class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::create(
            CategoryUUID::fromValue($command->uuid),
            CategoryValue::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($category);
    }
}
