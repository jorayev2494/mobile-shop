<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Currency\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Currency\Domain\CurrencyRepositoryInterface;

class CurrencyRepository extends BaseModelRepository implements CurrencyRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Currency::class;
    }
}
