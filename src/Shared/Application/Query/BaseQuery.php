<?php

namespace Project\Shared\Application\Query;

use App\Data\Contracts\MakeFromRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Domain\Bus\Query\QueryInterface;

abstract class BaseQuery implements QueryInterface, MakeFromRequest
{

    private function __construct(
        public readonly ?string $search,
        public readonly ?string $search_by,
        public readonly ?int $page,
        public readonly ?int $per_page,
        public readonly ?string $cursor,
        public readonly ?string $sort_by,
        public readonly ?bool $is_sort_desc,
        public readonly ?array $filters,
    )
    {
        
    }

    public static function make(
        ?string $search = null,
        ?string $search_by = null,
        ?int $page = null,
        ?int $per_page = null,
        ?string $cursor = null,
        ?string $sort_by = null,
        ?bool $is_sort_desc = null,
        ?array $filters = null,
    ): static
    {
        return new static(
            search: $search,
            search_by: $search_by,
            page: $page,
            per_page: $per_page,
            cursor: $cursor,
            sort_by: $sort_by,
            is_sort_desc: $is_sort_desc,
            filters: $filters,
        );
    }

    public static function makeFromRequest(Request|FormRequest $request): static
    {
        return new static(
            search: $request->query->get('search'),
            search_by: $request->query->get('search_by'),
            page: $request->query->getInt('page', 1),
            per_page: $request->query->getInt('per_page', 10),
            cursor: $request->query->get('cursor'),
            sort_by: $request->query->get('sort_by', 'created_at'),
            is_sort_desc: $request->query->getBoolean('is_sort_desc'),
            filters: self::makeFilters($request->get('filters', [])),
        );
    }

    private static function makeFilters(array $filters): array
    {
        return $filters;
    }

}

