<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

class RegisterData extends Data implements MakeFromFormRequest
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        return static::from($request->validated());
    }
}
