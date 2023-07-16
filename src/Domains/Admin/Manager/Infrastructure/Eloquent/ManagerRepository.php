<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Infrastructure\Eloquent;

use App\Models\Admin as AdminModel;
use App\Repositories\Base\BaseModelRepository;
use Project\Domains\Admin\Manager\Domain\ManagerRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Project\Domains\Admin\Manager\Domain\Manager;
use Project\Domains\Admin\Manager\Domain\Avatar;
use Project\Domains\Admin\Manager\Domain\ValueObjects\ManagerUUID;
use Project\Shared\Application\Query\BaseQuery;

class ManagerRepository extends BaseModelRepository implements ManagerRepositoryInterface
{
    public function getModel(): string
    {
        return AdminModel::class;
    }

    public function indexPaginate(BaseQuery $queryData): LengthAwarePaginator
    {
        /** @var Builder $build */
        $query = $this->getModelClone()->newQuery();

        $this->search($queryData, $query)
            ->sort($queryData, $query)
            ->filters($queryData, $query);

        $query->with([
            'avatar',
            'role:id,value,is_active',
        ]);

        return $query->paginate($queryData->per_page);
    }

    public function findByUUID(ManagerUUID $uuid): ?Manager
    {
        /** @var AdminModel $fManager */
        $fManager = $this->getModelClone()->newQuery()->with(['avatar', 'role:id,value,is_active'])->find($uuid->value);

        if ($fManager === null) {
            return null;
        }

        $manager = Manager::fromPrimitives($fManager->uuid, $fManager->first_name, $fManager->last_name, $fManager->email);
        $manager->setRoleId($fManager->role_id);

        if ($fManager->avatar !== null) {
            /** @var App\Models\File $avatar */
            $avatar = $fManager->avatar;
            $manager->setAvatar(
                new Avatar($avatar->uuid, $avatar->width, $avatar->height, $avatar->mime_type, $avatar->size, $avatar->file_original_name, $avatar->url_pattern)
            );
        }

        return $manager;
    }

    public function save(Manager $manager): bool
    {
        $password = $manager->getPassword() === null ? [] : ['password' => $manager->getPassword()->value];

        /** @var AdminModel $createdProduct */
        $manager = $this->getModelClone()->newQuery()->updateOrCreate(
            [
                'uuid' => $manager->uuid->value,
            ],
            array_merge(
                [
                    'first_name' => $manager->firstName->value,
                    'last_name' => $manager->lastName->value,
                    'email' => $manager->email->value,
                    'role_id' => $manager->getRoleId(),
                ],
                $password,
            )
        );

        return (bool) $manager;
    }

    public function delete(ManagerUUID $uuid): void
    {
        $this->getModelClone()->newQuery()->findOrFail($uuid->value)?->delete();
    }
}
