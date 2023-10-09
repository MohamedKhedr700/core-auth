<?php

namespace Raid\Core\Auth\Authentication\Contracts;

use Raid\Core\Auth\Exceptions\Authentication\InvalidAuthenticationChannelException;

interface AuthenticatorInterface
{
    /**
     * Get authenticator name.
     */
    public static function authenticator(): string;

    /**
     * Get an authenticatable class.
     */
    public static function authenticatable(): string;

    /**
     * Get authenticator channels.
     */
    public function channels(): array;

    /**
     * Attempt to authenticate.
     */
    public function attempt(array $credentials, string $channel = null): AuthChannelInterface;

    /**
     * Verify credentials.
     */
    public function verify(array $credentials, string $channel = null): AuthChannelInterface;

    /**
     * Find a channel.
     */
    public function findChannel(string $channel): string;
}