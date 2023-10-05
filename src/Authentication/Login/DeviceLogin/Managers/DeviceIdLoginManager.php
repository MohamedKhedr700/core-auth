<?php

namespace Raid\Core\Auth\Authentication\Login\DeviceLogin\Managers;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Models\Authentication\Enum\LoginColumn;

class DeviceIdLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * @const string
     */
    public const COLUMN = LoginColumn::DEVICE_ID;

    /**
     * {@inheritdoc}
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface
    {
        $device = parent::fetchUser($accountable, $credentials);

        return $device ? $accountable->update($device->accountId(), $credentials) : $accountable->create($credentials);
    }
}
