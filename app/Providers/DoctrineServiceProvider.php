<?php

namespace App\Providers;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Illuminate\Support\ServiceProvider;

class DoctrineServiceProvider extends ServiceProvider
{
    private array $connection = [
        'dbname' => 'devdb',
        'user' => 'devuser',
        'password' => 'devsecret',
        'host' => 'postgres',
        'driver' => 'pdo_pgsql',
    ];

    public function register(): void
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: $this->app->make('doctrine_entity_paths')->toArray(),
            isDevMode: !$this->app->environment('production'),
        );

        $connection = DriverManager::getConnection($this->connection, $config);
        $entityManager = new EntityManager($connection, $config);
        $this->app->instance(EntityManagerInterface::class, $entityManager);
    }

    public function boot(): void
    {
        //
    }
}
