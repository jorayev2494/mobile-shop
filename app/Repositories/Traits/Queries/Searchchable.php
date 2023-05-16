<?php

declare(strict_types=1);

namespace App\Repositories\Traits\Queries;

use App\Data\Requests\IndexRequestDTO;
use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;


trait Seaerchable
{
    public function paginate(IndexRequestDTO $dataDTO, iterable $columns = ['+']): LengthAwarePaginator
    {
        /** @var Builder $build */
        $build = $this->getModelClone()->newQuery();

        return $build->paginate();
    }
}
