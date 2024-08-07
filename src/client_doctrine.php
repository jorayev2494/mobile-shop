<?php

// require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../public/index.php';

use App\Repositories\Base\Doctrine\Contracts\ClientEntityManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

/** @var EntityManagerInterface $entityManager */
$entityManager = $app->make(ClientEntityManagerInterface::class);

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);
