<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Role $resource
 */
class RoleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'value' => $this->resource->value,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at?->timestamp,
            'updated_at' => $this->resource->updated_at?->timestamp,
        ];
    }
}
