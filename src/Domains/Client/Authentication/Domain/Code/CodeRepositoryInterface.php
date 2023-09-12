<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Code;

interface CodeRepositoryInterface
{
    public function findByCode(int $code): ?Code;

    public function save(Code $code): void;
    public function delete(Code $code): void;
}
