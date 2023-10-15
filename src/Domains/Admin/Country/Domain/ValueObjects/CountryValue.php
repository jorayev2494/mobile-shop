<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Country\Domain\ValueObjects;

use Project\Shared\Domain\ValueObject\StringValueObject;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class CountryValue extends StringValueObject
{
}
