<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Application\Commands\Categories\Update;

use Project\Domains\Admin\Product\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Uuid;
use Project\Domains\Admin\Product\Domain\Category\ValueObjects\Value;
use Project\Shared\Domain\Bus\Command\CommandHandlerInterface;
use Project\Shared\Domain\DomainException;

final class CommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly CategoryRepositoryInterface $repository
    ) {

    }

    public function __invoke(Command $command): void
    {
        $category = $this->repository->findByUuid(Uuid::fromValue($command->uuid));

        if ($category === null) {
            throw new DomainException('Category not found', 404);
        }

        $category->changeValue(Value::fromValue($command->value));
        $category->changeIsActive($command->isActive);

        $this->repository->save($category);
    }
}
