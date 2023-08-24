<?php

// require_once __DIR__ . '/../bootstrap/app.php';
require_once __DIR__ . '/../public/index.php';

use App\Repositories\Base\Doctrine\Contracts\ClientEntityManagerInterface;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

/** @var EntityManagerInterface $entityManager */
$entityManager = $app->make(ClientEntityManagerInterface::class);

ConsoleRunner::run(
    new SingleManagerProvider($entityManager)
);

// Doctrine\Migrations\Tools\Console\ConsoleRunner::run([], ConsoleConsoleRunner::findDependencyFactory());

// Migration

// $conf = [
//     'table_storage' => [
//         'table_name' => 'doctrine_migration_versions',
//         'version_column_name' => 'version',
//         'version_column_length' => 191,
//         'executed_at_column_name' => 'executed_at',
//         'execution_time_column_name' => 'execution_time',
//     ],

//     'migrations_paths' => [
//         'Project/Domains/Admin/Country/Infrastructure/Doctrine/Migrations' => '/var/project/src/Domains/Admin/Country/Infrastructure/Doctrine/Migrations',
//     ],

//     'all_or_nothing' => true,
//     'transactional' => true,
//     'check_database_platform' => true,
//     'organize_migrations' => 'none',
//     'connection' => null,
//     'em' => null,
// ];

// $config = new ConfigurationArray($conf);

// $dbalConnection = $app->make('dbal_connection');
// // dd($dbalConnection);
// // $di = DependencyFactory::fromConnection($config, new ExistingConnection($dbalConnection));
// $di = DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
// // dd($di);

// // ConsoleRunner::run(
// //     new SingleManagerProvider($entityManager)
// // );

// return $di;
