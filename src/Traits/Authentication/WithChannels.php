<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\InvalidChannelException;
use Raid\Core\Auth\Utilities\AuthUtility;

trait WithChannels
{
    /**
     * Authenticator default channel.
     */
    public const DEFAULT_CHANNEL = null;

    /**
     * Authenticator channels.
     */
    public const CHANNELS = [];

    /**
     * {@inheritdoc}
     */
    public static function defaultChannel(): ?string
    {
        return static::DEFAULT_CHANNEL;
    }

    /**
     * {@inheritdoc}
     */
    public static function channels(): array
    {
        return static::CHANNELS;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidChannelException
     */
    public static function getChannel(array $channels, ?string $channel): string
    {
        $channelClass = $channel ?
            static::getAuthChannel($channels, $channel) :
            static::getDefaultAuthChannel();

        if (! $channelClass) {
            $class = static::class;

            throw new InvalidChannelException("Authentication channel [{$channel}] is not configured for class [{$class}].");
        }

        return $channelClass;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAuthChannel(array $channels, string $channel): ?string
    {
        foreach ($channels as $channelClass) {
            if ($channelClass::channel() !== $channel) {
                continue;
            }

            return $channelClass;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDefaultAuthChannel(): ?string
    {
        return static::defaultChannel() ?: AuthUtility::getDefaultAuthChannel();
    }
}
