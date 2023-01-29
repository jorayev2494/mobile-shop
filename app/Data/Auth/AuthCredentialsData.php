<?php

declare(strict_types=1);

namespace App\Data\Auth;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\LaravelData\Data;

class AuthCredentialsData extends Data implements MakeFromFormRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly string $device_id,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        return self::from([
            ...$request->validated(),
            'device_id' => $request->headers->get('x-device-id'),
        ]);
    }
}
