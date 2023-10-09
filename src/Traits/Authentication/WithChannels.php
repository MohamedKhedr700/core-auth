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
    public function findChannel(string $channel): string
    {
        $channelClass =  $this->getChannel($channel) ?? $this->getDefaultChannel();

        if (! $channelClass) {
            $class = static::class;

            throw new InvalidAuthenticationChannelException("Authentication channel [{$channel}] is not supported by [{$class}].");
        }

        return $channelClass;
    }

    /**
     * Get channel.
     */
    public function getChannel(string $channel): ?string
    {
        foreach ($this->channels() as $channelClass) {
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