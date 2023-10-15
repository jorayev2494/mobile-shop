<?php

namespace Database\Seeders;

use App\Models\Card;
use App\Models\Client;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Project\Domains\Admin\Client\Domain\Client\ClientRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\Card as CardCard;
use Project\Domains\Client\Card\Domain\Card\CardRepositoryInterface;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\AuthorUuid;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\CVV;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\ExpirationDate;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\HolderName;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Number;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Type;
use Project\Domains\Client\Card\Domain\Card\ValueObjects\Uuid;
use Project\Shared\Application\Query\BaseQuery;
use Project\Shared\Domain\Bus\Event\EventBusInterface;
use Project\Shared\Domain\UuidGeneratorInterface;

class CardSeeder extends Seeder
{
    private Collection $clients;
    public function __construct(
        private readonly ClientRepositoryInterface $clientRepository,
        private readonly CardRepositoryInterface $repository,
        private readonly UuidGeneratorInterface $uuidGenerator,
        private readonly EventBusInterface $eventBus,
        private readonly Generator $fakeGenerator,
    )
    {
        $this->clients = Client::all();
    }

    public function run(): void
    {
        $this->clients->each(
            function (Client $client): void {
                
                $card = CardCard::crate(
                    Uuid::fromValue($this->uuidGenerator->generate()),
                    AuthorUuid::fromValue($client->uuid),
                    Type::fromValue($cardType = $this->fakeGenerator->randomElement(['visa', 'mastercard'])),
                    HolderName::fromValue($client->full_name),
                    Number::fromValue($this->fakeGenerator->creditCardNumber($cardType === 'visa' ? 'Visa' : 'MasterCard')),
                    CVV::fromValue(random_int(000, 999)),
                    ExpirationDate::fromValue($this->fakeGenerator->creditCardExpirationDateString()),
                );
        
                $this->repository->save($card);
                $this->eventBus->publish(...$card->pullDomainEvents());
                
            }
        );
    }
}
