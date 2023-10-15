<?php

namespace Database\Seeders;

use App\Models\Address;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressCityUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressAuthorUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressCountryUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressDistrict;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFirstAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressFullName;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressSecondAddress;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressTitle;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressUuid;
use Project\Domains\Client\Address\Domain\ValueObjects\AddressZipCode;
use App\Models\Client;
use App\Models\Country;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Project\Domains\Client\Address\Domain\Address as DomainAddress;
use Project\Domains\Client\Address\Domain\AddressRepositoryInterface;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class AddressSeeder extends Seeder
{
    /**
     * @var Collection<int, Client> $clients
     */
    private readonly Collection $clients;

    private readonly Collection $countries;

    public function __construct(
        private readonly AddressRepositoryInterface $repository,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly Generator $fakeGenerator,
        private readonly EventBusInterface $eventBus,
    )
    {
        $this->clients = Client::all();
        $this->countries = Country::all();
    }

    public function run(): void
    {
        foreach ($this->clients as $key => $client) {
            // $client->addresses()->saveMany(
            //     Address::factory()->count(random_int(5, 15))->make([
            //         'country_uuid' => ($county = $this->countries->random()->first())->uuid,
            //         'city_uuid' => $county->cities->random()->first()->uuid // $this->cities->random(),
            //     ])
            // );


            $address = DomainAddress::create(
                AddressUuid::fromValue($this->uuidGenerator->generate()),
                AddressTitle::fromValue($this->fakeGenerator->text(random_int(10, 100))),
                AddressFullName::fromValue($this->fakeGenerator->firstName() . ' ' . $this->fakeGenerator->lastName()),
                AddressAuthorUuid::fromValue($client->uuid),
                AddressFirstAddress::fromValue($this->fakeGenerator->streetAddress()),
                AddressSecondAddress::fromValue($this->fakeGenerator->streetAddress()),
                AddressZipCode::fromValue((int) $this->fakeGenerator->postcode()),
                AddressCountryUuid::fromValue($this->countries->random()->first()->uuid),
                AddressCityUuid::fromValue($this->uuidGenerator->generate()),
                AddressDistrict::fromValue($this->fakeGenerator->streetAddress()),
            );
    
            $this->repository->save($address);
            $this->eventBus->publish(...$address->pullDomainEvents());
        }
    }
}
