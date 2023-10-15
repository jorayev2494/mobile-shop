<?php

declare(strict_types=1);

namespace Project\Domains\Client\Country\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Client\Country\Domain\CountryRepositoryInterface;

final class CountryRepository extends BaseModelRepository implements CountryRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Country::class;
    }
}
