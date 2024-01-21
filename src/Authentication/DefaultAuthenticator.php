<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Exceptions\Authentication\InvalidChannelException;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

class DefaultAuthenticator extends Authenticator
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidChannelException
     */
    public static function getChannel(array $channels, ?string $channel): string
    {
        $channelClass = static::getDefaultAuthChannel();

        if (! $channelClass) {
            $class = static::class;

            throw new InvalidChannelException("Authentication channel [{$channel}] is not supported by [{$class}].");
        }

        return $channelClass;
    }
}