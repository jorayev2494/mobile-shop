<?php

declare(strict_types=1);

namespace Project\Shared\Domain\Bus\Event;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

interface Event extends Arrayable
{
}
