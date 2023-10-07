<?php

namespace Raid\Core\Auth\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\Manager;

class DeviceLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = Manager::DEVICE;
}
