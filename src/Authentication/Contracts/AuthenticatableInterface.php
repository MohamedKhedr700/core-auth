<?php

namespace Raid\Core\Auth\Authentication\Contracts;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface AuthenticatableInterface
{
    /**
     * Attempt to authenticate with credentials.
     */
    public static function attempt(array $credentials, string $channel = null): AuthChannelInterface;

    /**
     * Login with an account model.
     */
    public static function login(AccountInterface $account, string $channel = null): AuthChannelInterface;

    /**
     * Get authenticator.
     */
    public static function getAuthenticator(): ?string;

    /**
     * Get an account by key and value.
     */
    public function getAccount(string $key, mixed $value): ?AccountInterface;
}
