<?php

declare(strict_types=1);

namespace Project\Domains\Client\Product\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Project\Domains\Client\Product\Domain\Product;
use Project\Domains\Client\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Client\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Application\Query\BaseQuery;

final class ProductRepository extends BaseModelRepository implements ProductRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Product::class;
    }

    public function indexSimplePaginate(BaseQuery $queryData, iterable $columns = ['*']): Paginator
    {
        /** @var Builder $build */
        $query = $this->getModelClone()->newQuery();
        $query->select($columns);

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        $query->with(['currency:uuid,value', 'cover']);

        return $query->simplePaginate($queryData->per_page)->withQueryString();
    }

    public function findByUUID(ProductUUID $uuid): ?Product
    {
        /** @var \App\Models\Product $fProduct */
        $fProduct = $this->getModelClone()->newQuery()
                                    ->with(['currency:uuid,value', 'medias'])
                                    ->find($uuid->value);

        if ($fProduct === null) {
            return null;
        }

        $product = Product::fromPrimitives(
            $fProduct->uuid,
            $fProduct->title,
            $fProduct->category_uuid,
            $fProduct->currency_uuid,
            (string) $fProduct->price,
            (string) $fProduct->discount_percentage,
            $fProduct->medias ?? [],
            $fProduct->viewed_count,
            $fProduct->description
        );

        $product->setCurrency($fProduct->currency->toArray());

        return $product;
    }


}