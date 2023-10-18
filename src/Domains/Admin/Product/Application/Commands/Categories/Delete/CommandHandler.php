<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Categories\Delete;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        public readonly CategoryRepositoryInterface $repository,
        public readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $category = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($category === null) {
            throw new ModelNotFoundException();
        }

        $category->delete();
        $this->repository->delete($category);
        $this->eventBus->publish(...$category->pullDomainEvents());
    }
}
