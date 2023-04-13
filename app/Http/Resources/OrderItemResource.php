<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Product $resource
 */
class OrderItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'meta' => [
                'uuid' => $this->resource->uuid,
                'product_uuid' => $this->resource->product_uuid,
                'quality' => $this->resource->quality,
                'sum' => $this->resource->sum,
                'discard_sum' => $this->resource->discard_sum,
            ],
            'uuid' => $this->resource->product_uuid,
            'title' => $this->resource->title,
            'category_uuid' => $this->when(! $this->resource->relationLoaded('category'), $this->resource->category_uuid),
            'currency_uuid' => $this->when(! $this->resource->relationLoaded('currency'), $this->resource->currency_uuid),
            'price' => $this->resource->price,
            'discount_percentage' => $this->resource->discount_percentage,
            'discount_price' => $this->resource->discount_price,
            'viewed_count' => $this->resource->viewed_count,
            'description' => $this->resource->description,
            'is_active' => $this->resource->is_active,
            'category' => $this->whenLoaded('category'),
            'currency' => $this->whenLoaded('currency'),
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }

    // public function with($request): array
    // {
    //     return [
    //         'meta' => [
    //             'quality' => $this->resource->quality,
    //             'sum' => $this->resource->sum,
    //             'discard_sum' => $this->resource->discard_sum,
    //         ]
    //     ];
    // }
}
