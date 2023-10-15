<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Product\Infrastructure\Doctrine\Media;

use App\Repositories\Base\Doctrine\BaseAdminEntityRepository;
use Project\Domains\Admin\Product\Domain\Media\Media;
use Project\Domains\Admin\Product\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Admin\Product\Domain\Product\ValueObjects\ProductUuid;

final class MediaRepository extends BaseAdminEntityRepository implements MediaRepositoryInterface
{
    protected function getEntity(): string
    {
        return Media::class;
    }

    /**
     * @param ProductUuid $productUuid
     * @return iterable<Media>
     */
    public function findManyByProductUuid(ProductUuid $productUuid): iterable
    {
        return $this->entityRepository->findBy(['productUuid' => $productUuid]);
    }

    /**
     * @param string $productUuid
     * @param array $ids
     * @return iterable<Media>
     */
    public function findProductMediasByIds(string $productUuid, array $uuids): iterable
    {
        $query = $this->entityRepository->createQueryBuilder('m')
                                    ->where('m.productUuid = :productUuid')
                                    ->andWhere('m.uuid IN (:uuids)')
                                    ->setParameter('productUuid', $productUuid)
                                    ->setParameter('uuids', $uuids)
                                    ->getQuery();

        return $query->getResult();
    }

    public function delete(Media $media): void
    {
        $this->entityRepository->getEntityManager()->remove($media);
    }
}
