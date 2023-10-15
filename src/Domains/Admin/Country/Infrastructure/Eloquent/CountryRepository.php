<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Eloquent;

use App\Models\Country as CountryModel;
use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Country\Domain\Country;
use Project\Domains\Admin\Country\Domain\CountryRepositoryInterface;
use Project\Domains\Admin\Country\Domain\ValueObjects\CountryUuid;

final class CountryRepository extends BaseModelRepository // implements CountryRepositoryInterface
{
    public function getModel(): string
    {
        return CountryModel::class;
    }

    // public function findByUUID(CountryUuid $uuid): ?Country
    // {
    //     /** @var CountryModel $foundCountry */
    //     $foundCountry = $this->getModelClone()->newQuery()->find($uuid->value);

    //     if ($foundCountry === null) {
    //         return $foundCountry;
    //     }

    //     $country = Country::fromPrimitives(
    //         $foundCountry->uuid,
    //         $foundCountry->value,
    //         $foundCountry->iso,
    //         $foundCountry->is_active,
    //         (int) $foundCountry->created_at,
    //         (int) $foundCountry->updated_at,
    //     );

    //     return $country;
    // }

    // public function save(Country $country): void
    // {
    //     $this->getModelClone()->newQuery()->updateOrCreate(
    //         ['uuid' => $country->uuid->value],
    //         [
    //             'uuid' => $country->uuid->value,
    //             'value' => $country->value->value,
    //             'iso' => $country->iso->value,
    //             'is_active' => $country->isActive,
    //         ],
    //     );
    // }

    // public function delete(CountryUuid $uuid): void
    // {
    //     /** @var CountryModel $foundCountry */
    //     $foundCountry = $this->getModelClone()->newQuery()->find($uuid->value);
    //     $foundCountry?->delete();
    // }

}
