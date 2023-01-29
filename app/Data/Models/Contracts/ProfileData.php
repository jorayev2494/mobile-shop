<?php

declare(strict_types=1);

namespace App\Data\Models\Contracts;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

abstract class ProfileData extends Data implements MakeFromFormRequest
{
    public static function makeFromFormRequest(FormRequest $request): static
    {
        return parent::from($request->validated());
    }
}
