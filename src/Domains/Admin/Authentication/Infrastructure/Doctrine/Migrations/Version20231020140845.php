<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020140845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manager_avatars (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN manager_avatars.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN manager_avatars.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE auth_permissions ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_permissions ALTER subject TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_permissions ALTER action TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_roles ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE manager_managers ADD avatar_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manager_managers ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ADD CONSTRAINT FK_5D23986243DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES manager_avatars (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D23986243DB3B7D ON manager_managers (avatar_uuid)');
        $this->addSql('ALTER TABLE product_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manager_managers DROP CONSTRAINT FK_5D23986243DB3B7D');
        $this->addSql('DROP TABLE manager_avatars');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE client_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client_clients ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('DROP INDEX UNIQ_5D23986243DB3B7D');
        $this->addSql('ALTER TABLE manager_managers DROP avatar_uuid');
        $this->addSql('ALTER TABLE manager_managers ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE manager_managers ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_permissions ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_permissions ALTER subject TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_permissions ALTER action TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE product_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_roles ALTER value TYPE VARCHAR(255)');
    }
}
