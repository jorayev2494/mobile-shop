<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230909225624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address_addresses (uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, first_address VARCHAR(255) NOT NULL, second_address VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, country_uuid VARCHAR(255) NOT NULL, city_uuid VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE auth_codes (id INT NOT NULL, author_uuid VARCHAR(255) DEFAULT NULL, member_uuid VARCHAR(255) NOT NULL, value INT NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90381D775834 ON auth_codes (value)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F9038C74F2195 ON auth_codes (refresh_token)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90383590D879 ON auth_codes (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_codes.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_device (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298C116CC74F2195 ON auth_device (refresh_token)');
        $this->addSql('CREATE INDEX IDX_298C116C3590D879 ON auth_device (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_device.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_device.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_members (uuid VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B84F20CE7927C74 ON auth_members (email)');
        $this->addSql('CREATE TABLE profile_devices (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, device_name VARCHAR(255) DEFAULT NULL, user_agent VARCHAR(255) DEFAULT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_C2B990063590D879 ON profile_devices (author_uuid)');
        $this->addSql('CREATE TABLE profile_profiles (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725AE481E7927C74 ON profile_profiles (email)');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_device ADD CONSTRAINT FK_298C116C3590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_devices ADD CONSTRAINT FK_C2B990063590D879 FOREIGN KEY (author_uuid) REFERENCES profile_profiles (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE auth_codes DROP CONSTRAINT FK_298F90383590D879');
        $this->addSql('ALTER TABLE auth_device DROP CONSTRAINT FK_298C116C3590D879');
        $this->addSql('ALTER TABLE profile_devices DROP CONSTRAINT FK_C2B990063590D879');
        $this->addSql('DROP TABLE address_addresses');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_device');
        $this->addSql('DROP TABLE auth_members');
        $this->addSql('DROP TABLE profile_devices');
        $this->addSql('DROP TABLE profile_profiles');
    }
}
