<?php

namespace Raid\Core\Auth\Authentication\Contracts;

interface AuthenticatorInterface
{
    /**
     * Get authenticator name.
     */
    public static function authenticator(): string;

    /**
     * Get an authenticatable model.
     */
    public static function authenticatable(): string;

    /**
     * Get authenticator channels.
     */
    public function channels(): array;

    /**
     * Attempt to authenticate.
     */
    public function attempt(array $credentials, string $channel = null): AuthenticatorInterface;

    /**
     * Verify credentials.
     */
    public function verify(array $credentials, string $channel = null): AuthenticatorInterface;
}