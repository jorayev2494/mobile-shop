<?php

declare(strict_types=1);

namespace Project\Domains\Client\Delivery\Infrastructure;

use App\Providers\ClientDomainServiceProvider;
use Project\Domains\Client\Delivery\Domain\Address\AddressRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Category\CategoryRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Customer\CustomerRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Currency\CurrencyRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Media\MediaRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Order\OrderRepositoryInterface;
use Project\Domains\Client\Delivery\Domain\Product\ProductRepositoryInterface;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\AddressRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\CardRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Category\CategoryRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer\CustomerRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Currency\CurrencyRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Media\MediaRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Product\ProductRepository;
use Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\OrderRepository;

final class DeliveryServiceProvider extends ClientDomainServiceProvider
{
    /** @var array<string, string> */
    protected const SERVICES = [
        AddressRepositoryInterface::class => [self::SERVICE_BIND, AddressRepository::class],
        OrderRepositoryInterface::class => [self::SERVICE_BIND, OrderRepository::class],
        CustomerRepositoryInterface::class => [self::SERVICE_BIND, CustomerRepository::class],
        ProductRepositoryInterface::class => [self::SERVICE_BIND, ProductRepository::class],
        CardRepositoryInterface::class => [self::SERVICE_BIND, CardRepository::class],
        MediaRepositoryInterface::class => [self::SERVICE_BIND, MediaRepository::class],
        CurrencyRepositoryInterface::class => [self::SERVICE_BIND, CurrencyRepository::class],
        CategoryRepositoryInterface::class => [self::SERVICE_BIND, CategoryRepository::class],
    ];

    /** @var array<array-key, string> */
    protected const QUERY_HANDLERS = [
        \Project\Domains\Client\Delivery\Application\Queries\Get\QueryHandler::class,
        \Project\Domains\Client\Delivery\Application\Queries\Show\QueryHandler::class,
    ];

    /** @var array<array-key, string> */
    protected const COMMAND_HANDLERS = [

    ];

    /** @var array<array-key, string> */
    protected const DOMAIN_EVENT_SUBSCRIBERS = [
        \Project\Domains\Client\Delivery\Application\Subscribers\Order\OrderStatusWasChangedDomainEventSubscriber::class,

        \Project\Domains\Client\Delivery\Application\Subscribers\Address\AddressWasDeletedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Address\AddressWasCreatedDomainEventSubscriber::class,

        \Project\Domains\Client\Delivery\Application\Subscribers\Profile\ProfileWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Profile\ProfileFirstNameWasUpdatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Profile\ProfileLastNameWasUpdatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Profile\ProfileEmailWasUpdatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Profile\ProfilePhoneWasUpdatedDomainEventSubscriber::class,

        \Project\Domains\Client\Delivery\Application\Subscribers\Card\CardWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Card\CardWasDeleteDomainEventSubscriber::class,

        \Project\Domains\Client\Delivery\Application\Subscribers\Product\ProductWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Product\ProductWasDeletedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Product\Media\ProductMediaWasAddedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Product\Media\ProductMediaWasDeletedDomainEventSubscriber::class,

        \Project\Domains\Client\Delivery\Application\Subscribers\Currency\CurrencyWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Currency\CurrencyWasDeletedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Currency\CurrencyValueWasChangedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Category\CategoryWasCreatedDomainEventSubscriber::class,
        \Project\Domains\Client\Delivery\Application\Subscribers\Category\CategoryWasDeletedDomainEventSubscriber::class,
    ];

    /** @var array<string, string> */
    protected const ENTITY_TYPES = [
        // Address
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\TitleType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\AuthorUuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\CityUuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\CountryUuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\DistrictType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\FirstAddressType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\SecondAddressType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\FullNameType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Address\Types\ZipCodeType::class,

        // Client
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer\Types\FirstNameType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer\Types\LastNameType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer\Types\EmailType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Customer\Types\PhoneType::class,

        // Order
        // \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\AddressUuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\AuthorUuidType::class,
        // \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\CardUuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\NoteType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\EmailType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\PhoneType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\QuantityType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Order\Types\StatusType::class,

        // OrderProduct
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\OrderProduct\Types\QuantityType::class,

        // Product
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Product\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Product\Types\TitleType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Product\Types\CategoryUuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Product\Types\DescriptionType::class,

        // Card
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\CVVType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\ExpirationDateType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\HolderNameType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\NumberType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Card\Types\TypeType::class,

        // Currency
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Currency\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Currency\Types\ValueType::class,

        // Category
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Category\Types\UuidType::class,
        \Project\Domains\Client\Delivery\Infrastructure\Doctrine\Category\Types\ValueType::class,
    ];

    /** @var array<array-key, string> */
    protected const MIGRATION_PATHS = [
        'Project\Domains\Admin\Country\Infrastructure\Doctrine\Migrations' => __DIR__ . '/Doctrine/Migrations',
    ];

    /** @var array<string, string> */
    protected const ENTITY_PATHS = [
        __DIR__ . '/../Domain/Address',
        __DIR__ . '/../Domain/Customer',
        __DIR__ . '/../Domain/Order',
        __DIR__ . '/../Domain/OrderProduct',
        __DIR__ . '/../Domain/Product',
        __DIR__ . '/../Domain/Media',
        __DIR__ . '/../Domain/Card',
        __DIR__ . '/../Domain/Currency',
        __DIR__ . '/../Domain/Category',
    ];

    public function register(): void
    {
        parent::register();
    }
}
