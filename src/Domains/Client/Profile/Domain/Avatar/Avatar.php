<?php

declare(strict_types=1);

namespace Project\Domains\Client\Profile\Domain\Avatar;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Client\Profile\Domain\Profile\Profile;
use Project\Infrastructure\Services\Avatar\AvatarInterface;
use Project\Shared\Infrastructure\FileDriver\File;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'profile_avatars')]
class Avatar extends File implements AvatarInterface
{
    public const PATH = '/client/avatar';

    #[ORM\OneToOne(targetEntity: Profile::class, mappedBy: 'avatar')]
    private Profile $profile;

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
}
