<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231001161237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE auth_codes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cart_carts_products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE order_orders_products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
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
        $this->addSql('CREATE TABLE card_cards (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, holder_name VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, cvv VARCHAR(255) NOT NULL, expiration_date VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE cart_carts (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, order_confirm_card_uuid VARCHAR(255) DEFAULT NULL, order_confirm_address_uuid VARCHAR(255) DEFAULT NULL, order_confirm_currency_uuid VARCHAR(255) DEFAULT NULL, order_confirm_email VARCHAR(255) DEFAULT NULL, order_confirm_phone VARCHAR(255) DEFAULT NULL, order_confirm_promo_code INT DEFAULT NULL, order_confirm_note TEXT DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE cart_carts_products (id INT NOT NULL, cart_uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B8DB8FF23E9A509F ON cart_carts_products (cart_uuid)');
        $this->addSql('CREATE INDEX IDX_B8DB8FF25C977207 ON cart_carts_products (product_uuid)');
        $this->addSql('CREATE TABLE cart_categories (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN cart_categories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cart_categories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE cart_product_medias (uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_DA90BA2C5C977207 ON cart_product_medias (product_uuid)');
        $this->addSql('COMMENT ON COLUMN cart_product_medias.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cart_product_medias.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE cart_products (uuid VARCHAR(255) NOT NULL, category_uuid VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, viewed_count INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_value NUMERIC(7, 2) NOT NULL, price_discount_percentage INT DEFAULT NULL, price_currency_uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_2D2515315AE42AE1 ON cart_products (category_uuid)');
        $this->addSql('COMMENT ON COLUMN cart_products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN cart_products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE favorite_medias (uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_2E67C37B5C977207 ON favorite_medias (product_uuid)');
        $this->addSql('COMMENT ON COLUMN favorite_medias.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN favorite_medias.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE favorite_member (uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE favorite_members_products (member_uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, PRIMARY KEY(member_uuid, product_uuid))');
        $this->addSql('CREATE INDEX IDX_C4DF53A42DF77CFA ON favorite_members_products (member_uuid)');
        $this->addSql('CREATE INDEX IDX_C4DF53A45C977207 ON favorite_members_products (product_uuid)');
        $this->addSql('CREATE TABLE favorite_products (uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, category_uuid VARCHAR(255) NOT NULL, viewed_count INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_value NUMERIC(7, 2) NOT NULL, price_discount_percentage INT DEFAULT NULL, price_currency_uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN favorite_products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN favorite_products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE order_addresses (uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, first_address VARCHAR(255) NOT NULL, second_address VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, country_uuid VARCHAR(255) NOT NULL, city_uuid VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE order_cards (uuid VARCHAR(255) NOT NULL, client_uuid VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, holderName VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, cvv VARCHAR(255) NOT NULL, expirationDate VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_875C2C00E393C4 ON order_cards (client_uuid)');
        $this->addSql('CREATE TABLE order_categories (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN order_categories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN order_categories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE order_clients (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE order_currency_currencies (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN order_currency_currencies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN order_currency_currencies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE order_orders (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, card_uuid VARCHAR(255) DEFAULT NULL, address_uuid VARCHAR(255) DEFAULT NULL, currency_uuid VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, meta_quantity INT NOT NULL, meta_sum NUMERIC(7, 2) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_26A0ED3B3590D879 ON order_orders (author_uuid)');
        $this->addSql('CREATE INDEX IDX_26A0ED3B3D4C5204 ON order_orders (card_uuid)');
        $this->addSql('CREATE INDEX IDX_26A0ED3BAC33804D ON order_orders (address_uuid)');
        $this->addSql('CREATE INDEX IDX_26A0ED3B5BC813D2 ON order_orders (currency_uuid)');
        $this->addSql('CREATE TABLE order_orders_products (id INT NOT NULL, order_uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF9544C09C8E6AB1 ON order_orders_products (order_uuid)');
        $this->addSql('CREATE INDEX IDX_BF9544C05C977207 ON order_orders_products (product_uuid)');
        $this->addSql('CREATE TABLE order_product_medias (uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_18DE3E955C977207 ON order_product_medias (product_uuid)');
        $this->addSql('COMMENT ON COLUMN order_product_medias.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN order_product_medias.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE order_products (uuid VARCHAR(255) NOT NULL, category_uuid VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, viewed_count INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_value NUMERIC(7, 2) NOT NULL, price_discount_percentage INT DEFAULT NULL, price_currency_uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_5242B8EB5AE42AE1 ON order_products (category_uuid)');
        $this->addSql('COMMENT ON COLUMN order_products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN order_products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE profile_devices (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, device_name VARCHAR(255) DEFAULT NULL, user_agent VARCHAR(255) DEFAULT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_C2B990063590D879 ON profile_devices (author_uuid)');
        $this->addSql('CREATE TABLE profile_profiles (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725AE481E7927C74 ON profile_profiles (email)');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_device ADD CONSTRAINT FK_298C116C3590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_carts_products ADD CONSTRAINT FK_B8DB8FF23E9A509F FOREIGN KEY (cart_uuid) REFERENCES cart_carts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_carts_products ADD CONSTRAINT FK_B8DB8FF25C977207 FOREIGN KEY (product_uuid) REFERENCES cart_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_product_medias ADD CONSTRAINT FK_DA90BA2C5C977207 FOREIGN KEY (product_uuid) REFERENCES cart_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_products ADD CONSTRAINT FK_2D2515315AE42AE1 FOREIGN KEY (category_uuid) REFERENCES cart_categories (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_medias ADD CONSTRAINT FK_2E67C37B5C977207 FOREIGN KEY (product_uuid) REFERENCES favorite_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_members_products ADD CONSTRAINT FK_C4DF53A42DF77CFA FOREIGN KEY (member_uuid) REFERENCES favorite_member (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favorite_members_products ADD CONSTRAINT FK_C4DF53A45C977207 FOREIGN KEY (product_uuid) REFERENCES favorite_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_cards ADD CONSTRAINT FK_875C2C00E393C4 FOREIGN KEY (client_uuid) REFERENCES order_clients (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_orders ADD CONSTRAINT FK_26A0ED3B3590D879 FOREIGN KEY (author_uuid) REFERENCES order_clients (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_orders ADD CONSTRAINT FK_26A0ED3B3D4C5204 FOREIGN KEY (card_uuid) REFERENCES order_cards (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_orders ADD CONSTRAINT FK_26A0ED3BAC33804D FOREIGN KEY (address_uuid) REFERENCES order_addresses (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_orders ADD CONSTRAINT FK_26A0ED3B5BC813D2 FOREIGN KEY (currency_uuid) REFERENCES order_currency_currencies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_orders_products ADD CONSTRAINT FK_BF9544C09C8E6AB1 FOREIGN KEY (order_uuid) REFERENCES order_orders (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_orders_products ADD CONSTRAINT FK_BF9544C05C977207 FOREIGN KEY (product_uuid) REFERENCES order_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_product_medias ADD CONSTRAINT FK_18DE3E955C977207 FOREIGN KEY (product_uuid) REFERENCES order_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_products ADD CONSTRAINT FK_5242B8EB5AE42AE1 FOREIGN KEY (category_uuid) REFERENCES order_categories (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_devices ADD CONSTRAINT FK_C2B990063590D879 FOREIGN KEY (author_uuid) REFERENCES profile_profiles (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE auth_codes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cart_carts_products_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE order_orders_products_id_seq CASCADE');
        $this->addSql('ALTER TABLE auth_codes DROP CONSTRAINT FK_298F90383590D879');
        $this->addSql('ALTER TABLE auth_device DROP CONSTRAINT FK_298C116C3590D879');
        $this->addSql('ALTER TABLE cart_carts_products DROP CONSTRAINT FK_B8DB8FF23E9A509F');
        $this->addSql('ALTER TABLE cart_carts_products DROP CONSTRAINT FK_B8DB8FF25C977207');
        $this->addSql('ALTER TABLE cart_product_medias DROP CONSTRAINT FK_DA90BA2C5C977207');
        $this->addSql('ALTER TABLE cart_products DROP CONSTRAINT FK_2D2515315AE42AE1');
        $this->addSql('ALTER TABLE favorite_medias DROP CONSTRAINT FK_2E67C37B5C977207');
        $this->addSql('ALTER TABLE favorite_members_products DROP CONSTRAINT FK_C4DF53A42DF77CFA');
        $this->addSql('ALTER TABLE favorite_members_products DROP CONSTRAINT FK_C4DF53A45C977207');
        $this->addSql('ALTER TABLE order_cards DROP CONSTRAINT FK_875C2C00E393C4');
        $this->addSql('ALTER TABLE order_orders DROP CONSTRAINT FK_26A0ED3B3590D879');
        $this->addSql('ALTER TABLE order_orders DROP CONSTRAINT FK_26A0ED3B3D4C5204');
        $this->addSql('ALTER TABLE order_orders DROP CONSTRAINT FK_26A0ED3BAC33804D');
        $this->addSql('ALTER TABLE order_orders DROP CONSTRAINT FK_26A0ED3B5BC813D2');
        $this->addSql('ALTER TABLE order_orders_products DROP CONSTRAINT FK_BF9544C09C8E6AB1');
        $this->addSql('ALTER TABLE order_orders_products DROP CONSTRAINT FK_BF9544C05C977207');
        $this->addSql('ALTER TABLE order_product_medias DROP CONSTRAINT FK_18DE3E955C977207');
        $this->addSql('ALTER TABLE order_products DROP CONSTRAINT FK_5242B8EB5AE42AE1');
        $this->addSql('ALTER TABLE profile_devices DROP CONSTRAINT FK_C2B990063590D879');
        $this->addSql('DROP TABLE address_addresses');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_device');
        $this->addSql('DROP TABLE auth_members');
        $this->addSql('DROP TABLE card_cards');
        $this->addSql('DROP TABLE cart_carts');
        $this->addSql('DROP TABLE cart_carts_products');
        $this->addSql('DROP TABLE cart_categories');
        $this->addSql('DROP TABLE cart_product_medias');
        $this->addSql('DROP TABLE cart_products');
        $this->addSql('DROP TABLE favorite_medias');
        $this->addSql('DROP TABLE favorite_member');
        $this->addSql('DROP TABLE favorite_members_products');
        $this->addSql('DROP TABLE favorite_products');
        $this->addSql('DROP TABLE order_addresses');
        $this->addSql('DROP TABLE order_cards');
        $this->addSql('DROP TABLE order_categories');
        $this->addSql('DROP TABLE order_clients');
        $this->addSql('DROP TABLE order_currency_currencies');
        $this->addSql('DROP TABLE order_orders');
        $this->addSql('DROP TABLE order_orders_products');
        $this->addSql('DROP TABLE order_product_medias');
        $this->addSql('DROP TABLE order_products');
        $this->addSql('DROP TABLE profile_devices');
        $this->addSql('DROP TABLE profile_profiles');
    }
}
