<?php

declare(strict_types=1);

namespace App\Jobs\Enums;

enum QueueType: string
{
    case MAIL = 'mail';
}
