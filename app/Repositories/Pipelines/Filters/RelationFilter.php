<?php

declare(strict_types=1);

namespace App\Repositories\Pipelines\Filters;

use App\Data\Requests\IndexRequestDTO;
use App\Repositories\Pipelines\Filters\Base\FilterAbstract;
use Illuminate\Database\Eloquent\Builder;

class RelationFilter extends FilterAbstract
{
    public function filter(Builder $query, string $property, string $value): void
    {
        list($relation, $relationColum) = explode('.', $property);

        $query->whereHas($relation, static function (Builder $query) use ($relationColum, $value): void {
            if ($relationColum === 'full_name') {
                $query->where('first_name', 'LIKE', "%$value%", 'or');
                $query->where('last_name', 'LIKE', "%$value%", 'and');
            } else {
                $query->where($relationColum, 'LIKE', "%$value%", 'and');
            }
        });
    }
}
