<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Role\Application\Commands\Update;

use App\Data\Contracts\MakeFromRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Project\Shared\Application\Command\Command;

final class UpdateRoleCommand extends Command implements MakeFromRequest
{
    public function __construct(
        public readonly int $id,
        public readonly string $value,
        public readonly bool $isActive,
    )
    {

    }

    public static function makeFromRequest(FormRequest|Request $request): self
    {
        return new self(
            id: $request->get('id'),
            value: $request->get('value'),
            isActive: $request->boolean('is_active'),
        );
    }
}
