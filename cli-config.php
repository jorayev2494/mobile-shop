<?php

require_once __DIR__ . '/public/index.php';

use App\Repositories\Base\Doctrine\Contracts\AdminEntityManagerInterface;
use App\Repositories\Base\Doctrine\Contracts\ClientEntityManagerInterface;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ConfigurationArray;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\EntityManagerInterface;

$dbalKey = null;
$migrationsPaths = [];

if (getenv('ENTITY') === 'client')
{
    /** @var EntityManagerInterface $entityManager */
    $entityManager = $app->make(ClientEntityManagerInterface::class);
    $migrationsPaths = $app->make('client_doctrine_migration_paths');
    $dbalKey = 'client_dbal_connection';
}
else
{
    /** @var EntityManagerInterface $entityManager */
    $entityManager = $app->make(AdminEntityManagerInterface::class);
    $migrationsPaths = $app->make('admin_doctrine_migration_paths');
    $dbalKey = 'admin_dbal_connection';
}

$conf = [
    'table_storage' => [
        'table_name' => 'doctrine_migration_versions',
        'version_column_name' => 'version',
        'version_column_length' => 191,
        'executed_at_column_name' => 'executed_at',
        'execution_time_column_name' => 'execution_time',
    ],

    // 'migrations_paths' => [
    //     // 'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => '/var/project/src/Domains/Admin/Country/Infrastructure/Doctrine/Migrations',
    // ],

    'migrations_paths' => [...$migrationsPaths],

    'all_or_nothing' => true,
    'transactional' => true,
    'check_database_platform' => true,
    'organize_migrations' => 'none',
    'connection' => null,
    'em' => null,
];

$config = new ConfigurationArray($conf);
$dbalConnection = $app->make($dbalKey);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
