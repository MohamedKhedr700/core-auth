<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Exceptions\Authentication\AuthenticationException;

trait WithAuthenticate
{
    /**
     * Check if an account is active to authenticate.
     * Throw Authentication exception if failed to authenticate.
     */
    public function isAuthenticated(): void
    {
        //        if ($this->attribute('banned', false)) {
        //            throw new AuthenticationException(__('Account is banned.'));
        //        }
    }
}
