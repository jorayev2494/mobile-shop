<?php

declare(strict_types=1);

namespace Project\Domains\Client\Cart\Domain\Cart\ValueObjects;

enum CartStatus : string
{
    case DRAFT = 'draft';
    case ORDERED = 'ordered';
}
