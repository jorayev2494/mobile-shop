<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Code;
use App\Repositories\Base\BaseModelRepository;

final class CodeRepository extends BaseModelRepository
{
    public function getModel(): string
    {
        return Code::class;
    }
}
