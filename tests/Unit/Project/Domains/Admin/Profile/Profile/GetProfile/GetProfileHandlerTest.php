<?php

declare(strict_types=1);

namespace Tests\Unit\Project\Domains\Admin\Profile\Profile\GetProfile;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Profile\Application\Queries\GetProfile\Query;
use Project\Domains\Admin\Profile\Application\Queries\GetProfile\QueryHandler;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Tests\Unit\Project\Domains\Admin\Profile\Profile\ProfileFactory;

class GetProfileHandlerTest extends TestCase
{
    public function testGetProfile(): void
    {
        $handler = new QueryHandler(
            $profileRepository = $this->createMock(ProfileRepositoryInterface::class),
        );

        $profileRepository->expects($this->once())
                        ->method('findByUuid')
                        ->willReturn(ProfileFactory::make());

        $handler(new Query(ProfileFactory::UUID));
    }
}
