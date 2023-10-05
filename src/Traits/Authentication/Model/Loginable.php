<?php

namespace Raid\Core\Auth\Traits\Authentication\Model;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\Auth\Facades\Authentication;

trait Loginable
{
    /**
     * Log in with credentials or instance of an account.
     */
    public static function attempt(array|AccountInterface $credentials): LoginProviderInterface
    {
        $method = $credentials instanceof AccountInterface ? 'loginAccount' : 'login';

        return static::{$method}($credentials);
    }

    /**
     * Log in with credentials.
     */
    public static function login(array $credentials): LoginProviderInterface
    {
        return Authentication::attempt(static::class, $credentials);
    }

    /**
     * Log in with an account model.
     */
    public static function loginAccount(AccountInterface $account): LoginProviderInterface
    {
        return Authentication::attemptAccount(static::class, $account);
    }

    /**
     * Check if an account is active to log in and authenticated.
     * Throw login exceptions if failed log in.
     */
    public function isAuthenticated(): void
    {
        //        if ($this->attribute('disabled')) {
        //            throw new LoginException(__('disabled'));
        //        }
    }
}
