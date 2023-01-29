<?php

declare(strict_types=1);

namespace App\Repositories\Patterns;

use App\Repositories\Base\BaseModelRepository;
use InvalidArgumentException;

final class ModelRepositoryFactory
{
    private static array $availableModels = [
        \App\Models\Code::class => \App\Repositories\CodeRepository::class,
        \App\Models\Role::class => \App\Repositories\RoleRepository::class,
        \App\Models\Admin::class => \App\Repositories\AdminRepository::class,
        \App\Models\User::class => \App\Repositories\UserRepository::class,
    ];

    public static function make(string $model): BaseModelRepository
    {
        if (! array_key_exists($model, self::$availableModels)) {
            throw new InvalidArgumentException("This {$model} key is not found in list");
        }

        $modelRepository = self::$availableModels[$model];

        return resolve($modelRepository);
    }
}
