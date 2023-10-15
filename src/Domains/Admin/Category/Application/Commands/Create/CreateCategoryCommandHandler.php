<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Create;

use Project\Domains\Admin\Category\Domain\Category\Category;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryValue;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CreateCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(CreateCategoryCommand $command): void
    {
        $category = Category::create(
            CategoryUuid::fromValue($command->uuid),
            CategoryValue::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($category);
        $this->eventBus->publish(...$category->pullDomainEvents());
    }
}
