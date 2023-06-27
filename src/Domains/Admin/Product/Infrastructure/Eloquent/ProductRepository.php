<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Eloquent;

use App\Repositories\Base\BaseModelRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Project\Domains\Admin\Product\Domain\Product;
use Project\Domains\Admin\Product\Domain\ProductRepositoryInterface;
use Project\Domains\Admin\Product\Domain\ValueObjects\ProductUUID;
use Project\Shared\Application\Query\BaseQuery;

final class ProductRepository extends BaseModelRepository implements ProductRepositoryInterface
{
    public function getModel(): string
    {
        return \App\Models\Product::class;
    }

    public function findOrNull(string|int $value, string $field = null, array $columns = ['*']): ?Model
    {
        return $this->getModelClone()->newQuery()
                                    ->where($field ?? $this->getModelClone()->getKeyName(), $value)
                                    ->with(['medias'])
                                    ->first($columns);
    }

    public function getPaginate(BaseQuery $queryData, iterable $columns = ['*']): LengthAwarePaginator
    {
        /** @var Builder $build */
        $query = $this->getModelClone()->newQuery();
        $query->select($columns);

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        $query->with(['cover', 'medias']);

        return $query->paginate($queryData->per_page);
    }

    public function save(Product $product): bool
    {
        /** @var \App\Models\Product $createdProduct */
        $createdProduct = $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'uuid' => $product->uuid->value,
            ],
            $product->toArray()
        );

        if (count($product->medias) > 0) {
            // dd($product->medias);
            $createdProduct->medias()->createMany($product->medias);
        }

        return (bool) $createdProduct;
    }

    public function delete(ProductUUID $uuid): void
    {
        $this->getModelClone()->newQuery()->find($uuid->value)->delete();
    }
}