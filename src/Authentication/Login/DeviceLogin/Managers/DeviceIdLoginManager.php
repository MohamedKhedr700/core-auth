<?php

namespace Raid\Core\Auth\Authentication\Login\DeviceLogin\Managers;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\LoginManager as LoginManagerEnum;

class DeviceIdLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = LoginManagerEnum::DEVICE_ID;

    /**
     * {@inheritdoc}
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface
    {
        $device = parent::fetchUser($accountable, $credentials);

        return $device ? $accountable->update($device->accountId(), $credentials) : $accountable->create($credentials);
    }
}
