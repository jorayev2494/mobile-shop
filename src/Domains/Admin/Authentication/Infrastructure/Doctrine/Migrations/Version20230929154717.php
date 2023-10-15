<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929154717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE auth_codes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_permissions_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_roles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auth_codes (id INT NOT NULL, author_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90381D775834 ON auth_codes (value)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90383590D879 ON auth_codes (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_codes.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_device (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298C116CC74F2195 ON auth_device (refresh_token)');
        $this->addSql('CREATE INDEX IDX_298C116C3590D879 ON auth_device (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_device.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_device.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_members (uuid VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN auth_members.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_members.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE category_categories (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN category_categories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN category_categories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE client_clients (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, country_uuid VARCHAR(255) DEFAULT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_52F56A09E7927C74 ON client_clients (email)');
        $this->addSql('COMMENT ON COLUMN client_clients.email_verified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN client_clients.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN client_clients.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE country_countries (uuid VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, value VARCHAR(255) NOT NULL, iso VARCHAR(3) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN country_countries.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN country_countries.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE currency_currencies (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN currency_currencies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN currency_currencies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE manager_managers (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, role_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN manager_managers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN manager_managers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE product_medias (uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_70AEEE255C977207 ON product_medias (product_uuid)');
        $this->addSql('COMMENT ON COLUMN product_medias.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN product_medias.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE product_products (uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, category_uuid VARCHAR(255) NOT NULL, viewed_count INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_value NUMERIC(7, 2) NOT NULL, price_discount_percentage INT DEFAULT NULL, price_currency_uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN product_products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN product_products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE profile_avatars (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN profile_avatars.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN profile_avatars.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE profile_profiles (uuid VARCHAR(255) NOT NULL, avatar_uuid VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725AE481E7927C74 ON profile_profiles (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725AE48143DB3B7D ON profile_profiles (avatar_uuid)');
        $this->addSql('CREATE TABLE role_permissions (id INT NOT NULL, value VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE role_roles (id INT NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_41E2C6E81D775834 ON role_roles (value)');
        $this->addSql('COMMENT ON COLUMN role_roles.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN role_roles.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE role_roles_permissions (role_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(role_id, permission_id))');
        $this->addSql('CREATE INDEX IDX_8E2B27BCD60322AC ON role_roles_permissions (role_id)');
        $this->addSql('CREATE INDEX IDX_8E2B27BCFED90CCA ON role_roles_permissions (permission_id)');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_device ADD CONSTRAINT FK_298C116C3590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE product_medias ADD CONSTRAINT FK_70AEEE255C977207 FOREIGN KEY (product_uuid) REFERENCES product_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_profiles ADD CONSTRAINT FK_725AE48143DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES profile_avatars (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_roles_permissions ADD CONSTRAINT FK_8E2B27BCD60322AC FOREIGN KEY (role_id) REFERENCES role_roles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE role_roles_permissions ADD CONSTRAINT FK_8E2B27BCFED90CCA FOREIGN KEY (permission_id) REFERENCES role_permissions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE auth_codes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_permissions_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_roles_id_seq CASCADE');
        $this->addSql('ALTER TABLE auth_codes DROP CONSTRAINT FK_298F90383590D879');
        $this->addSql('ALTER TABLE auth_device DROP CONSTRAINT FK_298C116C3590D879');
        $this->addSql('ALTER TABLE product_medias DROP CONSTRAINT FK_70AEEE255C977207');
        $this->addSql('ALTER TABLE profile_profiles DROP CONSTRAINT FK_725AE48143DB3B7D');
        $this->addSql('ALTER TABLE role_roles_permissions DROP CONSTRAINT FK_8E2B27BCD60322AC');
        $this->addSql('ALTER TABLE role_roles_permissions DROP CONSTRAINT FK_8E2B27BCFED90CCA');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_device');
        $this->addSql('DROP TABLE auth_members');
        $this->addSql('DROP TABLE category_categories');
        $this->addSql('DROP TABLE client_clients');
        $this->addSql('DROP TABLE country_countries');
        $this->addSql('DROP TABLE currency_currencies');
        $this->addSql('DROP TABLE manager_managers');
        $this->addSql('DROP TABLE product_medias');
        $this->addSql('DROP TABLE product_products');
        $this->addSql('DROP TABLE profile_avatars');
        $this->addSql('DROP TABLE profile_profiles');
        $this->addSql('DROP TABLE role_permissions');
        $this->addSql('DROP TABLE role_roles');
        $this->addSql('DROP TABLE role_roles_permissions');
    }
}
