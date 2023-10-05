<?php

namespace Raid\Core\Auth\Authentication\Login\DeviceLogin;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Authentication\Login\LoginProvider;
use Raid\Core\Auth\Models\Authentication\Enum\LoginProvider as LoginProviderEnum;

class DeviceLoginProvider extends LoginProvider implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const PROVIDER = LoginProviderEnum::DEVICE;
}
