<?php

declare(strict_types=1);

namespace Project\Utils;

use RuntimeException;

final class JSON
{
    public static function encode(array $values): string
    {
        return json_encode($values, JSON_THROW_ON_ERROR);
    }

    public static function decode(string $json): array
    {
        $data = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Unable to parse response body into JSON: ' . json_last_error());
        }

        return $data;
    }
}
