<?php

namespace Raid\Core\Auth\Traits\Authentication\Model;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Authentication\Login\SystemLogin\SystemLoginProvider;
use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;

trait Loginable
{
    /**
     * Login an account with credentials.
     */
    public static function login(array $credentials): LoginProviderInterface
    {
        return SystemLoginProvider::attempt(static::class, $credentials);
    }

    /**
     * Login an account with an account model.
     */
    public static function loginWithAccount(AccountInterface $account): LoginProviderInterface
    {
        return SystemLoginProvider::attemptWithAccount(static::class, $account);
    }

    /**
     * Check if an account is active to login and authenticated.
     * Throw login exceptions if failed login.
     */
    public function isAuthenticated(): void
    {
        //        if ($this->attribute('disabled')) {
        //            throw new LoginException(__('disabled'));
        //        }
    }
}
