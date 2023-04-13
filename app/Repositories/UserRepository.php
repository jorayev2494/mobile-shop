<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseModelRepository;

final class UserRepository extends BaseModelRepository
{
    public function getModel(): string
    {
        return User::class;
    }
}
