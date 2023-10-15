<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;

final class RestorePasswordData implements MakeFromFormRequest
{
    public function __construct(
        public readonly string $token,
        public readonly string $password,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        ['token' => $token, 'password' => $password] = $request->validated();

        return new static($token, $password);
    }
}
