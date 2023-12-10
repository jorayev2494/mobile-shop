<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Test\Unit\Application\Profile\GetProfile;

use PHPUnit\Framework\TestCase;
use Project\Domains\Admin\Profile\Application\Queries\GetProfile\Query;
use Project\Domains\Admin\Profile\Application\Queries\GetProfile\QueryHandler;
use Project\Domains\Admin\Profile\Domain\Profile\ProfileRepositoryInterface;
use Project\Domains\Admin\Profile\Test\Unit\Application\ProfileFactory;

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
