<?php

declare(strict_types=1);

namespace App\Services\Api\Contracts;

use App\Data\Models\AdminData;
use App\Data\Profile\ChangePasswordData;
use App\Models\Admin;

interface ProfileService
{
    public function show(Admin $authModel): Admin;

    public function update(Admin $authModel, AdminData $data): Admin;

    public function changePassword(Admin $authModel, ChangePasswordData $data): void;
}
