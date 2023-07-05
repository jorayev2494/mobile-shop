<?php

declare(strict_types=1);

namespace App\Services\Api;

use App\Data\Models\AdminData;
use App\Data\Profile\ChangePasswordData;
use App\Models\Admin;
use App\Models\File;
use App\Services\Api\Contracts\ProfileService as ContractsProfileService;
use Illuminate\Support\Facades\Hash;
use Project\Shared\Domain\FilesystemInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProfileService implements ContractsProfileService
{
    public function __construct(
        private readonly FilesystemInterface $filesystem,
    )
    {
        
    }
    public function show(Admin $authModel): Admin
    {
        return $authModel;
    }

    public function update(Admin $authModel, AdminData $data): Admin
    {
        /** @var Admin $profile */
        $authModel->update($data->except('avatar')->toArray());

        if ($data->avatar !== null) {
            /** @var File $avatar */
            if (($avatar = $authModel->avatar) !== null) {
                $this->filesystem->deleteFile($authModel->avatarPath(), $avatar->name);
                $avatar->delete();
            }
            $avatar = $this->filesystem->uploadFile($authModel->avatarPath(), $data->avatar);
            $authModel->avatar()->save($avatar);
        }

        return $authModel->fresh('avatar')->append('full_name');
    }

    public function changePassword(Admin $authModel, ChangePasswordData $data): void
    {
        if (! Hash::check($data->current_password, $authModel->password)) {
            throw new BadRequestException('Current password is invalid!');
        }

        $authModel->restorePassword($data->password);
    }
}
