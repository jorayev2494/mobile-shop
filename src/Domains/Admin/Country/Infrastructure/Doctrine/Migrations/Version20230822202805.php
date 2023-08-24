<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822202805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE countries ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE countries ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE countries ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE countries ALTER iso TYPE VARCHAR(3)');
    }
}
