<?php

namespace Raid\Core\Auth\Authentication\Workers;

use Raid\Core\Auth\Authentication\AuthWorker;
use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Enums\Worker;

class DeviceIdAuthWorker extends AuthWorker implements AuthWorkerInterface
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
