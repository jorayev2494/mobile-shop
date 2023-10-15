<?php

declare(strict_types=1);

namespace App\Repositories\Base\Doctrine;

use App\Repositories\Base\Doctrine\Contracts\AdminEntityManagerInterface;
use App\Repositories\Base\Doctrine\Contracts\ClientEntityManagerInterface;

class EntityManager extends \Doctrine\ORM\EntityManager implements AdminEntityManagerInterface, ClientEntityManagerInterface
{
}
