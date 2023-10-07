<?php

namespace Raid\Core\Auth\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\AuthManager;
use Raid\Core\Auth\Models\Authentication\Enum\Manager;

class DeviceAuthManager extends AuthManager implements AuthManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = Manager::DEVICE;
}
