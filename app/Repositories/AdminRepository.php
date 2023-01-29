<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\Base\BaseModelRepository;

final class AdminRepository extends BaseModelRepository
{
    public function getModel(): string
    {
        return Admin::class;
    }
}
