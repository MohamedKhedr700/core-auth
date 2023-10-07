<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Authentication\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\Auth\Facades\Authentication;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait Loginable
{
    /**
     * Log in with credentials or instance of an account.
     */
    public static function attempt(array|AccountInterface $credentials): LoginManagerInterface
    {
        $method = $credentials instanceof AccountInterface ? 'loginAccount' : 'login';

        return static::{$method}($credentials);
    }

    /**
     * Log in with credentials.
     */
    public static function login(array $credentials): LoginManagerInterface
    {
        return Authentication::attempt(static::class, $credentials);
    }

    /**
     * Log in with an account model.
     */
    public static function loginAccount(AccountInterface $account): LoginManagerInterface
    {
        return Authentication::attemptAccount(static::class, $account);
    }

    /**
     * Check if an account is active to log-in and authenticated.
     * Throw login exceptions if failed log-in.
     */
    public function isAuthenticated(): void
    {
        //        if ($this->attribute('disabled')) {
        //            throw new LoginException(__('disabled'));
        //        }
    }
}
