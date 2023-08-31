<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;

trait Loginable
{
    /**
     * Check if an account is active to login and authenticated.
     * Throw login exceptions if failed login.
     */
    public function isLoginActive(): bool
    {
//        if ($this->attribute('disabled')) {
//            throw new LoginException(__('disabled'));
//        }

        return true;
    }
}
