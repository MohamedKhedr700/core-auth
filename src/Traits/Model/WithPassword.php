<?php

namespace Raid\Core\Auth\Traits\Model;

use Illuminate\Support\Facades\Hash;

trait WithPassword
{
    /**
     * Set password attribute.
     */
    public function setPasswordAttribute(string $password): void
    {
        $this->forceFillAttribute('password', bcrypt($password));
    }

    /**
     * Check if the given password is matching the current one.
     */
    public function isMatchingPassword(string $password): bool
    {
        return Hash::check($password, $this->attribute('password'));
    }
}
