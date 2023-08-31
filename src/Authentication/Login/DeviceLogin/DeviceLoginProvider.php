<?php

namespace Raid\Core\AuthAuthentication\Login\DeviceLogin;

use Raid\Core\AuthAuthentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\AuthAuthentication\Login\LoginProvider;
use Raid\Core\AuthModels\Authentication\Enum\LoginType;

class DeviceLoginProvider extends LoginProvider implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const LOGIN_TYPE = LoginType::DEVICE;
}
