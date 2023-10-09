<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\InvalidAuthenticationChannelException;

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
     * @throws InvalidAuthenticationChannelException
     */
    public function findChannel(array $channels, ?string $channel): string
    {
        $channelClass =  $channel ? $this->getChannel($channels, $channel) : $this->getDefaultChannel();

        if (! $channelClass) {
            $class = static::class;

            throw new InvalidAuthenticationChannelException("Authentication channel [{$channel}] is not supported by [{$class}].");
        }

        return $channelClass;
    }

    /**
     * Get channel.
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

    /**
     * Get default channel.
     */
    public function getDefaultChannel(): ?string
    {
        return config('authentication.default_channel');
    }
}