<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Order $resource
 */
class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->resource->uuid,
            'email' => $this->resource->email,
            'phone' => $this->resource->phone,
            'country_uuid' => $this->when(! $this->resource->relationLoaded('country'), $this->resource->country_uuid),
            'street' => $this->resource->street,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'quality' => $this->resource->quality,
            'sum' => $this->resource->sum,
            'discard_sum' => $this->resource->discard_sum,
            'is_active' => $this->resource->is_active,
            'country' => $this->whenLoaded('country'),
            'products' => OrderItemResource::collection($this->whenLoaded('products')),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
