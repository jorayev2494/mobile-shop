<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Doctrine\Media;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;

final class MediaRepository extends BaseAdminEntityRepository implements MediaRepositoryInterface
{
    protected function getEntity(): string
    {
        return Media::class;
    }

    /**
     * @param string $productUuid
     * @param array $ids
     * @return iterable<Media>
     */
    public function findProductMediasByIds(string $productUuid, array $ids): iterable
    {
        $query = $this->entityRepository->createQueryBuilder('m')
                                    ->where('m.productUuid = :productUuid')
                                    ->andWhere('m.id IN (:ids)')
                                    ->setParameter('productUuid', $productUuid)
                                    ->setParameter('ids', $ids)
                                    ->getQuery();

        return $query->getResult();
    }

    public function delete(Media $media): void
    {
        $this->entityRepository->getEntityManager()->remove($media);
    }
}
