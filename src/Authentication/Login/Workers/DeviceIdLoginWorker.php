<?php

namespace Raid\Core\Auth\Authentication\Login\Workers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginWorkerInterface;
use Raid\Core\Auth\Authentication\Login\LoginWorker;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Enum\Worker;

class DeviceIdLoginWorker extends LoginWorker implements LoginWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::DEVICE_ID;

    /**
     * {@inheritdoc}
     */
    public function find(AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $device = parent::find($accountable, $credentials);

        return $device ? $accountable->update($device->accountId(), $credentials) : $accountable->create($credentials);
    }
}
