<?php

namespace Raid\Core\AuthAuthentication\Login\DeviceLogin\Manager;

use Raid\Core\AuthAuthentication\Contracts\AccountInterface;
use Raid\Core\AuthAuthentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\AuthAuthentication\Login\LoginManager;
use Raid\Core\AuthModels\Authentication\Enum\LoginColumn;
use Raid\Core\AuthRepositories\Contracts\RepositoryInterface;

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
