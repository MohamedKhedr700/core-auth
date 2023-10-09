<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatorInterface;
use Raid\Core\Auth\Exceptions\Authentication\InvalidAuthenticationChannelException;

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
     * Accountable model.
     */
    protected AuthenticatableInterface $authenticatable;

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
    public function attempt(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authChannel = $this->findChannel($channel);

        return $authChannel::auth(static::authenticatable(), $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public function verify(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authChannel = $this->findChannel($channel);

        return $authChannel::verify(static::authenticatable(), $credentials);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidAuthenticationChannelException
     */
    public function findChannel(string $channel): string
    {
        foreach ($this->channels() as $channelClass) {
            if ($channelClass::channel() !== $channel) {
                continue;
            }

            return $channel;
        }

        $class = static::class;

        throw new InvalidAuthenticationChannelException("Authentication channel [{$channel}] is not supported by [{$class}].");
    }
}