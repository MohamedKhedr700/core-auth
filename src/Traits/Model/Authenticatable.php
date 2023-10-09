<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Facades\Authentication;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Utilities\AuthUtility;

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
     * Get authenticator.
     */
    public static function getAuthenticator(): ?string
    {
        return config('authentication.authenticators.' . static::class, AuthUtility::getDefaultAuthChannel());
    }

    /**
     * Find an account by key and value.
     */
    public function findAccount(string $key, mixed $value): ?AccountInterface
    {
        return $this->where($key, $value)->first();
    }
}
