<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatorInterface;
use Raid\Core\Auth\Traits\Authentication\WithChannels;

abstract class Authenticator implements AuthenticatorInterface
{
    use WithChannels;

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
    public function attempt(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authChannel = $this->findChannel($this->channels(), $channel);

        return $authChannel::auth(static::authenticatable(), $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public function verify(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authChannel = $this->findChannel($this->channels(), $channel);

        return $authChannel::verify(static::authenticatable(), $credentials);
    }
}
