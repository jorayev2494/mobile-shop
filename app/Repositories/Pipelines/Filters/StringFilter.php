<?php

declare(strict_types=1);

namespace App\Repositories\Pipelines\Filters;

use App\Data\Requests\IndexRequestDTO;
use App\Repositories\Pipelines\Filters\Base\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class StringFilter extends FilterAbstract
{
    public function filter(Builder $query, string $property, string $value): void
    {                    
        $query->where($property, 'LIKE', "%$value%", 'and');
    }
}
