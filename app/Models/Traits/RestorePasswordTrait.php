<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait RestorePasswordTrait
{
    public function restorePassword(string $password): bool
    {
        return $this->forceFill(compact('password'))->save();
    }

    public function sendRestoredPasswordNotification()
    {
        // $this->notify(new VerifyEmail);
    }
}
