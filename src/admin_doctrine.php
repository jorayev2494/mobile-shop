<?php

declare(strict_types=1);

// require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../public/index.php';

use App\Repositories\Base\Doctrine\Contracts\AdminEntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

/** @var EntityManagerInterface $entityManager */
$entityManager = $app->make(AdminEntityManagerInterface::class);

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
