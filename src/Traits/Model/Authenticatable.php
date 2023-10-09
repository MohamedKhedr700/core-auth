<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Exceptions\Authentication\AuthenticationException;
use Raid\Core\Auth\Facades\Authentication;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait Authenticatable
{
    /**
     * Authenticate with credentials or instance of an account.
     */
    public static function auth(array|AccountInterface $credentials): AuthChannelInterface
    {
        $method = $credentials instanceof AccountInterface ? 'authenticateAccount' : 'authenticate';

        return static::{$method}($credentials);
    }

    /**
     * Authenticate with credentials.
     */
    public static function authenticate(array $credentials): AuthChannelInterface
    {
        return Authentication::auth(static::class, $credentials);
    }

    /**
     * Authenticate with an account model.
     */
    public static function authenticateAccount(AccountInterface $account): AuthChannelInterface
    {
        return Authentication::authAccount(static::class, $account);
    }

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
