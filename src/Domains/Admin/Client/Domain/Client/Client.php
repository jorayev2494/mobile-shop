<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Client\Domain\Client;

use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientCountryUuid;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientEmail;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientFirstName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientLastName;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientPhone;
use Project\Domains\Admin\Client\Domain\Client\ValueObjects\ClientUuid;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\CountryUuidType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\EmailType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\FirstNameType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\LastNameType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\PhoneType;
use Project\Domains\Admin\Client\Infrastructure\Doctrine\Client\Types\UuidType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'client_clients')]
#[HasLifecycleCallbacks]
class Client extends AggregateRoot
{
  #[ORM\Id]
  #[ORM\Column(name: 'uuid', type: UuidType::NAME)]
  private ClientUuid $uuid;

  #[ORM\Column(name: 'first_name', type: FirstNameType::NAME, nullable: true)]
  private ClientFirstName $firstName;

  #[ORM\Column(name: 'last_name', type: LastNameType::NAME, nullable: true)]
  private ClientLastName $lastName;

  #[ORM\Column(type: EmailType::NAME, unique: true, nullable: false)]
  private ClientEmail $email;

  #[ORM\Column(type: PhoneType::NAME, nullable: true)]
  private ClientPhone $phone;

  #[ORM\Column(name: 'country_uuid', type: CountryUuidType::NAME, nullable: true)]
  private ?ClientCountryUuid $countryUuid;

  #[ORM\Column(name: 'email_verified_at', type: Types::DATETIME_IMMUTABLE, nullable: true)]
  private ?DateTimeImmutable $emailVerifiedAt;

  #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
  private DateTimeImmutable $createdAt;

  #[ORM\Column(name: 'updated_at', type: Types::DATETIME_IMMUTABLE)]
  private DateTimeImmutable $updatedAt;

  private function __construct(
    ClientUuid $uuid,
    ClientFirstName $firstName,
    ClientLastName $lastName,
    ClientEmail $email,
    ClientPhone $phone = null,
    ClientCountryUuid $countryUuid = null,
    DateTimeImmutable $emailVerifiedAt = null,
  )
  {
    $this->uuid = $uuid;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->email = $email;
    $this->phone = $phone;
    $this->countryUuid = $countryUuid;
    $this->emailVerifiedAt = $emailVerifiedAt;
  }

  public static function create(
    ClientUuid $uuid,
    ClientFirstName $firstName,
    ClientLastName $lastName,
    ClientEmail $email,
    ClientPhone $phone = null,
    ClientCountryUuid $countryUuid = null,
    DateTimeImmutable $emailVerifiedAt = null,
  ): self
  {
    $client = new self($uuid, $firstName, $lastName, $email, $phone, $countryUuid, $emailVerifiedAt);

    return $client;
  }

	public function getUuid(): ClientUuid
  {
		return $this->uuid;
	}
	
	public function setUuid(ClientUuid $uuid): self
  {
		$this->uuid = $uuid;

		return $this;
	}

	public function getFirstName(): ClientFirstName
  {
		return $this->firstName;
	}
	
	public function setFirstName(ClientFirstName $firstName): self
  {
		$this->firstName = $firstName;

		return $this;
	}

	public function getLastName(): ClientLastName
  {
		return $this->lastName;
	}
	
	public function setLastName(ClientLastName $lastName): self
  {
		$this->lastName = $lastName;

		return $this;
	}

	public function getEmail(): ClientEmail
  {
		return $this->email;
	}
	
	public function setEmail(ClientEmail $email): self
  {
		$this->email = $email;

		return $this;
	}

	public function getPhone(): ClientPhone
  {
		return $this->phone;
	}
	
	public function setPhone(ClientPhone $phone): self
  {
		$this->phone = $phone;

		return $this;
	}

	public function getCountryUuid(): ClientCountryUuid
  {
		return $this->countryUuid;
	}
	
	public function setCountryUuid(ClientCountryUuid $countryUuid): self
  {
		$this->countryUuid = $countryUuid;

		return $this;
	}

	public function getEmailVerifiedAt(): DateTimeImmutable
  {
		return $this->emailVerifiedAt;
	}
	
	public function setEmailVerifiedAt(DateTimeImmutable $emailVerifiedAt): self
  {
		$this->emailVerifiedAt = $emailVerifiedAt;

		return $this;
	}

	public function getCreatedAt(): DateTimeImmutable
  {
		return $this->createdAt;
	}
	
	public function setCreatedAt(DateTimeImmutable $createdAt): self
  {
		$this->createdAt = $createdAt;

		return $this;
	}

	public function getUpdatedAt(): DateTimeImmutable
  {
		return $this->updatedAt;
	}
	
	public function setUpdatedAt(DateTimeImmutable $updatedAt): self
  {
		$this->updatedAt = $updatedAt;

		return $this;
	}

  #[PrePersist]
  public function prePersisting(PrePersistEventArgs $event): void
  {
    $this->createdAt = new DateTimeImmutable;
    $this->updatedAt = new DateTimeImmutable;
  }

  #[PreUpdate]
  public function preUpdating(PreUpdateEventArgs $event): void
  {
    $this->updatedAt = new DateTimeImmutable;
  }

  public function toArray(): array
  {
      return [
          'uuid' => $this->uuid->value,
          'fist_name' => $this->firstName->value,
          'last_name' => $this->lastName->value,
          'email' => $this->email->value,
          'phone' => $this->phone->value,
          'country_uuid' => $this->countryUuid->value,
          'email_verified_at' => $this->emailVerifiedAt,
          'created_at' => $this->createdAt->getTimestamp(),
          'updated_at' => $this->updatedAt->getTimestamp(),
      ];
  }
}
