<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Base\BaseModelRepository;

final class ClientRepository extends BaseModelRepository
{
    public function getModel(): string
    {
        return Client::class;
    }
}
