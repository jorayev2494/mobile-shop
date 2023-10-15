<?php

declare(strict_types=1);

namespace App\Enums;

enum RoutePattern: string
{
    case INTEGER = '[0-9]+';
    case UUID = '[a-f0-9]{8}-?[a-f0-9]{4}-?4[a-f0-9]{3}-?[89ab][a-f0-9]{3}-?[a-f0-9]{12}';
}
