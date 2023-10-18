<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Categories\Create;

use Project\Domains\Admin\Product\Domain\Category\Category;
use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Value;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository,
        private readonly EventBusInterface $eventBus,
    ) {

    }

    public function __invoke(Command $command): void
    {
        $category = Category::create(
            Uuid::fromValue($command->uuid),
            Value::fromValue($command->value),
            $command->isActive,
        );

        $this->repository->save($category);
        $this->eventBus->publish(...$category->pullDomainEvents());
    }
}
