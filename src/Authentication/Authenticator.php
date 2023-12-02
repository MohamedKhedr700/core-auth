<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatorInterface;
use Raid\Core\Auth\Exceptions\Authentication\InvalidChannelException;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
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
     *
     * @throws InvalidChannelException
     */
    public static function attempt(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authChannel = static::getChannel(static::channels(), $channel);

        return $authChannel::auth(static::authenticatable(), $credentials);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidChannelException
     */
    public static function login(AccountInterface $account, string $channel = null): AuthChannelInterface
    {
        $authChannel = static::getChannel(static::channels(), $channel);

        return $authChannel::authAccount(static::authenticatable(), $account);
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidChannelException
     */
    public static function verify(array $credentials, string $channel = null): AuthChannelInterface
    {
        $authChannel = static::getChannel(static::channels(), $channel);

        return $authChannel::verify(static::authenticatable(), $credentials);
    }
}
