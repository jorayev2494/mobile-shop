<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollectionResource extends ResourceCollection
{
    public $collects = OrderResource::class;

    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
