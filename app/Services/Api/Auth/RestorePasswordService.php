<?php

declare(strict_types=1);

namespace App\Services\Api\Auth;

use App\Data\Auth\RestorePasswordData;
use App\Mail\Admin\Auth\SendRestoreLinkEmail;
use App\Models\Auth\AuthModel;
use App\Models\Code;
use App\Models\Enums\AppGuardType;
use App\Models\Enums\CodeType;
use App\Repositories\Base\BaseModelRepository;
use App\Repositories\Patterns\ModelRepositoryFactory;
use Illuminate\Support\Facades\Mail;

final class RestorePasswordService
{
    public function link(string $email, AppGuardType $guard = AppGuardType::API): void
    {
        /** @var BaseModelRepository $authModelRepository */
        $authModelRepository = ModelRepositoryFactory::make(auth()->guard($guard->value)->getProvider()->getModel());

        /** @var AuthModel $foundModel */
        $foundModel = $authModelRepository->findOrFail($email, 'email');

        $codeToken = $foundModel->generateToken(CodeType::RESTORE_PASSWORD_LINK, $guard);

        Mail::to($foundModel->email)->send(new SendRestoreLinkEmail($foundModel, $codeToken));
    }

    public function restore(RestorePasswordData $data, AppGuardType $guard = AppGuardType::API): void
    {
        /** @var Code $codeRepository */
        $codeRepository = ModelRepositoryFactory::make(Code::class);
        /** @var Code $foundCode */
        $foundCode = $codeRepository->findOrFail($data->token, 'token');

        $foundCode->codeAble->restorePassword($data->password);

        $foundCode->delete();
    }
}
