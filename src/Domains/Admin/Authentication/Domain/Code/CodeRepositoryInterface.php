<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Domain\Code;

use App\Repositories\Contracts\BaseEntityRepositoryInterface;

interface CodeRepositoryInterface extends BaseEntityRepositoryInterface
{
    public function findByToken(string $token): ?Code;

    public function save(Code $code): void;
    public function delete(Code $code): void;
}
