<?php

namespace Raid\Core\Auth\Authentication\Channels;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\AuthChannel;
use Raid\Core\Auth\Authentication\Rulers\MatchingPasswordRule;
use Raid\Core\Auth\Models\Authentication\Enums\Channel;

class SystemAuthChannel extends AuthChannel implements AuthChannelInterface
{
    /**
     * {@inheritdoc}
     */
    public const CHANNEL = Channel::SYSTEM;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            MatchingPasswordRule::class,
        ];
    }
}
