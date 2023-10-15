<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Queries\Get;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Application\Query\BaseQuery;

final class Query extends BaseQuery
{
    public ?string $status;

    protected function fromRequest(Request|FormRequest $request): static
    {
        $this->status = $request->get('status');

        return $this;
    }
}
