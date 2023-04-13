<?php

declare(strict_types=1);

namespace App\Data\Contracts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

interface MakeFromRequest
{
    public static function makeFromRequest(FormRequest|Request $request): self;
}
