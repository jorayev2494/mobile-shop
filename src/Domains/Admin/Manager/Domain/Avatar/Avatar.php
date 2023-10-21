<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Manager\Domain\Avatar;

use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Manager\Domain\Manager\Manager;
use Project\Shared\Infrastructure\FileDriver\File;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'manager_avatars')]
class Avatar extends File
{
    public const PATH = '/avatar';

    #[ORM\OneToOne(targetEntity: Manager::class, mappedBy: 'avatar')]
    private Manager $author;

    public function setAuthor(Manager $author): void
    {
        $this->author = $author;
    }
}
