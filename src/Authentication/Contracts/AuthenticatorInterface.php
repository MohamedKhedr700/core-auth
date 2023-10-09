<?php

namespace Raid\Core\Auth\Authentication\Contracts;

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
    public static function channels(): array;

    /**
     * Attempt to authenticate with credentials and channel.
     */
    public static function attempt(array $credentials, string $channel = null): AuthChannelInterface;

    /**
     * Verify credentials with a channel.
     */
    public static function verify(array $credentials, string $channel = null): AuthChannelInterface;

    /**
     * Get channel.
     */
    public static function getChannel(array $channels, ?string $channel): ?string;

    /**
     * Get an authentication channel.
     */
    public static function getAuthChannel(array $channels, string $channel): ?string;
}
