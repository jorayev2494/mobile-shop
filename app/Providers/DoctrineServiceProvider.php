<?php

namespace App\Providers;

use App\Repositories\Base\Doctrine\Contracts\AdminEntityManagerInterface;
use App\Repositories\Base\Doctrine\Contracts\ClientEntityManagerInterface;
use App\Repositories\Base\Doctrine\ProjectVersionComparator;
use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Version\Comparator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Illuminate\Support\ServiceProvider;

class DoctrineServiceProvider extends ServiceProvider
{
    private array $adminConnection = [
        'dbname' => 'admindatabase',
        'user' => 'shopuser',
        'password' => 'shoppassword',
        'host' => 'postgres',
        'driver' => 'pdo_pgsql',
    ];

    private array $clientConnection = [
        'dbname' => 'clientdatabase',
        'user' => 'shopuser',
        'password' => 'shoppassword',
        'host' => 'postgres',
        'driver' => 'pdo_pgsql',
    ];

    // protected $defer = true;

    public function register(): void
    {
        $this->connectAdminEntityManager();
        $this->connectClientEntityManager();
    }

    public function boot(): void
    {
        $this->app->singleton(Comparator::class, ProjectVersionComparator::class);
    }

    private function connectAdminEntityManager()
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('admin_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->adminConnection, $config);
        $entityManager = new \App\Repositories\Base\Doctrine\EntityManager($connection, $config);

        $this->app->instance(AdminEntityManagerInterface::class, $entityManager);
        $this->app->instance('admin_dbal_connection', $connection);
    }

    private function connectClientEntityManager()
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('client_doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->clientConnection, $config);
        $entityManager = new \App\Repositories\Base\Doctrine\EntityManager($connection, $config);

        $this->app->instance(ClientEntityManagerInterface::class, $entityManager);
        $this->app->instance('client_dbal_connection', $connection);
    }
}
