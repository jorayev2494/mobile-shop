<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Create;

use Project\Domains\Category\Domain\Category;
use Project\Domains\Category\Domain\CategoryRepositoryInterface;
use Project\Domains\Category\Domain\ValueObjects\CategoryUUID;
use Project\Domains\Category\Domain\ValueObjects\CategoryValue;
use Project\Shared\Domain\Bus\Command\CommandHandler;

final class CreateCategoryCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    )
    {
        
    }

    public function __invoke(CreateCategoryCommand $command): array
    {
        $uuid = CategoryUUID::generate();

        $category = Category::create(
            $uuid,
            CategoryValue::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($category);

        return ['uuid' => $uuid->value];
    }
}
