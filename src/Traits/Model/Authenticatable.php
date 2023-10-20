<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Exceptions\Authentication\InvalidAuthenticatorException;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait Authenticatable
{
    /**
     * Attempt to authenticate with credentials.
     *
     * @throws InvalidAuthenticatorException
     */
    public static function attempt(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authenticator = static::getAuthenticator();

        if (! $authenticator) {
            throw new InvalidAuthenticatorException('No authenticator is defined for '.static::class);
        }

        return $authenticator::attempt($credentials, $channel);
    }

    /**
     * Login with an account model.
     *
     * @throws InvalidAuthenticatorException
     */
    public static function login(AccountInterface $account, string $channel = null): AuthChannelInterface
    {
        $authenticator = static::getAuthenticator();

        if (! $authenticator) {
            throw new InvalidAuthenticatorException('No authenticator is defined for '.static::class);
        }

        return $authenticator::login($account, $channel);
    }

    /**
     * Get authenticator.
     */
    public static function getAuthenticator(): ?string
    {
        return config('authentication.authenticators.'.static::class);
    }

    /**
     * Get an account by key and value.
     */
    public function getAccount(string $key, mixed $value): ?AccountInterface
    {
        return $this->where($key, $value)->first();
    }
}
