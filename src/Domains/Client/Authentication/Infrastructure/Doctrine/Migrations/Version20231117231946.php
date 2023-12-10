<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231117231946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE delivery_orders_products_id_seq CASCADE');
        $this->addSql('CREATE TABLE profile_avatars (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN profile_avatars.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN profile_avatars.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE delivery_product_medias DROP CONSTRAINT fk_d0a3fe1a5c977207');
        $this->addSql('ALTER TABLE delivery_products DROP CONSTRAINT fk_d2dbbb365ae42ae1');
        $this->addSql('ALTER TABLE delivery_orders_products DROP CONSTRAINT fk_c25aa7b19c8e6ab1');
        $this->addSql('ALTER TABLE delivery_orders_products DROP CONSTRAINT fk_c25aa7b15c977207');
        $this->addSql('ALTER TABLE delivery_orders DROP CONSTRAINT fk_fb3e04603590d879');
        $this->addSql('ALTER TABLE delivery_orders DROP CONSTRAINT fk_fb3e04603d4c5204');
        $this->addSql('ALTER TABLE delivery_orders DROP CONSTRAINT fk_fb3e0460ac33804d');
        $this->addSql('ALTER TABLE delivery_orders DROP CONSTRAINT fk_fb3e04605bc813d2');
        $this->addSql('ALTER TABLE delivery_cards DROP CONSTRAINT fk_14c9be6fe393c4');
        $this->addSql('DROP TABLE delivery_product_medias');
        $this->addSql('DROP TABLE card_cards');
        $this->addSql('DROP TABLE delivery_products');
        $this->addSql('DROP TABLE delivery_orders_products');
        $this->addSql('DROP TABLE delivery_currencies');
        $this->addSql('DROP TABLE delivery_categories');
        $this->addSql('DROP TABLE delivery_addresses');
        $this->addSql('DROP TABLE delivery_orders');
        $this->addSql('DROP TABLE address_addresses');
        $this->addSql('DROP TABLE delivery_cards');
        $this->addSql('DROP TABLE delivery_customers');
        $this->addSql('ALTER TABLE cart_carts ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER cart_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER quantity TYPE INT');
        $this->addSql('ALTER TABLE cart_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_member ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_members_products ALTER member_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_members_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER first_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER second_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER zip_code TYPE INT');
        $this->addSql('ALTER TABLE order_addresses ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER city_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER district TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER client_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER client_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE order_cards ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER holder_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER cvv TYPE INT');
        $this->addSql('ALTER TABLE order_cards ALTER expiration_date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER card_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER address_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER currency_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER order_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER quantity TYPE INT');
        $this->addSql('ALTER TABLE order_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ADD avatar_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ADD CONSTRAINT FK_725AE48143DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES profile_avatars (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725AE48143DB3B7D ON profile_profiles (avatar_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE profile_profiles DROP CONSTRAINT FK_725AE48143DB3B7D');
        $this->addSql('CREATE SEQUENCE delivery_orders_products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE delivery_product_medias (uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX idx_d0a3fe1a5c977207 ON delivery_product_medias (product_uuid)');
        $this->addSql('COMMENT ON COLUMN delivery_product_medias.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN delivery_product_medias.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE card_cards (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, holder_name VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, cvv INT NOT NULL, expiration_date VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE delivery_products (uuid VARCHAR(255) NOT NULL, category_uuid VARCHAR(255) DEFAULT NULL, title VARCHAR(255) NOT NULL, viewed_count INT NOT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price_value NUMERIC(7, 2) NOT NULL, price_discount_percentage INT DEFAULT NULL, price_currency_uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX idx_d2dbbb365ae42ae1 ON delivery_products (category_uuid)');
        $this->addSql('COMMENT ON COLUMN delivery_products.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN delivery_products.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE delivery_orders_products (id INT NOT NULL, order_uuid VARCHAR(255) NOT NULL, product_uuid VARCHAR(255) NOT NULL, quantity INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_c25aa7b15c977207 ON delivery_orders_products (product_uuid)');
        $this->addSql('CREATE INDEX idx_c25aa7b19c8e6ab1 ON delivery_orders_products (order_uuid)');
        $this->addSql('CREATE TABLE delivery_currencies (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN delivery_currencies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN delivery_currencies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE delivery_categories (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN delivery_categories.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN delivery_categories.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE delivery_addresses (uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, first_address VARCHAR(255) NOT NULL, second_address VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, country_uuid VARCHAR(255) NOT NULL, city_uuid VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE delivery_orders (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, card_uuid VARCHAR(255) DEFAULT NULL, address_uuid VARCHAR(255) DEFAULT NULL, currency_uuid VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, meta_quantity INT NOT NULL, meta_sum NUMERIC(7, 2) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX idx_fb3e04605bc813d2 ON delivery_orders (currency_uuid)');
        $this->addSql('CREATE INDEX idx_fb3e0460ac33804d ON delivery_orders (address_uuid)');
        $this->addSql('CREATE INDEX idx_fb3e04603d4c5204 ON delivery_orders (card_uuid)');
        $this->addSql('CREATE INDEX idx_fb3e04603590d879 ON delivery_orders (author_uuid)');
        $this->addSql('COMMENT ON COLUMN delivery_orders.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN delivery_orders.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE address_addresses (uuid VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, first_address VARCHAR(255) NOT NULL, second_address VARCHAR(255) DEFAULT NULL, zip_code INT DEFAULT NULL, country_uuid VARCHAR(255) NOT NULL, city_uuid VARCHAR(255) NOT NULL, district VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE delivery_cards (uuid VARCHAR(255) NOT NULL, client_uuid VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, holdername VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, cvv INT NOT NULL, expirationdate VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX idx_14c9be6fe393c4 ON delivery_cards (client_uuid)');
        $this->addSql('CREATE TABLE delivery_customers (uuid VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('ALTER TABLE delivery_product_medias ADD CONSTRAINT fk_d0a3fe1a5c977207 FOREIGN KEY (product_uuid) REFERENCES delivery_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_products ADD CONSTRAINT fk_d2dbbb365ae42ae1 FOREIGN KEY (category_uuid) REFERENCES delivery_categories (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_orders_products ADD CONSTRAINT fk_c25aa7b19c8e6ab1 FOREIGN KEY (order_uuid) REFERENCES delivery_orders (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_orders_products ADD CONSTRAINT fk_c25aa7b15c977207 FOREIGN KEY (product_uuid) REFERENCES delivery_products (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_orders ADD CONSTRAINT fk_fb3e04603590d879 FOREIGN KEY (author_uuid) REFERENCES delivery_customers (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_orders ADD CONSTRAINT fk_fb3e04603d4c5204 FOREIGN KEY (card_uuid) REFERENCES delivery_cards (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_orders ADD CONSTRAINT fk_fb3e0460ac33804d FOREIGN KEY (address_uuid) REFERENCES delivery_addresses (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_orders ADD CONSTRAINT fk_fb3e04605bc813d2 FOREIGN KEY (currency_uuid) REFERENCES delivery_currencies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE delivery_cards ADD CONSTRAINT fk_14c9be6fe393c4 FOREIGN KEY (client_uuid) REFERENCES delivery_customers (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE profile_avatars');
        $this->addSql('ALTER TABLE order_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER client_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER client_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE order_cards ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER holder_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER cvv TYPE INT');
        $this->addSql('ALTER TABLE order_cards ALTER expiration_date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER cart_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER quantity TYPE INT');
        $this->addSql('DROP INDEX UNIQ_725AE48143DB3B7D');
        $this->addSql('ALTER TABLE profile_profiles DROP avatar_uuid');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER card_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER address_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER currency_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER first_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER second_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER zip_code TYPE INT');
        $this->addSql('ALTER TABLE order_addresses ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER city_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_addresses ALTER district TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_members_products ALTER member_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_members_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER order_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER quantity TYPE INT');
        $this->addSql('ALTER TABLE favorite_member ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_categories ALTER value TYPE VARCHAR(255)');
    }
}
