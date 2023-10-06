<?php

namespace Raid\Core\Auth\Authentication\Login\Managers;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\Manager;

class DeviceLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = Manager::DEVICE;
}
