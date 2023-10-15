<?php

declare(strict_types=1);

namespace Project\Domains\Client\Order\Application\Queries\Get;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Application\Query\BaseQuery;

final class Query extends BaseQuery
{
    private function __construct(
        public readonly ?string $status,
        public readonly ?string $search,
        public readonly ?string $searchBy,
        public readonly ?int $page,
        public readonly ?int $perPage,
        public readonly ?string $cursor,
        public readonly ?string $sortBy,
        public readonly ?bool $sortRule,
        public readonly ?array $filters,
    ) {

    }

    public static function makeFromRequest(Request|FormRequest $request): static
    {
        return new static(
            status: $request->query->get('status'),
            search: $request->query->get('search'),
            searchBy: $request->query->get('search_by'),
            page: $request->query->getInt('page', 1),
            perPage: $request->query->getInt('per_page', 10),
            cursor: $request->query->get('cursor'),
            sortBy: $request->query->get('sort_by', 'created_at'),
            sortRule: $request->query->getBoolean('sort_rule'),
            filters: static::makeFilters($request->get('filters', [])),
        );
    }
}
