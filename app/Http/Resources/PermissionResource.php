<?php

namespace App\Http\Resources;

use App\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Permission $resource
 */
class PermissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'value' => $this->resource->value,
            'model' => $this->resource->model,
            'action' => $this->resource->action,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at?->timestamp,
            'updated_at' => $this->resource->updated_at?->timestamp,
        ];
    }
}
