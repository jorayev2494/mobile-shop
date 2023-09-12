<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Profile\Domain\Profile;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileAvatar;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileEmail;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileFirstName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfileLastName;
use Project\Domains\Admin\Profile\Domain\Profile\ValueObjects\ProfilePhone;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\AvatarType;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\EmailType;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\FirstNameType;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\LastNameType;
use Project\Domains\Admin\Profile\Infrastructure\Doctrine\Profile\Types\PhoneType;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table('profile_profiles')]
class Profile extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private string $uuid;

    #[ORM\Column(name: 'first_name', type: FirstNameType::NAME, nullable: true)]
    private ?ProfileFirstName $firstName;

    #[ORM\Column(name: 'last_name', type: LastNameType::NAME, nullable: true)]
    private ?ProfileLastName $lastName;

    #[ORM\Column(type: EmailType::NAME, unique: true)]
    private ProfileEmail $email;

    #[ORM\Column(type: AvatarType::NAME, nullable: true)]
    private ?ProfileAvatar $avatar;

    #[ORM\Column(type: PhoneType::NAME, nullable: true)]
    private ?ProfilePhone $phone;

    // #[ORM\OneToMany(targetEntity: Device::class, mappedBy: 'author', orphanRemoval: true, cascade: ['persist', 'remove'])]
    // private Collection $devices;

    private function __construct(
        string $uuid,
        ProfileFirstName $firstName,
        ProfileLastName $lastName,
        ProfileEmail $email,
        ProfilePhone $phone = null,
    )
    {
        $this->uuid = $uuid;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->phone = $phone;
    }

    public static function create(
        string $uuid,
        ProfileFirstName $firstName,
        ProfileLastName $lastName,
        ProfileEmail $email,
        ProfilePhone $phone = null,
    ): self
    {
        return new self($uuid, $firstName, $lastName, $email, $phone);
    }

    public static function fromPrimitives(string $uuid, string $firstName, string $lastName, string $email, ?string $phone = null): self
    {
        return new self(
            $uuid,
            ProfileFirstName::fromValue($firstName),
            ProfileLastName::fromValue($lastName),
            ProfileEmail::fromValue($email),
            ProfilePhone::fromValue($phone),
        );
    }

    // public function addDevice(Device $device): void
    // {
    //     $device->setAuthor($this);
    //     $this->devices->add($device);
    // }

    // public function removeDevice(Device $device): void
    // {
    //     $this->devices->removeElement($device);
    // }

	public function getFirstName(): ?ProfileFirstName
    {
		return $this->firstName;
	}
	
	public function setFirstName(ProfileFirstName $firstName): void
    {
		$this->firstName = $firstName;
	}

	public function getLastName(): ?ProfileLastName
    {
		return $this->lastName;
	}
	
	public function setLastName(ProfileLastName $lastName): void
    {
		$this->lastName = $lastName;
	}

	public function getEmail(): ProfileEmail
    {
		return $this->email;
	}
	
	public function setEmail(ProfileEmail $email): void
    {
		$this->email = $email;
	}

    public function getAvatar(): ?ProfileAvatar
    {
		return $this->avatar;
	}

	public function getPhone(): ?ProfilePhone
    {
		return $this->phone;
	}

    public function changeFirstName(ProfileFirstName $firstName): void
    {
        if ($this->firstName->isNotEquals($firstName)) {
            $this->firstName = $firstName;
            // $this->record(new ProfileFirstNameWasUpdatedDomainEvent($this->uuid, $firstName->value));
        }
    }

    public function changeLastName(ProfileLastName $lastName): void
    {
        if ($this->lastName->isNotEquals($lastName)) {
            $this->lastName = $lastName;
            // $this->record(new ProfileLastNameWasUpdatedDomainEvent($this->uuid, $lastName->value));
        }
    }

    public function changeEmail(ProfileEmail $email): void
    {
        if ($this->email->isNotEquals($email)) {
            $this->email = $email;
            // $this->record(new ProfileEmailWasUpdatedDomainEvent($this->uuid, $email->value));
        }
    }
	
	public function changeAvatar(?ProfileAvatar $avatar): void
    {
        if ($this->avatar->isNotEquals($avatar)) {
            $this->avatar = $avatar;
        }
	}

    public function changePhone(ProfilePhone $phone): void
    {
        if ($this->phone->isNotEquals($phone)) {
            $this->phone = $phone;
            // $this->record(new ProfilePhoneWasUpdatedDomainEvent($this->uuid, $phone->value));
        }
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'first_name' => $this->firstName?->value,
            'last_name' => $this->lastName?->value,
            'email' => $this->email?->value,
            'avatar' => $this->avatar?->value,
            'phone' => $this->phone?->value,
        ];
    }
}
