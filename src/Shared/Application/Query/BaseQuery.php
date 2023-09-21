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
        public readonly ?string $searchBy,
        public readonly ?int $page,
        public readonly ?int $perPage,
        public readonly ?string $cursor,
        public readonly ?string $sortBy,
        public readonly ?bool $sortRule,
        public readonly ?array $filters,
    )
    {
        
    }

    public static function make(
        ?string $search = null,
        ?string $searchBy = null,
        ?int $page = null,
        ?int $perPage = null,
        ?string $cursor = null,
        ?string $sortBy = null,
        ?bool $sortRule = null,
        ?array $filters = null,
    ): static
    {
        return new static(
            search: $search,
            searchBy: $searchBy,
            page: $page,
            perPage: $perPage,
            cursor: $cursor,
            sortBy: $sortBy,
            sortRule: $sortRule,
            filters: $filters,
        );
    }

    public static function makeFromRequest(Request|FormRequest $request): static
    {
        return new static(
            search: $request->query->get('search'),
            searchBy: $request->query->get('search_by'),
            page: $request->query->getInt('page', 1),
            perPage: $request->query->getInt('per_page', 10),
            cursor: $request->query->get('cursor'),
            sortBy: $request->query->get('sort_by', 'created_at'),
            sortRule: $request->query->getBoolean('sort_rule'),
            filters: self::makeFilters($request->get('filters', [])),
        );
    }

    private static function makeFilters(array $filters): array
    {
        return $filters;
    }

}

