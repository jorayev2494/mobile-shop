<?php

declare(strict_types=1);

namespace Project\Domains\Client\Authentication\Domain\Code;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface CodeRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findByCode(int $code): ?Code;

    public function save(Code $code): void;
    public function delete(Code $code): void;
}
