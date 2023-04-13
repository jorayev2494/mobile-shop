<?php

declare(strict_types=1);

namespace App\Data\Contracts;

use Illuminate\Foundation\Http\FormRequest;

interface MakeFromFormRequest
{
    public static function makeFromFormRequest(FormRequest $request): static;
}
