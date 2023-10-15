<?php

declare(strict_types=1);

namespace Project\Utils;

final class Str
{
    public static function toSnakeCase(string $str): string
    {
        return ctype_lower($str) ? $str : strtolower((string) preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $str));
    }

    public static function toCamelCase(string $str): string
    {
        return lcfirst(str_replace('_', '', ucwords($str, '_')));
    }

    public static function dot(array $array, string $prepend = ''): array
    {
        $results = [];
        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }
}
