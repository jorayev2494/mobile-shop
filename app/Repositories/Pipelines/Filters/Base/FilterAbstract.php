<?php

declare(strict_types=1);

namespace App\Repositories\Pipelines\Filters\Base;

use Illuminate\Database\Eloquent\Builder;

abstract class FilterAbstract
{
    public function handle(array $data, \Closure $next): mixed
    {
        ['query' => $query, 'type' => $type, 'key' => $property, 'value' => $value] = $data;

        if ($this->canExecute($type)) {
            $this->filter($query, $property, $value);
        }

        return $next($data);
    }

    abstract public function filter(Builder $query, string $property, string $value): void;

    private function canExecute(string $type): bool
    {
        return $this->getType() === $type;
    }

    private function getType(): string
    {
        return strtolower(str_replace('Filter', '', class_basename($this)));
    }

}
