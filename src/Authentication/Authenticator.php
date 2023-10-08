<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthenticatorInterface;

abstract class Authenticator implements AuthenticatorInterface
{
    /**
     * Authenticator name.
     */
    public const AUTHENTICATOR = '';

    /**
     * Authenticatable model.
     */
    public const AUTHENTICATABLE = '';

    /**
     * {@inheritdoc}
     */
    public static function authenticator(): string
    {
        return static::AUTHENTICATOR;
    }

    /**
     * {@inheritdoc}
     */
    public static function authenticatable(): string
    {
        return static::AUTHENTICATABLE;
    }

    /**
     * {@inheritdoc}
     */
    public function channels(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attempt(array $credentials, string $channel = null): AuthenticatorInterface
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function verify(array $credentials, string $channel = null): AuthenticatorInterface
    {
        return $this;
    }
}