<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\InvalidChannelException;
use Raid\Core\Auth\Utilities\AuthUtility;

trait WithChannels
{
    /**
     * {@inheritdoc}
     */
    public function channels(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidChannelException
     */
    public function findChannel(array $channels, ?string $channel): string
    {
        $channelClass = $channel ? $this->getChannel($channels, $channel) : AuthUtility::getDefaultAuthChannel();

        if (! $channelClass) {
            $class = static::class;

            throw new InvalidChannelException("Authentication channel [{$channel}] is not supported by [{$class}].");
        }

        return $channelClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getChannel(array $channels, string $channel): ?string
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
