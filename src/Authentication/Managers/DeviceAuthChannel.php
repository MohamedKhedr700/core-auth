<?php

namespace Raid\Core\Auth\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\AuthChannel;
use Raid\Core\Auth\Models\Authentication\Enum\Channel;

class DeviceAuthChannel extends AuthChannel implements AuthChannelInterface
{
    /**
     * {@inheritdoc}
     */
    public const CHANNEL = Channel::DEVICE;
}
