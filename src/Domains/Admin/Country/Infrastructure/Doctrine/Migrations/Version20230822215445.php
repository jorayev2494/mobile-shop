<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822215445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, country_uuid VARCHAR(255) DEFAULT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74E7927C74 ON clients (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C82E74444F97DD ON clients (phone)');
        $this->addSql('COMMENT ON COLUMN clients.email_verified_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN clients.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN clients.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE countries ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE countries ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE countries ALTER iso TYPE VARCHAR(3)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE clients');
        $this->addSql('ALTER TABLE countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE countries ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE countries ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE countries ALTER iso TYPE VARCHAR(3)');
    }
}
