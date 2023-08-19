<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain;

use Doctrine\ORM\Mapping as ORM;
use Project\Shared\Domain\Aggregate\AggregateRoot;

#[ORM\Entity]
#[ORM\Table(name: 'country_entity')]
class CountryEntity extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(name: 'uuid', type: 'string')]
    private string $uuid;

    #[ORM\Column(name: 'value', type: 'string')]
    private string $value;

    #[ORM\Column(name: 'iso', type: 'string', length: 3)]
    private string $iso;

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getISO(): string
    {
        return $this->iso;
    }

    public function setISO(string $iso): void
    {
        $this->iso = $iso;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'value' => $this->value,
            'iso' => $this->iso,
        ];
    }
}
