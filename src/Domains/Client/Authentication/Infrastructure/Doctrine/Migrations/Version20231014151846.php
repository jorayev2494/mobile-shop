<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231014151846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address_addresses ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER first_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER second_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER zip_code TYPE INT');
        $this->addSql('ALTER TABLE address_addresses ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER city_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER district TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_codes ALTER author_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90383590D879 ON auth_codes (author_uuid)');
        $this->addSql('ALTER TABLE card_cards ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER holder_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER expiration_date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER cvv TYPE INT');
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
        $this->addSql('ALTER TABLE order_cards ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER holdername TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER expirationdate TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER cvv TYPE INT');
        $this->addSql('ALTER TABLE order_cards ALTER cvv SET NOT NULL');
        $this->addSql('ALTER TABLE order_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE order_orders ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE order_orders ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER card_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER address_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER currency_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER status TYPE VARCHAR(255)');
        $this->addSql('COMMENT ON COLUMN order_orders.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN order_orders.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE order_orders_products ALTER order_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER quantity TYPE INT');
        $this->addSql('ALTER TABLE order_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE order_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER first_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER second_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER zip_code TYPE INT');
        $this->addSql('ALTER TABLE address_addresses ALTER country_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER city_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE address_addresses ALTER district TYPE VARCHAR(255)');
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
        $this->addSql('ALTER TABLE card_cards ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER holder_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE card_cards ALTER cvv TYPE INT');
        $this->addSql('ALTER TABLE card_cards ALTER expiration_date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_clients ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER first_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER last_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE profile_profiles ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_categories ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_categories ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders DROP created_at');
        $this->addSql('ALTER TABLE order_orders DROP updated_at');
        $this->addSql('ALTER TABLE order_orders ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER author_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER card_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER address_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER currency_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_member ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_currencies ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER order_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_orders_products ALTER quantity TYPE INT');
        $this->addSql('ALTER TABLE favorite_members_products ALTER member_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE favorite_members_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER category_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER title TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_products ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_codes DROP CONSTRAINT FK_298F90383590D879');
        $this->addSql('DROP INDEX UNIQ_298F90383590D879');
        $this->addSql('ALTER TABLE auth_codes ALTER author_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE cart_carts_products ALTER cart_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER product_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE cart_carts_products ALTER quantity TYPE INT');
        $this->addSql('ALTER TABLE order_cards ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER client_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER type TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER holderName TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE order_cards ALTER cvv TYPE INT');
        $this->addSql('ALTER TABLE order_cards ALTER cvv DROP NOT NULL');
        $this->addSql('ALTER TABLE order_cards ALTER expirationDate TYPE VARCHAR(255)');
    }
}
