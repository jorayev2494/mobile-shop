<?php

namespace App\Http\Resources\Collection;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollectionResource extends ResourceCollection
{

    public $collects = ProductResource::class;

    public function toArray($request): array
    {
        return $this->resource->toArray();
    }
}
