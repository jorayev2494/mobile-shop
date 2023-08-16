<?php

declare(strict_types=1);

namespace App\Data\Profile;

use App\Data\Contracts\MakeFromFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordData implements MakeFromFormRequest
{
    public function __construct(
        public readonly string $device_id,
        public readonly string $current_password,
        public readonly string $password,
    ) {
    }

    public static function makeFromFormRequest(FormRequest $request): static
    {
        [
            'device_id' => $device_id,
            'current_password' => $current_password,
            'password' => $password,
        ] = $request->validated();

        return new static(
            $request->headers->get('x-device-id'),
            $current_password,
            $password,
        );
    }
}
