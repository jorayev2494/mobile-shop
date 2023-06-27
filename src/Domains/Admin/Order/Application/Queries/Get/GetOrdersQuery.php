<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Order\Application\Queries\Get;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Application\Query\BaseQuery;

final class GetOrdersQuery extends BaseQuery
{
    public ?string $status;

    public static function makeFromRequest(Request|FormRequest $request): static
    {
        $class = parent::makeFromRequest($request);
        $class->status = $request->get('status');

        return $class;
    }
}
