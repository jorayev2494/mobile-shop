<?php

namespace Project\Shared\Domain\Bus\Event;

use Illuminate\Contracts\Support\Arrayable;

interface Event extends \JsonSerializable, Arrayable
{
    public function getType(): string;
}