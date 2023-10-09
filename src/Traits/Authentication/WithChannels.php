<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\InvalidChannelException;
use Raid\Core\Auth\Utilities\AuthUtility;

trait WithChannels
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidChannelException
     */
    public static function getChannel(array $channels, ?string $channel): string
    {
        $channelClass = $channel ? static::getAuthChannel($channels, $channel) : AuthUtility::getDefaultAuthChannel();

        if (! $channelClass) {
            $class = static::class;

            throw new InvalidChannelException("Authentication channel [{$channel}] is not supported by [{$class}].");
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
}
