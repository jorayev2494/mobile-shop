<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Category\Application\Commands\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Category\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Category\Domain\Category\ValueObjects\CategoryUuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class DeleteCategoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public readonly CategoryRepositoryInterface $repository,
        public readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(DeleteCategoryCommand $command): void
    {
        $category = $this->repository->findByUuid(CategoryUuid::fromValue($command->uuid));

        if ($category === null) {
            throw new ModelNotFoundException();
        }

        $category->delete();
        $this->repository->delete($category);
        $this->eventBus->publish(...$category->pullDomainEvents());
    }
}
