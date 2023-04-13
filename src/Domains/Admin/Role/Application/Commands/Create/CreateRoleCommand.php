<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Create;

use App\Data\Contracts\MakeFromRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Application\Command\Command;

class CreateRoleCommand extends Command implements MakeFromRequest
{
    public function __construct(
        public readonly string $value,
        public readonly bool $isActive,
    )
    {
        
    }

    public static function makeFromRequest(FormRequest|Request $request): self
    {
        return new self(
            value: $request->get('value'),
            isActive: $request->boolean('is_active'),
        );
    }
}
