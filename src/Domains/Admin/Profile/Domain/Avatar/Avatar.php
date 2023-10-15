<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Domain\Avatar;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Profile\Domain\Profile\Profile;
use Project\Shared\Infrastructure\FileDriver\File;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'profile_avatars')]
class Avatar extends File
{
    public const PATH = '/avatar';

    #[ORM\OneToOne(targetEntity: Profile::class, mappedBy: 'avatar')]
    private Profile $profile;

    public function setProfile(Profile $profile): void
    {
        $this->profile = $profile;
    }
}
