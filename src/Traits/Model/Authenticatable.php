<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\Auth\Facades\Authentication;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait Authenticatable
{
    /**
     * Authenticate with credentials or instance of an account.
     */
    public static function auth(array|AccountInterface $credentials): AuthManagerInterface
    {
        $method = $credentials instanceof AccountInterface ? 'authenticateAccount' : 'authenticate';

        return static::{$method}($credentials);
    }

    /**
     * Authenticate with credentials.
     */
    public static function authenticate(array $credentials): AuthManagerInterface
    {
        return Authentication::auth(static::class, $credentials);
    }

    /**
     * Authenticate with an account model.
     */
    public static function authenticateAccount(AccountInterface $account): AuthManagerInterface
    {
        return Authentication::authAccount(static::class, $account);
    }

    /**
     * Check if an account is active to authenticate.
     * Throw login exceptions if failed authentication.
     */
    public function isAuthenticated(): void
    {
        //        if ($this->attribute('disabled')) {
        //            throw new LoginException(__('disabled'));
        //        }
    }
}
