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
     * Get channel.
     */
    public function getChannel(array $channels, ?string $channel): ?string;

    /**
     * Get an authentication channel.
     */
    public function getAuthChannel(array $channels, string $channel): ?string;
}
