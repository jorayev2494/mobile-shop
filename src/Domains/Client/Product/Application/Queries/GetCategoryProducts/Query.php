<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Application\Queries\GetCategoryProducts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Application\Query\BaseQuery;

class Query extends BaseQuery
{
    public string $categoryUuid;

    protected function fromRequest(Request|FormRequest $request): static
    {
        $this->categoryUuid = $request->route()->parameter('category_uuid');

        return $this;
    }
}
