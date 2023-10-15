<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Product $resource
 */
class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'uuid' => $this->resource->uuid,
            'title' => $this->resource->title,
            'category_uuid' => $this->when(! $this->resource->relationLoaded('category'), $this->resource->category_uuid),
            'currency_uuid' => $this->when(! $this->resource->relationLoaded('currency'), $this->resource->currency_uuid),
            'cover' => $this->whenLoaded('cover'),
            'price' => $this->resource->price,
            'discount_percentage' => (int) $this->resource->discount_percentage,
            'discount_price' => $this->resource->discount_price,
            'viewed_count' => $this->resource->viewed_count,
            'description' => $this->resource->description,
            'medias' => $this->whenLoaded('medias'),
            'is_active' => $this->resource->is_active,
            'category' => $this->whenLoaded('category'),
            'currency' => $this->whenLoaded('currency'),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
