<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231016164828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE category_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE currency_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE currency_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products DROP price_currency_uuid');
        $this->addSql('ALTER TABLE product_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_permissions ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_permissions ALTER subject TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_permissions ALTER action TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_roles ALTER value TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE currency_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE currency_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_roles ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE product_products ADD price_currency_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE category_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE category_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_permissions ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_permissions ALTER subject TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE role_permissions ALTER action TYPE VARCHAR(255)');
    }
}
