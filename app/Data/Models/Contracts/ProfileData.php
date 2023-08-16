<?php

declare(strict_types=1);

namespace App\Data\Models\Contracts;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;

abstract class ProfileData implements MakeFromFormRequest
{
    public static function makeFromFormRequest(FormRequest $request): static
    {
        return new static();
    }
}
