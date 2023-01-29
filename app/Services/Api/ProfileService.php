<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Data\Models\AdminData;
use App\Data\Profile\ChangePasswordData;
use App\Models\Admin;
use App\Services\Api\Contracts\ProfileService as ContractsProfileService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProfileService implements ContractsProfileService
{
    public function show(Admin $authModel): Admin
    {
        return $authModel;
    }

    public function update(Admin $authModel, AdminData $data): Admin
    {
        $authModel->update($data->toArray());

        return $authModel;
    }

    public function changePassword(Admin $authModel, ChangePasswordData $data): void
    {
        if (! Hash::check($data->current_password, $authModel->password)) {
            throw new BadRequestException('Current password is invalid!');
        }

        $authModel->restorePassword($data->password);
    }
}
